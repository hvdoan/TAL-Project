<?php

namespace App\Controller;

use App\Core\Verificator;
use App\Core\View;
use App\Model\Donation;
use App\Model\DonationTier;
use App\Model\Forum;
use App\Model\Message;
use App\Model\Tag;
use App\Model\User as UserModel;

class Main {

    public function home()
    {
        header("Location: /home");
    }

    public function contact()
    {
	    /* Get the connexion status */
	    $isConnected = Verificator::checkConnection();
	    /* Reload the login session time if connexion status is true */
	    if($isConnected)
		    Verificator::reloadConnection();
		
        $view = new View("contact");
	    $view->assign("isConnected", $isConnected);
    }
	
	public function forumList()
	{
		/* Get the connexion status */
		$isConnected = Verificator::checkConnection();
		/* Reload the login session time if connexion status is true */
		if($isConnected)
			Verificator::reloadConnection();
		
		$view = new View("forum-list");
		$forum = new Forum();
		$forumList = $forum->select(["id", "title", "content", "idUser", "idTag", "creationDate", "updateDate"], []);
		
		$view->assign("forumList", $forumList);
		$view->assign("isConnected", $isConnected);
	}
	
	public function forum()
	{
		/* Get the connexion status */
		$isConnected = Verificator::checkConnection();
		
		if($isConnected){
			Verificator::unsetSession();
		}
		
		if(empty($_GET["forum"])){
			header("Location: /forum-list");
		}else{
			$forumId = htmlspecialchars($_GET["forum"]);
		}
		
		$forum = new Forum();
		$tag = new Tag();
		$message = new Message();
		$answer = new Message();
		$user = new UserModel();
		
		/* Display users HTML Structure */
		if(isset($_POST["requestType"]) && $_POST["requestType"] == "displayForumFront")
		{
			$forum = $forum->select(["id", "title", "content", "idUser", "idTag", "creationDate", "updateDate"], ["id" => $forumId]);
			
			$object = $tag->setId(intval($forum[0]["idTag"]));
			if($object != false){
				$tag = $object;
			}
			
			$object = $user->setId(intval($forum[0]["idUser"]));
			if($object != false){
				$user = $object;
			}
			
			$messages   = $message->select(["id", "idUser", "idForum", "idMessage", "content", "updateDate"], ["idForum" => $forum[0]["id"]], " ORDER BY updateDate DESC");
			$answers    = $answer->select(["id", "idUser", "idMessage", "content", "updateDate"], ["idForum" => $forum[0]["id"]]);
			
			$htmlContent = "";
			
			$htmlContent .= "<div class='forum'>";
				$htmlContent .= "<div class='forumHeader imgBannerForum' type='" . $tag->getName() . "'>";
					$htmlContent .= "<div>";
						$htmlContent .= "<h2 class='border'>" . $tag->getName() . "</h2>";
						$htmlContent .= "<h1>" . $forum[0]["title"] . "</h1>";
					$htmlContent .= "</div>";
					$htmlContent .= "<h2>" . $user->getFirstname() . " " . $user->getLastname() . "</h2>";
				$htmlContent .= "</div>";
				$htmlContent .= "<div class='forumDescription'>" . $forum[0]["content"] . "</div>";
			$htmlContent .= "</div>";
			
			if($isConnected){
				$htmlContent .= "<div class='button'>";
					$htmlContent .= "<button id='add' class='btn btn-add' onclick='openForumFrontForm(" . $forum[0]["id"] . ")' type='button' name='button'>Nouveau</button>";
				$htmlContent .= "</div>";
			}else
				$htmlContent .= "<div class='button'>Vous devez vous connecter pour poster un message.</div>";

			$htmlContent .= "<div class='allMessage'>";
				if(empty($messages)):
					$htmlContent .= "<div class='message'>";
						$htmlContent .= "<div class='messageHeader'>";
							$htmlContent .= "<h2>Aucun message</h2>";
						$htmlContent .= "</div>";
					$htmlContent .= "</div>";
				else:
					foreach($messages as $message):
						$userMessage = new UserModel();
						$object = $userMessage->setId(intval($message["idUser"]));
						if($object != false){
							$userMessage = $object;
						}
						if($message["idMessage"] == 0){
							$htmlContent .= "<div id='" . $message["id"] . "' class='containerMessage'>";
								if($message["idMessage"] != 0){
									$htmlContent .= "<svg xmlns='http://www.w3.org/2000/svg' fill='currentColor' class='bi bi-arrow-return-right' viewBox='0 0 16 16'>";
										$htmlContent .= "<path fill-rule='evenodd' d='M1.5 1.5A.5.5 0 0 0 1 2v4.8a2.5 2.5 0 0 0 2.5 2.5h9.793l-3.347 3.346a.5.5 0 0 0 .708.708l4.2-4.2a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 8.3H3.5A1.5 1.5 0 0 1 2 6.8V2a.5.5 0 0 0-.5-.5z'/>";
									$htmlContent .= "</svg>";
								}
								$htmlContent .= "<div class='message " . (($message['idMessage'] != 0)? "answerMessage" : "") . "'>";
									$htmlContent .= "<div class='messageParent'>";
										if($isConnected){
											$htmlContent .= "<a class='pointer' onclick='deleteMessageFront(" . $forumId . ", " . $message['id'] . ")'>";
												$htmlContent .= "<svg xmlns='http://www.w3.org/2000/svg' fill='currentColor' class='bi bi-x' viewBox='0 0 16 16'>";
													$htmlContent .= "<path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>";
												$htmlContent .= "</svg>";
											$htmlContent .= "</a>";
										}
										if($isConnected){
											$htmlContent .= "<a class='pointer' onclick='deleteMessageFront(" . $forumId . ", " . $message['id'] . ")'>";
												$htmlContent .= "<img src='/SASS/asset/img/warning.png' alt='Signaler' class='warning' id='imgWarning" . $message['id'] . "'>";
											$htmlContent .= "</a>";
										}
										$htmlContent .= "<div class='headerMessage'>";
											$htmlContent .= "<div class='userMessage'>";
												$htmlContent .= "<div id='avatar-container' class='userAvatar'>";
												if($userMessage->getAvatar() != ""){
													$htmlContent .= "<img class='icon' src='data:;base64, " . $userMessage->getAvatar() . "' alt='avatar'>";
												}else
													$htmlContent .= "<i class='icon fa-solid fa-user-astronaut'></i>";
												$htmlContent .= "</div>";
												$htmlContent .= "<p class='bold'>" . $userMessage->getFirstname() . " " . $userMessage->getLastname() . "</p>";
											$htmlContent .= "</div>";
											$htmlContent .= "<div>";
												$htmlContent .= "<small>" . date("d/m/Y", strtotime($message["updateDate"])) . "</small>";
												if($isConnected)
													$htmlContent .= "<a class='pointer underlineHover' onclick='insertAnAnswer(" . $forumId . ", " . $message["id"] . ")'>Répondre</a>";
											$htmlContent .= "</div>";
										$htmlContent .= "</div>";
										$htmlContent .= "<div class='messageContent'>";
											$htmlContent .= "<p>" . $message["content"] . "</p>";
										$htmlContent .= "</div>";
									$htmlContent .= "</div>";
								if($isConnected){
									$htmlContent .= "<div id='divInsertAnswer" . $message["id"] . "' class='divInsertAnswer hidden'>";
										$htmlContent .= "<hr>";
										$htmlContent .= "<form>";
											$htmlContent .= "<input type='hidden' id='input-idForum' name='idForum' value='" . $forumId . "'>";
											$htmlContent .= "<input type='hidden' id='input-idUser' name='idUser' value='" . $_SESSION["id"] . "'>";
											$htmlContent .= "<input type='hidden' id='input-idMessage' name='idMessage' value='" . $message["id"] . "'>";
											$htmlContent .= "<input type='text' id='input-content' name='content' placeholder='Réponse...'>";
											$htmlContent .= "<button class='btn btn-primary' onclick='insertMessageFront(" . $forumId . ", " . $message["id"] . ")'>Répondre</button>";
										$htmlContent .= "</form>";
									$htmlContent .= "</div>";
								}
								$htmlContent .= "</div>";
							$htmlContent .= "</div>";
						}
						
						foreach($answers as $answer){
							if($answer["idMessage"] == $message["id"]){
								
								$userAnswer = new UserModel();
								$object = $userAnswer->setId(intval($answer["idUser"]));
								if($object != false){
									$userAnswer = $object;
								}
								
								$htmlContent .= "<div id='" . $answer["id"] . "' class='containerMessage'>";
									if($answer["idMessage"] != 0){
										$htmlContent .= "<svg xmlns='http://www.w3.org/2000/svg' fill='currentColor' class='bi bi-arrow-return-right' viewBox='0 0 16 16'>";
											$htmlContent .= "<path fill-rule='evenodd' d='M1.5 1.5A.5.5 0 0 0 1 2v4.8a2.5 2.5 0 0 0 2.5 2.5h9.793l-3.347 3.346a.5.5 0 0 0 .708.708l4.2-4.2a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 8.3H3.5A1.5 1.5 0 0 1 2 6.8V2a.5.5 0 0 0-.5-.5z'/>";
										$htmlContent .= "</svg>";
									}
									$htmlContent .= "<div class='message " . (($answer['idMessage'] != 0)? "answerMessage" : "") . "'>";
										$htmlContent .= "<div class='messageParent'>";
											if($isConnected){
												$htmlContent .= "<a class='pointer' onclick='deleteMessageFront(" . $forumId . ", " . $answer['id'] . ")'>";
													$htmlContent .= "<svg xmlns='http://www.w3.org/2000/svg' fill='currentColor' class='bi bi-x' viewBox='0 0 16 16'>";
														$htmlContent .= "<path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>";
													$htmlContent .= "</svg>";
												$htmlContent .= "</a>";
											}
											if($isConnected){
												$htmlContent .= "<a class='pointer' onclick='deleteMessageFront(" . $forumId . ", " . $answer['id'] . ")'>";
													$htmlContent .= "<img src='/SASS/asset/img/warning.png' alt='Signaler' class='warning' id='imgWarning" . $answer['id'] . "'>";
												$htmlContent .= "</a>";
											}
											$htmlContent .= "<div class='headerMessage'>";
												$htmlContent .= "<div class='userMessage'>";
													$htmlContent .= "<div id='avatar-container' class='userAvatar'>";
														if($userAnswer->getAvatar() != ""){
															$htmlContent .= "<img class='icon' src='data:;base64, " . $userAnswer->getAvatar() . "' alt='avatar'>";
														}else
															$htmlContent .= "<i class='icon fa-solid fa-user-astronaut'></i>";
													$htmlContent .= "</div>";
													$htmlContent .= "<p class='bold'>" . $userAnswer->getFirstname() . " " . $userAnswer->getLastname() . "</p>";
												$htmlContent .= "</div>";
												$htmlContent .= "<div>";
													$htmlContent .= "<small>" . date("d/m/Y", strtotime($answer["updateDate"])) . "</small>";
													if($isConnected)
														$htmlContent .= "<a class='pointer underlineHover' onclick='insertAnAnswer(" . $forumId . ", " . $answer["id"] . ")'>Répondre</a>";
												$htmlContent .= "</div>";
											$htmlContent .= "</div>";
											$htmlContent .= "<div class='messageContent'>";
												$htmlContent .= "<p>" . $answer["content"] . "</p>";
											$htmlContent .= "</div>";
									$htmlContent .= "</div>";
									if($isConnected){
										$htmlContent .= "<div id='divInsertAnswer" . $answer["id"] . "' class='divInsertAnswer hidden'>";
											$htmlContent .= "<hr>";
											$htmlContent .= "<form>";
												$htmlContent .= "<input type='hidden' id='input-idForum' name='idForum' value='" . $forumId . "'>";
												$htmlContent .= "<input type='hidden' id='input-idUser' name='idUser' value='" . $_SESSION["id"] . "'>";
												$htmlContent .= "<input type='hidden' id='input-idMessage' name='idMessage' value='" . $answer["id"] . "'>";
												$htmlContent .= "<input type='text' id='input-content' name='content' placeholder='Réponse...'>";
												$htmlContent .= "<button class='btn btn-primary' onclick='insertMessageFront(" . $forumId . ", " . $answer["id"] . ")'>Répondre</button>";
											$htmlContent .= "</form>";
										$htmlContent .= "</div>";
									}
									$htmlContent .= "</div>";
								$htmlContent .= "</div>";
							}
						}
					endforeach;
				endif;
				
			$htmlContent .= "</div>";
			echo $htmlContent;
		}
		else if((isset($_POST["requestType"]) ? $_POST["requestType"] == "insertMessageFront" : false) &&
				(isset($_POST["tokenForm"]) && isset($_SESSION["tokenForm"]) ? $_POST["tokenForm"] == $_SESSION["tokenForm"] : false)){
			if( (isset($_POST["messageIdUser"]) ? $_POST["messageIdUser"] != "" : false) &&
				(isset($_POST["messageIdForum"]) ? $_POST["messageIdForum"] != "" : false) &&
				(isset($_POST["messageIdMessage"]) ? $_POST["messageIdMessage"] != "" : false) &&
				(isset($_POST["messageContent"]) ? $_POST["messageContent"] != "" : false)){
				/* Creation of a message for the front forum */
				$message->setIdUser($_POST["messageIdUser"]);
				$message->setIdForum($_POST["messageIdForum"]);
				$message->setIdMessage($_POST["messageIdMessage"]);
				$message->setContent($_POST["messageContent"]);
				$message->creationDate();
				$message->updateDate();
				$message->save();
				
				$object = $message->setId(intval($message->getLastInsertId()));
				if($object != false){
					$message = $object;
				}
				
				
			}
		}else if( (isset($_POST["requestType"]) ? $_POST["requestType"] == "insertForumFront" : false) &&
			(isset($_POST["tokenForm"]) && isset($_SESSION["tokenForm"]) ? $_POST["tokenForm"] == $_SESSION["tokenForm"] : false)){
			if( (isset($_POST["forumTitle"]) ? $_POST["forumTitle"] != "" : false) &&
				(isset($_POST["forumContent"]) ? $_POST["forumContent"] != "" : false) &&
				(isset($_POST["forumIdUser"]) ? $_POST["forumIdUser"] != "" : false) &&
				(isset($_POST["forumIdTag"]) ? $_POST["forumIdTag"] != "" : false)){
				/* Creation of a forum */
				$forum->setTitle($_POST["forumTitle"]);
				$forum->setContent($_POST["forumContent"]);
				$forum->setIdUser($_POST["forumIdUser"]);
				$forum->setIdTag($_POST["forumIdTag"]);
				$forum->creationDate();
				$forum->updateDate();
				$forum->save();
				
				$object = $forum->setId(intval($forum->getLastInsertId()));
				if($object != false){
					$forum = $object;
				}
				
			}
		}
		else if((isset($_POST["requestType"]) && $_POST["requestType"] == "deleteMessageFront")){
			if(!$isConnected)
				header("Location: /login");
			else if(isset($_POST["idMessage"]) && $_POST["idMessage"] != "") {
				/* Delete a message */
				$object = $message->setId($_POST["idMessage"]);
				if ($object != false) {
					$message = $object;
				}
				
				$objectAnswer = new Message();
				$answers = $answer->select(["id"], ["idMessage" => $message->getId()]);
				
				if(!empty($answers)){
					foreach($answers as $answer){
						$object = $objectAnswer->setId($answer["id"]);
						if($object != false){
							$objectAnswer = $object;
						}
						$objectAnswer->delete();
					}
				}
				
				$message->delete();
			}
		}
		else if(isset($_POST["requestType"]) && $_POST["requestType"] == "openForumFrontForm"){
			if(!$isConnected){
				header("Location: /login");
			}else{
				$htmlContent = "";
				
				//$forumList = $forum->select(["id", "title"], []);
				
				$token = md5(uniqid());
				$_SESSION["tokenForm"] = $token;
				
				$htmlContent .= "<form class='form'>";
				
					// @CSRF
					$htmlContent .= "<input id='tokenForm' type='hidden' name='tokenForm' value='" . $token . "'>";
					
					/* Field header */
					$htmlContent .= "<div class='field-row'>";
						$htmlContent .= "<div class='field'>";
							$htmlContent .= "<h1>Création d'un nouveau message</h1>";
						$htmlContent .= "</div>";
					$htmlContent .= "</div>";
					
					/* Field content */
					$htmlContent .= "<div class='field-row'>";
						$htmlContent .= "<div class='field'>";
							$htmlContent .= "<label>Contenu du message</label>";
							$htmlContent .= "<textarea id='input-content' name='content' rows='5'></textarea>";
						$htmlContent .= "</div>";
					$htmlContent .= "</div>";
				
					/* Field hidden */
					$htmlContent .= "<input id='input-idUser' type='hidden' name='idUser' value='" . $_SESSION['id'] . "'>";
					$htmlContent .= "<input id='input-idMessage' type='hidden' name='idMessage' value='0'>";
					$htmlContent .= "<input id='input-idForum' type='hidden' name='idForum' value='" . $forumId . "'>";
				
					/* Field cta */
					$htmlContent .= "<div class='field-cta'>";
						$htmlContent .= "<input class='btn-form btn-form-cancel' onclick='closeMessageForm()' type='button' value='Annuler'>";
						$htmlContent .= "<input class='btn-form btn-form-validate' onclick='insertMessageFront(" . $forumId . ")' type='button' value='Créer'>";
					$htmlContent .= "</div>";
					
				$htmlContent .= "</form>";
				echo $htmlContent;
			}
		}else if(!isset($_POST["requestType"])){
			
			/* Reload the login session time if connexion status is true */
			if($isConnected)
				Verificator::reloadConnection();
			
			$view = new View("forum");
			$forum = new Forum();
			
			if(empty($_GET["forum"]))
				header("Location: /forum-list");
			else{
				$forumId = htmlspecialchars($_GET["forum"]);
				$forum = $forum->select(["id", "title", "content", "idUser", "idTag", "creationDate", "updateDate"], ["id" => $forumId]);
				
				$view->assign("forum", $forum);
				$view->assign("isConnected", $isConnected);
			}
		}
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
			
	        /* Get the connexion status */
	        $isConnected = Verificator::checkConnection();
	        /* Reload the login session time if connexion status is true */
	        if($isConnected)
		        Verificator::reloadConnection();
			
            $view->assign("donation", $amountDonation);
            $view->assign("listDonationTier", $listDonationTier);
	        $view->assign("isConnected", $isConnected);
        }
    }

    public function generic($data)
    {
	    /* Get the connexion status */
	    $isConnected = Verificator::checkConnection();
	    /* Reload the login session time if connexion status is true */
	    if($isConnected)
		    Verificator::reloadConnection();
		
        $view = new View("generic");
        $view->assign("data", $data);
	    $view->assign("isConnected", $isConnected);
    }
}