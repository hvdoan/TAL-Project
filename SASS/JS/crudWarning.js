/**************************************************
 * AJAX : DISPLAY WARNING
 ***************************************************/
function displayWarning()
{
	const requestType = "display";
	
	const request = new XMLHttpRequest();
	request.open('POST', '/warning-management');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			$("#warningList").html(request.responseText);
			
			$(document).ready(function (){
				$('#warningManagementTable').DataTable();
			});
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}`;
	request.send(body);
}

/**************************************************
 * AJAX : INSERT WARNING
 ***************************************************/
function insertWarning(token, idForum, idUser, idMessage)
{
	const requestType      = "insertWarning";
	const warningIdMessage = idMessage;
	const warningIdUser    = idUser;
	const warningStatus    = 1;
	const tokenForm        = token;
	
	const request = new XMLHttpRequest();
	request.open('POST', '/forum?forum=' + idForum);
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			alert("Merci, votre signalement a bien enregistré.");
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&tokenForm=${tokenForm}&warningIdMessage=${warningIdMessage}&warningIdUser=${warningIdUser}&warningStatus=${warningStatus}`;
	
	request.send(body);
}

/**************************************************
 * AJAX : UPDATE WARNING
 ***************************************************/
function updateWarning()
{
	const requestType      = "update";
	const warningId        = $('#input-id').val();
	const warningIdMessage = $('#input-idMessage').val();
	const warningIdUser    = $('#input-idUser').val();
	const warningStatus    = $('#input-status').val();
	const tokenForm        = $('#tokenForm').val();
	
	const request = new XMLHttpRequest();
	request.open('POST', '/warning-management');
	
	request.onreadystatechange = function(){
		if(request.readyState === 4)
		{
			displayWarning();
			closeWarningForm();
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&tokenForm=${tokenForm}&warningId=${warningId}&warningIdUser=${warningIdUser}&warningStatus=${warningStatus}&warningIdMessage=${warningIdMessage}`;
	
	request.send(body);
}
/***************************************************
 * AJAX : DELETE WARNING
 ***************************************************/
function deleteWarning(){
	const requestType   = "delete";
	let warningList        = $(".idWarning");
	let warningNameList    = [];
	let warningIdList      = [];
	
	for (let i = 0; i < warningList.length; i++){
		if (warningList[i].checked){
			warningIdList.push(warningList[i].name);
			warningNameList.push($("#" + warningList[i].name)[0].name);
		}
	}
	
	if(warningNameList.length > 0){
		if(confirm((`Êtes-vous sûr de vouloir supprimer le(s) warning(s) : ${warningNameList.join(", ")} ?`))){
			const request = new XMLHttpRequest();
			request.open('POST', '/warning-management');
			
			request.onreadystatechange = function()
			{
				if(request.readyState === 4)
				{
					displayWarning();
				}
			};
			
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			const body = `requestType=${requestType}&warningIdList=${warningIdList}`;
			
			request.send(body);
		}
	}else
		alert("Sélectionnez au minimum un signalement à supprimer.");
}

/**************************************************
 * AJAX : OPEN WARNING FORM
 ***************************************************/
function openWarningForm(id = "")
{
	const requestType = "openForm";
	
	const request = new XMLHttpRequest();
	request.open('POST', '/warning-management');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			console.log("AJAX : request open form completed");
			$("#ctnWarningForm").html(request.responseText);
			$("#ctnWarningForm").css("width", "100%");
			$("#ctnWarningForm").css("height", "100%");
			$("body").addClass("overflowHidden");
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&warningId=${id}`;
	
	request.send(body);
}

/**************************************************
 * CLOSE WARNING FORM
 ***************************************************/
function closeWarningForm()
{
	$("#ctnWarningForm").html("");
	$("#ctnWarningForm").css("width", "0");
	$("#ctnWarningForm").css("height", "0");
	$("body").removeClass("overflowHidden");
}
