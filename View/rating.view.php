<?php

use App\Model\User;

$user = new User();
$userRate = new User();
$object = $user->setId(intval($_SESSION["id"]));
if($object)
	$user = $object;
$counter = 0;

$token = md5(uniqid());
$_SESSION["tokenForm"] = $token;
?>
<div class="page">
	
	<div class="imgBanner"><h1>Avis</h1></div>
	
	<div class="vote">
		<div class="small" id="addVote">
			
			<div class="pouce">
				<div>
					<h2>Donnez un avis sur votre expérience !</h2>
					<small>C'est le meilleur soutient que vous pouvez nous apporter</small>
				</div>
				<img src="SASS/asset/img/positive-vote.png" alt="positive vote">
			</div>
			
			<div class="rate">
				<label>
					Commentaire :
					<input id="descriptionRating" type="text" name="description" placeholder="Laissez un commentaire avant de donner la note" required>
					<input id="idUserRating" type="hidden" value="<?=$_SESSION["id"]?>">
					<input id="tokenRating" type="hidden" value="<?=$token?>">
				</label>
				
				<div id="halfstarsReview"></div>
				<script>
					$("#halfstarsReview").rating({
						"half": true,
						"color": "#6fc7ff",
						"click": function (e) {
							console.log(e);
							$("#halfstarsInput").val(e.stars);
						}
					});
				</script>
			</div>
			
		</div>
		<div class="medium">
			<div>
				<?php foreach($this->data["rating"] as $rating):
					$counter++;
					$object = $userRate->setId(intval($rating["idUser"]));
					if($object)
						$userRate = $object;
					?>
				
					<div class="cardRating">
						<div class="cardHeader">
							<div id='avatar-container' class='userAvatar'>
								<?php
								if($userRate->getAvatar() != "")
									echo "<img class='icon' src='data:;base64, " . $userRate->getAvatar() . "' alt='avatar'>";
								else
									echo "<i class='icon fa-solid fa-user-astronaut'></i>";
								?>
							</div>
							
							<div>
								<div class="username">
									<?=$userRate->getFirstname() . " " . $userRate->getLastname()?>
								</div>
								<small><?=date("d/m/Y", strtotime($rating["updateDate"])); ?></small>
							</div>
						</div>
						
						<div class="cardContent">
							<p><?=$rating["description"]?></p>
						</div>
						
						<div class="cardRate">
							<div class="row">
								<div class="col-12 col-md-6" style="font-size: 2em;">
									<div id="halfstarsReview<?=$counter?>"></div>
								</div>
								<script>
									$("#halfstarsReview" + <?=$counter?>).rating({
										"half": true,
										"readonly": true,
										"value": <?=$rating["rate"]?>,
										"color": "#6fc7ff",
										"click": function (e) {
											console.log(e);
											$("#halfstarsInput" + <?=$counter?>).val(e.stars);
										}
									});
								</script>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			
			<div>
				<a class="btn btn-edit" href="/rating-list">Tous les avis</a>
			</div>
		</div>
	</div>
</div>