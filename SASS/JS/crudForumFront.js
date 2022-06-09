/**************************************************
 * AJAX : DISPLAY MESSAGE FRONT
 ***************************************************/
function displayForumFront(idForum)
{
	const requestType = "displayForumFront";
	
	const request = new XMLHttpRequest();
	request.open('POST', '/forum?forum=' + idForum);
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			if (request.responseText === "login")
				window.location.href = "/login";
			else
				$("#containerForumFront").html(request.responseText);
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}`;
	request.send(body);
	return true;
}

/**************************************************
 * AJAX : INSERT FORUM FRONT
 ***************************************************/
function insertForumFront(data)
{
	const requestType  = "insertForumFront";
	const forumTitle   = $('#input-title').val();
	const forumContent = $('#input-content').val();
	const forumIdUser  = $('#input-idUser').val();
	const forumIdTag   = $('#input-idTag').val();
	const tokenForm    = $('#tokenForm').val();
	
	const request = new XMLHttpRequest();
	request.open('POST', '/forum');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			if (request.responseText === "login")
				window.location.href = "/login";
			else
				window.location.href = "/forum";
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&tokenForm=${tokenForm}&data=${data}&forumTitle=${forumTitle}&forumContent=${forumContent}&forumIdUser=${forumIdUser}&forumIdTag=${forumIdTag}`;
	
	request.send(body);
}

/**************************************************
 * AJAX : INSERT MESSAGE FRONT
 ***************************************************/
function insertMessageFront(idForum, idMessage)
{
	const requestType      = "insertMessageFront";
	const messageIdUser    = $('#input-idUser').val();
	const messageIdForum   = $('#input-idForum').val();
	const messageIdMessage = $('#input-idMessage').val();
	const messageContent   = $('#input-content').val();
	const tokenForm        = $('#tokenForm').val();
	console.log(messageIdUser);
	console.log(messageIdForum);
	console.log(messageIdMessage);
	console.log(messageContent);
	console.log(idMessage);
	
	
	const request = new XMLHttpRequest();
	request.open('POST', '/forum?forum=' + idForum);
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			closeForumForm();
			displayForumFront(idForum);
			
			if(document.getElementById(request.responseText) !== undefined){
				// console.log($('#message' + request.responseText).innerHTML);
				// $('#message' + request.responseText).scrollIntoView({behavior: "smooth"});
				// document.querySelector('#message' + request.responseText).scrollIntoView({behavior: "smooth"});
				let a = $('#' + request.responseText);
				console.log(a);
				$('html, body').animate({
					scroll: a.offset()
				});
			}
			
			// let divNumber = request.responseText.toString();
			// console.log('message' + divNumber);
			// document.getElementById('message' + divNumber).scrollIntoView({behavior: "smooth"});
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&tokenForm=${tokenForm}&messageIdUser=${messageIdUser}&messageIdForum=${messageIdForum}&messageIdMessage=${messageIdMessage}&messageContent=${messageContent}`;
	
	request.send(body);
	return true;
}


/**************************************************
 * AJAX : INSERT MESSAGE FRONT
 ***************************************************/
function insertAnswerFront(idForum)
{
	const requestType      = "insertAnswerFront";
	const messageIdUser    = $('#input-idUser').val();
	const messageIdForum   = $('#input-idForum').val();
	const messageIdMessage = $('#input-idMessage').val();
	const messageContent   = $('#input-content').val();
	const tokenForm        = $('#tokenForm').val();
	console.log(messageIdUser);
	console.log(messageIdForum);
	console.log(messageIdMessage);
	console.log(messageContent);
	
	
	const request = new XMLHttpRequest();
	request.open('POST', '/forum?forum=' + idForum);
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			closeForumForm();
			displayForumFront(idForum);
			
			if(document.getElementById(request.responseText) !== undefined){
				// console.log($('#message' + request.responseText).innerHTML);
				// $('#message' + request.responseText).scrollIntoView({behavior: "smooth"});
				// document.querySelector('#message' + request.responseText).scrollIntoView({behavior: "smooth"});
				let a = $('#' + request.responseText);
				console.log(a);
				$('html, body').animate({
					scroll: a.offset()
				});
			}
			
			// let divNumber = request.responseText.toString();
			// console.log('message' + divNumber);
			// document.getElementById('message' + divNumber).scrollIntoView({behavior: "smooth"});
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&tokenForm=${tokenForm}&messageIdUser=${messageIdUser}&messageIdForum=${messageIdForum}&messageIdMessage=${messageIdMessage}&messageContent=${messageContent}`;
	
	request.send(body);
	return true;
}



function insertAnAnswer(idForum, idMessage){
	let imgWarning = document.getElementById('imgWarning' + idMessage);
	console.log(imgWarning);
	if($('#divInsertAnswer' + idMessage).hasClass('hidden')){
		$('#divInsertAnswer' + idMessage).removeClass("hidden");
		imgWarning.style.bottom = "85px";
	}else{
		$('#divInsertAnswer' + idMessage).addClass("hidden");
		imgWarning.style.bottom = "5px";
	}
}

/***************************************************
 * AJAX : DELETE MESSAGE FORUM FRONT
 ***************************************************/
function deleteMessageFront(idForum, idMessage){
	const requestType   = "deleteMessageFront";
	
	if(confirm((`Êtes-vous sûr de vouloir supprimer ce message ainsi que toutes ses réponses s'il y en a ?`))){
		const request = new XMLHttpRequest();
		request.open('POST', '/forum?forum=' + idForum);
		
		request.onreadystatechange = function()
		{
			if(request.readyState === 4)
			{
				displayForumFront(idForum);
				console.log("AJAX : request delete message completed");
			}
		};
		
		request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		const body = `requestType=${requestType}&idMessage=${idMessage}`;
		
		request.send(body);
	}
}

/**************************************************
 * AJAX : OPEN FORUM FORM
 ***************************************************/
function openForumFrontForm(idForum)
{
	const requestType = "openForumFrontForm";
	
	const request = new XMLHttpRequest();
	request.open('POST', '/forum?forum=' + idForum);
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
				$("#ctnForumFrontForm").html(request.responseText);
				$("#ctnForumFrontForm").css("width", "100%");
				$("#ctnForumFrontForm").css("height", "100%");
				console.log("AJAX : request open form completed");
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&forumId=${idForum}`;
	
	request.send(body);
	return true;
}

/**************************************************
 * CLOSE FORUM FORM
 ***************************************************/
function closeMessageForm()
{
	$("#ctnForumFrontForm").html("");
	$("#ctnForumFrontForm").css("width", "0");
	$("#ctnForumFrontForm").css("height", "0");
}
