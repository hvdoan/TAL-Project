<h1>DONATION</h1>

<div class="ctn">
    <?php
    if (count($this->data["listDonationTier"]) > 0)
    {
        foreach ($this->data["listDonationTier"] as $donationTier)
        {
    ?>
        <div class="ctn">
            <div class="row">
                <h1><?=$donationTier["price"] / 100?>€</h1>
                <input type="radio" name="donationTier" value="<?=$donationTier["id"]?>">
            </div>
            <h2><?=$donationTier["name"]?></h2>
            <p><?=$donationTier["description"]?></p>
        </div>
    <?php
        }
    }
    ?>
</div>

<span><?= $this->data["donation"] / 100 ?> €</span>
<span>Je veux faire une donation de <input id="donationAmount" type="text"></span>

<!-- Replace "test" with your own sandbox Business account app client ID -->
<script src="https://www.paypal.com/sdk/js?client-id=<?=PAYPALKEYCLIENT?>&currency=<?=PAYPALCURRENCY?>"></script>

<!-- Set up a container element for the button -->
<div id="paypal-button-container"></div>

<script>
    paypal.Buttons({

        // Sets up the transaction when a payment button is clicked
        createOrder: (data, actions) => {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: parseInt($("#donationAmount").val(), 10) // Can also reference a variable or function
                    }
                }]
            });
        },

        // Finalize the transaction after payer approval
        onApprove: (data, actions) => {
            return actions.order.capture().then(function(orderData) {
                // Successful capture! For dev/demo purposes:
                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                const transaction = orderData.purchase_units[0].payments.captures[0];
                alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
            });
        }
    }).render('#paypal-button-container');
</script>