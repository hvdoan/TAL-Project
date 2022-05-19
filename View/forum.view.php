<?php

use App\Model\Message;
use App\Model\Tag;
use App\Model\User;

//var_dump($this->data["forum"][0]["id"]);

$tag = new Tag();
$message = new Message();
$user = new User();
$object = $tag->setId(intval($this->data["forum"][0]["idTag"]));
if($object != false){
	$tag = $object;
}

$object = $user->setId(intval($this->data["forum"][0]["idUser"]));
if($object != false){
	$user = $object;
}

$messages = $message->select(["id", "idUser", "idForum", "idMessage", "content", "updateDate"], []);

?>

<div class="page">
	<div class="forum">
		<div class="forumHeader imgBannerForum" type="<?=$tag->getName()?>">
			<div>
				<h2 class="border"><?=$tag->getName()?></h2>
				<h1><?=$this->data["forum"][0]["title"]?></h1>
			</div>
			<h2><?=$user->getFirstname() . " " . $user->getLastname()?></h2>
		</div>
		<div class="forumDescription">
			<?=$this->data["forum"][0]["content"]?>
		</div>
	</div>
	
	<div class="allMessage">
		<?php foreach($messages as $message):
			$userMessage = new User();
			$object = $userMessage->setId(intval($message["idUser"]));
			if($object != false){
				$userMessage = $object;
			}
			?>
		
			<div class="containerMessage">
				<?php if($message["idMessage"] != 0):?>
					<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-return-right" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M1.5 1.5A.5.5 0 0 0 1 2v4.8a2.5 2.5 0 0 0 2.5 2.5h9.793l-3.347 3.346a.5.5 0 0 0 .708.708l4.2-4.2a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 8.3H3.5A1.5 1.5 0 0 1 2 6.8V2a.5.5 0 0 0-.5-.5z"/>
					</svg>
				<?php endif;?>
				<div class="message <?=($message["idMessage"] != 0)? "answerMessage" : ""?>">
					<?php if($_SESSION["id"] == $message["idUser"]):?>
						<a href="#">
							<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
								<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
							</svg>
						</a>
					<?php endif;?>
					<div class="headerMessage">
						<p class="bold"><?=$userMessage->getFirstname() . " " . $userMessage->getLastname()?></p>
						<small><?=$message["updateDate"]?></small>
						<a href="">Répondre</a>
					</div>
					<p><?=$message["content"]?></p>
				</div>
			</div>
		<?php endforeach;?>
	</div>
</div>