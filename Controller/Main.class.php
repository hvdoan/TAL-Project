<?php

namespace App\Controller;

use App\Core\View;
use App\Model\Donation;
use App\Model\DonationTier;

class Main {

    public function home()
    {
        header("Location: /home");
    }


    public function contact()
    {
        $view = new View("contact");
    }

    public function donation()
    {
        if(isset($_POST["requestType"]) && $_POST["requestType"] == "insert")
        {
            if(isset($_POST["price"]) && $_POST["price"] != "")
            {
                $donation = new Donation();

                $donation->setIdUser($_SESSION["id"]);
                $donation->setAmount(intval($_POST["price"]));
                $donation->setDate(date("Y-m-d"));
                $donation->save();
            }
        }
        else if(!isset($_POST["requestType"]))
        {
            $view               = new View("donation");
            $donation           = new Donation();
            $donationTier       = new DonationTier();

            $amountDonation     = 0;

            $listDonation       = $donation->select(["id"], []);
            $listDonationTier   = $donationTier->select(["id", "price", "name", "description"], []);

            for ($i = 0; $i < count($listDonation); $i++)
            {
                $object = $donation->setId(intval($listDonation[$i]["id"]));

                if ($object != false)
                {
                    $donation = $object;
                    $amountDonation += $donation->getAmount();
                }
            }

            $view->assign("donation", $amountDonation);
            $view->assign("listDonationTier", $listDonationTier);
        }
    }

    public function generic($data)
    {
        $view = new View("generic");
        $view->assign("data", $data);
    }
}