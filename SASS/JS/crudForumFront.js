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
 * AJAX : OPEN FORUM FORM
 ***************************************************/
function openForumFormFront(id = "")
{
	const requestType = "openFormFront";
	
	const request = new XMLHttpRequest();
	request.open('POST', '/forum-list');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			$("#ctnForumFormFront").html(request.responseText);
			$("#ctnForumFormFront").css("width", "300%");
			$("#ctnForumFormFront").css("height", "300%");
			$("#input-title").focus();
			$("body").addClass("overflowHidden");
			console.log("AJAX : request open form completed");
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&forumId=${id}`;
	
	request.send(body);
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
	request.open('POST', '/forum-list');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			window.location.href = "/forum-list";
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
	const messageIdUser    = $('#input-idUser' + idMessage).val();
	const messageIdForum   = $('#input-idForum' + idMessage).val();
	const messageIdMessage = $('#input-idMessage' + idMessage).val();
	const messageContent   = $('#input-content' + idMessage).val();
	const tokenForm        = $('#tokenForm' + idMessage).val();
	
	const request = new XMLHttpRequest();
	request.open('POST', '/forum?forum=' + idForum);
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			closeMessageForm();
			displayForumFront(idForum);
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&tokenForm=${tokenForm}&messageIdUser=${messageIdUser}&messageIdForum=${messageIdForum}&messageIdMessage=${messageIdMessage}&messageContent=${messageContent}`;
	
	request.send(body);
}

/**************************************************
 * AJAX : OPEN ANSWER FORM
 ***************************************************/
function insertAnAnswer(idForum, idMessage){
	let imgWarning = document.getElementById('imgWarning' + idMessage);
	if($('#divInsertAnswer' + idMessage).hasClass('hidden')){
		$('#divInsertAnswer' + idMessage).removeClass("hidden");
		imgWarning.style.bottom = "85px";
		$("#input-content" + idMessage).focus();
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
				$("#ctnForumFrontForm").css("width", "300%");
				$("#ctnForumFrontForm").css("height", "300%");
				$("#input-content0").focus();
				$("body").addClass("overflowHidden");
				console.log("AJAX : request open form completed");
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&forumId=${idForum}`;
	
	request.send(body);
	return true;
}

/**************************************************
 * CLOSE MESSAGE FORM
 ***************************************************/
function closeMessageForm()
{
	$("#ctnForumFrontForm").html("");
	$("#ctnForumFrontForm").css("width", "0");
	$("#ctnForumFrontForm").css("height", "0");
	$("body").removeClass("overflowHidden");
}

/**************************************************
 * CLOSE FORUM FORM
 ***************************************************/
function closeForumForm()
{
	$("#ctnForumFormFront").html("");
	$("#ctnForumFormFront").css("width", "0");
	$("#ctnForumFormFront").css("height", "0");
	$("body").removeClass("overflowHidden");
}
