<script src="../SASS/JS/donationView.js"></script>
<div class="page">
	
	<div class="imgBanner"><h1>DONATION</h1></div>
	
	<div class="cards" id="cards">
		<?php
		if(count($this->data["listDonationTier"]) > 0){
			$i = 0;
			foreach($this->data["listDonationTier"] as $donationTier){
				?>
				<div class="checked" onclick="checkSelf(this)" type="donation">
					<div>
						<h1><?=$donationTier["price"] / 100?> €</h1>
						<?php if($i == 0){ ?>
						<input class="donationTier" type="radio" name="donationTier" value="<?=$donationTier["price"]?>" checked hidden>
						<?php }else{ ?>
						<input class="donationTier" type="radio" name="donationTier" value="<?=$donationTier["price"]?>" hidden>
						<?php } ?>
					</div>
					<h1><?=$donationTier["name"]?></h1>
					<p><?=$donationTier["description"]?></p>
				</div>
				<?php
				$i++;
			}
		}
		?>
	</div>
	
	<?php if($this->data["isConnected"]):?>
		<!-- Replace "test" with your own sandbox Business account app client ID -->
		<script src="https://www.paypal.com/sdk/js?client-id=<?=PAYPALKEYCLIENT?>&currency=<?=PAYPALCURRENCY?>"></script>
		
		<!-- Set up a container element for the button -->
		<div id="paypal-button-container"></div>
		
		<script>
			/**************************************************
			 * AJAX : INSERT DONATION
			 ***************************************************/
			function insertDonation(price){
				const requestType = "insert";
				
				const request = new XMLHttpRequest();
				request.open('POST', '/donation');
				
				request.onreadystatechange = function (){
					if(request.readyState === 4){
						return true
					}
				};
				
				request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				const body = `requestType=${requestType}&price=${price}`;
				
				request.send(body);
			}
			
			function getDonationTierPrice(){
				let donationTierList = $(".donationTier");
				let amount = 0;
				
				for(let i = 0; i < donationTierList.length; i++){
					if(donationTierList[i].checked){
						amount = donationTierList[i].value;
					}
				}
				
				return amount;
			}
			
			paypal.Buttons({
				
				// Sets up the transaction when a payment button is clicked
				createOrder: (data, actions)=>{
					return actions.order.create({
						purchase_units: [{
							amount: {
								value: getDonationTierPrice() / 100//parseInt($("#donationAmount").val(), 10) // Can also reference a variable or function
							}
						}]
					});
				},
				
				// Finalize the transaction after payer approval
				onApprove: (data, actions)=>{
					return actions.order.capture().then(function (orderData){
						insertDonation(getDonationTierPrice());
					});
				}
			}).render('#paypal-button-container');
		</script>
	<?php else: ?>
		<div>
			<span>Vous devez vous connecter pour pouvoir faire une donation.</span>
		</div>
	<?php endif;?>
</div>