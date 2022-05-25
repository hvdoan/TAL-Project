<?php

namespace App\Controller;

use App\Model\User as UserModel;
use App\Model\Role;
use App\Model\Page;

class Search
{
    public function search()
    {
        if(isset($_POST["requestType"]) ? $_POST["requestType"] != "search" : false)
            header("Location: /home");

        if(isset($_POST["searchString"]) ? $_POST["searchString"] != "" : false)
        {
            $searchString = addslashes($_POST["searchString"]);
//            $searchString = "a";
            $listResult = [];

            /* Search in user section */
            if(in_array("MANAGE_USER", $_SESSION["permission"]))
                $listResult = $this->searchUser($searchString, $listResult);

            /* Search in role section */
            if(in_array("MANAGE_ROLE", $_SESSION["permission"]))
                $listResult = $this->searchRole($searchString, $listResult);

            /* Search in page section */
            if(in_array("MANAGE_PAGE", $_SESSION["permission"]))
                $listResult = $this->searchPage($searchString, $listResult);

            asort($listResult, SORT_REGULAR);

        /* Build search result container */
            $html = "<div id='searchResult'>";

            foreach ($listResult as $result)
            {
                $html .= "<a class='field' href='".$result["url"]."'>";
                $html .= "<div class='information-container'>";
                $html .= "<span>".$result["information"]."</span>";
                $html .= "</div>";
                $html .= "<div class='label-container'>";

                if($result["label"] == "utilisateur")
                    $html .= "<span class='label label-user'>".$result["label"]."</span>";
                else if($result["label"] == "role")
                    $html .= "<span class='label label-role'>".$result["label"]."</span>";
                else if($result["label"] == "page")
                    $html .= "<span class='label label-page'>".$result["label"]."</span>";
                else if($result["label"] == "configuration page")
                    $html .= "<span class='label label-configurationPage'>".$result["label"]."</span>";

                $html .= "</div>";
                $html .= "</a>";
            }

            /* Close search result container */
            $html .= "</div>";

            echo $html;
        }
    }

    private function sortResult($list):array
    {
        $newList = [];

        while(count($list))
        {
            $index = 0;

            for($i = 0; $i < count($list); $i++)
            {
                if (strcmp($list[$i][0], $list[0][0]))
                    $index = $i;
            }

            $newList[] = $list[$index];
        }

        return $list;
    }

    private function searchUser(string $searchString, array $listResult):array
    {
        $getColumns = [
            "firstname",
            "lastname",
        ];

        $searchByColumns = [
            "firstname",
            "lastname",
            "email"
        ];

        $user       = new UserModel();
        $listUser   = $user->selectLikeString($getColumns, [], $searchString, $searchByColumns);
        $html       = "";

        foreach ($listUser as $user)
        {
//            $html .= "
//                <div class='field'>
//                    <div class='information'>
//                        <span>".$user["firstname"]." ".$user["lastname"]."</span>
//                    </div>
//                    <span class='label-user'>UTILISATEUR</span>
//                </div>";

            $listResult[] = [
                "information" => $user["firstname"]." ".$user["lastname"],
                "label" => "utilisateur",
                "url" => "/user-management"
            ];
        }

        return $listResult;
    }

    private function searchRole(string $searchString, array $listResult):array
    {
        $getColumns = [
            "name"
        ];

        $searchByColumns = [
            "name"
        ];

        $role       = new Role();
        $listRole   = $role->selectLikeString($getColumns, [], $searchString, $searchByColumns);
        $html       = "";

        foreach ($listRole as $role)
        {
//            $html .= "
//                <div class='field'>
//                    <div class='information'>
//                        <span>".$role["name"]."</span>
//                    </div>
//                    <span class='label-role'>ROLE</span>
//                </div>";

            $listResult[] = [
                "information" => $role["name"],
                "label" => "role",
                "url" => "/role-management"
            ];
        }

        return $listResult;
    }

    private function searchPage(string $searchString, array $listResult):array
    {
        $getColumns = [
            "uri"
        ];

        $searchByColumns = [
            "uri"
        ];

        $page       = new Page();
        $listPage   = $page->selectLikeString($getColumns, [], $searchString, $searchByColumns);
        $html       = "";

        foreach ($listPage as $page)
        {
//            $html .= "
//                <div class='field'>
//                    <div class='information'>
//                        <span>".$page["uri"]."</span>
//                    </div>
//                    <span class='label-page'>PAGE</span>
//                </div>";

            $listResult[] = [
                "information" => str_replace("/", "", $page["uri"]),
                "label" => "page",
                "url" => $page["uri"]
            ];
            $listResult[] = [
                "information" => str_replace("/", "", $page["uri"]),
                "label" => "configuration page",
                "url" => "/page-management"
            ];
        }

        return $listResult;
    }
}