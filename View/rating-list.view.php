<?php

use App\Model\User;

$user = new User();
$userRate = new User();
$object = $user->setId(intval($_SESSION["id"]));
if($object)
	$user = $object;
$counter = 0;
?>
<div class="page">
	
	<div class="imgBanner"><h1>Tous les avis</h1></div>
	
	<div class="vote">
		<div class="large">
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
	</div>
</div>