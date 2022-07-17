<div class="page">
	
	<div class="imgBanner"><h1>Forums</h1></div>
	
	<?php if($this->data["isConnected"]){ ?>
		<div class='centerElement button'>
			<button id='add' class='btn btn-add' onclick='openForumFormFront()' type='button' name='button'>Nouveau</button>
		</div>
		
		<div id="ctnForumFormFront"></div>
	<?php } ?>
	
	<div class="cards" id="cards">
		<?php use App\Model\Message; use App\Model\Tag; use App\Model\User;
		
		if(count($this->data["forumList"]) > 0): ?>
			<?php foreach($this->data["forumList"] as $forum): ?>
				<?php
					$tag = new Tag();
					$message = new Message();
					$user = new User();
					$object = $tag->setId(intval($forum["idTag"]));
					
					if($object)
						$tag = $object;
					
					
					$numberOfMessages = count($message->select(["id"], ["idForum" => $forum["id"]]));
					$recentActivitys = $message->select(["updateDate"], ["idForum" => $forum["id"]]);
					$recentActivity = (!empty($recentActivitys)) ? $recentActivitys[0]["updateDate"] : $forum["updateDate"];
					foreach($recentActivitys as $Activity){
						if($Activity["updateDate"] >= $recentActivity){
							$recentActivity = $Activity["updateDate"];
						}
					}
				
				$object = $user->setId(intval($forum["idUser"]));
				
				if($object)
					$user = $object;
				?>
				
				<div type="forum" onclick="location.href = '/forum?forum=<?=$forum["id"]?>'">
					<div class="forumHeader imgBannerForum" type="<?=$tag->getName()?>">
						<h2 class="border boxShadow"><?=$tag->getName()?></h2>
						<h1><?=$forum["title"]?></h1>
					</div>
					<div class="informationContainer">
						<div>
							<label>Nombre de message(s) :</label>
							<p><?=$numberOfMessages?></p>
						</div>
						<div>
							<label>Dernière activité :</label>
							<p><?=$recentActivity?></p>
						</div>
						<div>
							<label>Auteur :</label>
							<p><?= $user->getFirstname() . " " . $user->getLastname()?></p>
						</div>
					</div>
					<hr>
					<div class="descriptionContainer">
						<label>Description :</label>
						<p><?=$forum["content"]?></p>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>