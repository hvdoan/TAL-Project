<?php

use App\Model\User;

$user = new User();
$userRate = new User();

if ($this->data["isConnected"]){
    $object = $user->setId(intval($_SESSION["id"]));
    if($object)
        $user = $object;
}

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
				<img src="Template/Castle Story/asset/img/positive-vote.png" alt="positive vote">
			</div>
			<?php if($this->data["isConnected"]):?>
				<?php if(empty($this->data["alreadyRated"])):?>
					<div class="rate">
						<label>
							Commentaire :
							<input id="descriptionRating" type="text" name="description" placeholder="Laissez un commentaire avant de donner la note" required>
							<input id="idUserRating" type="hidden" value="<?=$_SESSION["id"]?>">
							<input id="tokenRating" type="hidden" value="<?=$token?>">
						</label>
						
						<div class="stars">
							<span id="star1" class="fa fa-star" onclick="insertRatingStars(1)"></span>
							<span id="star2" class="fa fa-star" onclick="insertRatingStars(2)"></span>
							<span id="star3" class="fa fa-star" onclick="insertRatingStars(3)"></span>
							<span id="star4" class="fa fa-star" onclick="insertRatingStars(4)"></span>
							<span id="star5" class="fa fa-star" onclick="insertRatingStars(5)"></span>
						</div>
					</div>
				<?php else:?>
					<div style="padding: 2%;">
						Merci, vous avez déjà donné un avis sur notre jeu !
					</div>
				<?php endif;?>
			<?php else:?>
				<div style="padding: 2%;">
					Veuillez vous connecter pour laisser un avis
				</div>
			<?php endif;?>
			
			<script>
				let star1 = document.getElementById("star1");
				let star2 = document.getElementById("star2");
				let star3 = document.getElementById("star3");
				let star4 = document.getElementById("star4");
				let star5 = document.getElementById("star5");
				if(star1 != null){
					star1.addEventListener('mousemove', e => {
						addStar(1);
					});
					star1.addEventListener('mouseout', e => {
						removeStars();
					});
				}
				if(star2 != null){
					star2.addEventListener('mousemove', e => {
						addStar(2);
					});
					star2.addEventListener('mouseout', e => {
						removeStars();
					});
				}
				if(star3 != null){
					star3.addEventListener('mousemove', e => {
						addStar(3);
					});
					star3.addEventListener('mouseout', e => {
						removeStars();
					});
				}
				if(star4 != null){
					star4.addEventListener('mousemove', e => {
						addStar(4);
					});
					star4.addEventListener('mouseout', e => {
						removeStars();
					});
				}
				if(star5 != null){
					star5.addEventListener('mousemove', e => {
						addStar(5);
					});
					star5.addEventListener('mouseout', e => {
						removeStars();
					});
				}
			</script>
			
		</div>
		
		<div class="medium">
			<div>
				<div class="averageRate">
					Note : <?=$this->data["averageRatings"][0]["average"]?> <span class='fa fa-star starChecked'></span>
				</div>
			</div>
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
									<?= $userRate->getFirstname() . " " . $userRate->getLastname()?>
								</div>
								<small><?=date("d/m/Y", strtotime($rating["updateDate"])); ?></small>
							</div>
						</div>
						
						<div class="cardContent">
							<p><?=$rating["description"]?></p>
						</div>
						
						<div class="cardRate">
							
							<div id="stars<?=$counter?>"></div>
							
							<script>
								for(let i = 0; i < <?=$rating["rate"]?>; i++){
									document.getElementById("stars<?=$counter?>").innerHTML += "<span class='fa fa-star starChecked'></span>";
									if(i < 5 && i === <?=$rating["rate"]?> - 1){
										for(let j = 0; j < 5 - <?=$rating["rate"]?>; j++){
											document.getElementById("stars<?=$counter?>").innerHTML += "<span class='fa fa-star'></span>";
										}
									}
								}
							</script>
							
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