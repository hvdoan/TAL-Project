/**************************************************
 * AJAX : DISPLAY FORUM
 ***************************************************/
function displayForum()
{
	const requestType = "display";
	
	const request = new XMLHttpRequest();
	request.open('POST', '/forum-management');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			if (request.responseText === "login")
				window.location.href = "/login";
			else
			{
				$("#forumList").html(request.responseText);
				
				$(document).ready(function (){
					$('#forumManagementTable').DataTable();
				});
			}
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}`;
	request.send(body);
}

/**************************************************
 * AJAX : INSERT FORUM
 ***************************************************/
function insertForum(data)
{
	const requestType  = "insert";
	const forumTitle   = $('#input-title').val();
	const forumContent = $('#input-content').val();
	const forumIdUser  = $('#input-idUser').val();
	const forumIdTag   = $('#input-idTag').val();
	const tokenForm    = $('#tokenForm').val();
	
	const request = new XMLHttpRequest();
	request.open('POST', '/forum-management');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			if (request.responseText === "login")
				window.location.href = "/login";
			else
				window.location.href = "/forum-management";
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&tokenForm=${tokenForm}&data=${data}&forumTitle=${forumTitle}&forumContent=${forumContent}&forumIdUser=${forumIdUser}&forumIdTag=${forumIdTag}`;
	
	request.send(body);
}

/**************************************************
 * AJAX : UPDATE FORUM
 ***************************************************/
function updateForum()
{
	const requestType       = "update";
	const forumId           = $('#input-id').val();
	const forumTitle        = $('#input-title').val();
	const forumContent      = $('#input-content').val();
	const forumIdUser       = $('#input-idUser').val();
	const forumIdTag        = $('#input-idTag').val();
	const tokenForm         = $('#tokenForm').val();
	
	const request = new XMLHttpRequest();
	request.open('POST', '/forum-management');
	
	request.onreadystatechange = function(){
		if(request.readyState === 4)
		{
			if (request.responseText === "login")
				window.location.href = "/login";
			else
			{
				displayForum();
				closeForumFormBack();
				console.log(request.responseText);
			}
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');const body = `requestType=${requestType}&tokenForm=${tokenForm}&forumId=${forumId}&forumTitle=${forumTitle}&forumContent=${forumContent}&forumIdUser=${forumIdUser}&forumIdTag=${forumIdTag}`;
	
	request.send(body);
}
/***************************************************
 * AJAX : DELETE FORUM
 ***************************************************/
function deleteForum(){
	const requestType   = "delete";
	let forumList        = $(".idForum");
	let forumNameList    = [];
	let forumIdList      = [];
	
	for (let i = 0; i < forumList.length; i++){
		if (forumList[i].checked){
			forumIdList.push(forumList[i].name);
			forumNameList.push($("#" + forumList[i].name).html());
		}
	}
	
	if(forumNameList.length > 0){
		if(confirm((`Êtes-vous sûr de vouloir supprimer le(s) forum(s) : ${forumNameList.join(", ")} ainsi que toutes ses dépendances?`))){
			const request = new XMLHttpRequest();
			request.open('POST', '/forum-management');
			
			request.onreadystatechange = function()
			{
				if(request.readyState === 4)
				{
					if (request.responseText === "login")
						window.location.href = "/login";
					else
						displayForum();
				}
			};
			
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			const body = `requestType=${requestType}&forumIdList=${forumIdList}`;
			
			request.send(body);
		}
	}else{
		alert("Sélectionnez au minimum un message à supprimer.");
	}
}

/**************************************************
 * AJAX : OPEN FORUM FORM
 ***************************************************/
function openForumForm(id = "")
{
	const requestType = "openForm";
	
	const request = new XMLHttpRequest();
	request.open('POST', '/forum-management');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			if (request.responseText === "login")
				window.location.href = "/login";
			else
			{
				$("#ctnForumForm").html(request.responseText);
				$("#ctnForumForm").css("width", "100%");
				$("#ctnForumForm").css("height", "100%");
			}
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&forumId=${id}`;
	
	request.send(body);
}

/**************************************************
 * CLOSE FORUM FORM
 ***************************************************/
function closeForumFormBack()
{
	$("#ctnForumForm").html("");
	$("#ctnForumForm").css("width", "0");
	$("#ctnForumForm").css("height", "0");
}
