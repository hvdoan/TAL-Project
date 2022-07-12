/**************************************************
 * AJAX : DISPLAY MESSAGE
 ***************************************************/
function displayMessage()
{
	const requestType = "display";
	
	const request = new XMLHttpRequest();
	request.open('POST', '/message-management');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			if (request.responseText === "login")
				window.location.href = "/login";
			else
			{
				$("#messageList").html(request.responseText);
				
				$(document).ready(function (){
					$('#messageManagementTable').DataTable();
				});
			}
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}`;
	request.send(body);
}

/**************************************************
 * AJAX : INSERT MESSAGE
 ***************************************************/
function insertMessage(data)
{
	const requestType      = "insert";
	const messageIdUser    = $('#input-idUser').val();
	const messageIdForum   = $('#input-idForum').val();
	const messageIdMessage = $('#input-idMessage').val();
	const messageContent   = $('#input-content').val();
	const tokenForm        = $('#tokenForm').val();
	
	const request = new XMLHttpRequest();
	request.open('POST', '/message-management');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			console.log(request.responseText);
			if (request.responseText === "login")
				window.location.href = "/login";
			else
				window.location.href = "/message-management";
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&tokenForm=${tokenForm}&data=${data}&messageIdUser=${messageIdUser}&messageIdForum=${messageIdForum}&messageIdMessage=${messageIdMessage}&messageContent=${messageContent}`;
	
	request.send(body);
}

/**************************************************
 * AJAX : UPDATE MESSAGE
 ***************************************************/
function updateMessage()
{
	const requestType      = "update";
	const messageId        = $('#input-id').val();
	const messageIdUser    = $('#input-idUser').val();
	const messageIdForum   = $('#input-idForum').val();
	const messageIdMessage = $('#input-idMessage').val();
	const messageContent   = $('#input-content').val();
	const tokenForm        = $('#tokenForm').val();
	
	const request = new XMLHttpRequest();
	request.open('POST', '/message-management');
	
	request.onreadystatechange = function(){
		if(request.readyState === 4)
		{
			if (request.responseText === "login")
				window.location.href = "/login";
			else
			{
				displayMessage();
				closeMessageFormBack();
			}
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');const body = `requestType=${requestType}&tokenForm=${tokenForm}&messageId=${messageId}&messageIdUser=${messageIdUser}&messageIdForum=${messageIdForum}&messageIdMessage=${messageIdMessage}&messageContent=${messageContent}`;
	
	request.send(body);
}
/***************************************************
 * AJAX : DELETE MESSAGE
 ***************************************************/
function deleteMessage(){
	const requestType   = "delete";
	let messageList        = $(".idMessage");
	let messageNameList    = [];
	let messageIdList      = [];
	
	for (let i = 0; i < messageList.length; i++){
		if (messageList[i].checked){
			messageIdList.push(messageList[i].name);
			messageNameList.push($("#" + messageList[i].name)[0].name);
		}
	}
	
	if(messageNameList.length > 0){
		if(confirm((`Êtes-vous sûr de vouloir supprimer le(s) message(s) : ${messageNameList.join(", ")} ainsi que toutes ses dépendances ?`))){
			const request = new XMLHttpRequest();
			request.open('POST', '/message-management');
			
			request.onreadystatechange = function()
			{
				if(request.readyState === 4)
				{
					if (request.responseText === "login")
						window.location.href = "/login";
					else
						displayMessage();
				}
			};
			
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			const body = `requestType=${requestType}&messageIdList=${messageIdList}`;
			
			request.send(body);
		}
	}else{
		alert("Sélectionnez au minimum un message à supprimer.");
	}
}

/**************************************************
 * AJAX : OPEN MESSAGE FORM
 ***************************************************/
function openMessageForm(id = "")
{
	const requestType = "openForm";
	
	const request = new XMLHttpRequest();
	request.open('POST', '/message-management');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			if (request.responseText === "login")
				window.location.href = "/login";
			else
			{
				console.log("AJAX : request open form completed");
				$("#ctnMessageForm").html(request.responseText);
				$("#ctnMessageForm").css("width", "100%");
				$("#ctnMessageForm").css("height", "100%");
			}
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&messageId=${id}`;
	
	request.send(body);
}

/**************************************************
 * CLOSE MESSAGE FORM
 ***************************************************/
function closeMessageFormBack()
{
	console.log("AJAX : request close form completed");
	$("#ctnMessageForm").html("");
	$("#ctnMessageForm").css("width", "0");
	$("#ctnMessageForm").css("height", "0");
}
