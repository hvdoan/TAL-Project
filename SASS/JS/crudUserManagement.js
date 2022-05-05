/**************************************************
 * AJAX : DISPLAY USER
 ***************************************************/
function displayUser()
{
	const requestType = "display";
	
	const request = new XMLHttpRequest();
	request.open('POST', '/user-management');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			if (request.responseText === "login")
				window.location.href = "/login";
			else
			{
				$("#userList").html(request.responseText);

				$(document).ready(function (){
					$('#userManagementTable').DataTable();
				});
			}
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}`;
	request.send(body);
}

/**************************************************
 * AJAX : UPDATE USER
 ***************************************************/
function updateUser()
{
	const requestType       = "update";
	const userId            = $('#input-id').val();
	const userLastName      = $('#input-lastname').val();
	const userFirstname     = $('#input-firstname').val();
	const userEmail         = $('#input-email').val();
	const userIdRole        = $('#input-idRole').val();
	const tokenForm         = $('#tokenForm').val();
	
	const request = new XMLHttpRequest();
	request.open('POST', '/user-management');
	
	request.onreadystatechange = function(){
		if(request.readyState === 4)
		{
			if (request.responseText === "login")
				window.location.href = "/login";
			else
			{
				displayUser();
				closeUserForm();
				console.log(request.responseText);
			}
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&tokenForm=${tokenForm}&userId=${userId}&userLastname=${userLastName}&userFirstname=${userFirstname}&userEmail=${userEmail}&userIdRole=${userIdRole}`;
	
	request.send(body);
}

/**************************************************
 * AJAX : DELETE USER
 ***************************************************/
function deleteUser(){
	const requestType   = "delete";
	let userList        = $(".idUser");
	let userNameList    = [];
	let userIdList      = [];
	
	for (let i = 0; i < userList.length; i++){
		if (userList[i].checked){
			userIdList.push(userList[i].name);
			userNameList.push($("#" + userList[i].name).html());
		}
	}
	
	if(userNameList.length > 0){
		if(confirm((`Êtes-vous sûr de vouloir supprimer le(s) utilisateur(s) : ${userNameList.join(", ")} ?`))){
			const request = new XMLHttpRequest();
			request.open('POST', '/user-management');
			
			request.onreadystatechange = function()
			{
				if(request.readyState === 4)
				{
					if (request.responseText === "login")
						window.location.href = "/login";
					else
						displayUser();
				}
			};
			
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			const body = `requestType=${requestType}&userIdList=${userIdList}`;
			
			request.send(body);
		}
	}else{
		alert("Sélectionnez au minimum un utilisateur à supprimer.");
	}
}

/**************************************************
 * AJAX : OPEN USER FORM
 ***************************************************/
function openUserForm(id = "")
{
	const requestType = "openForm";
	
	const request = new XMLHttpRequest();
	request.open('POST', '/user-management');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			if (request.responseText === "login")
				window.location.href = "/login";
			else
			{
				console.log("AJAX : request open form completed");
				$("#ctnUserForm").html(request.responseText);
				$("#ctnUserForm").css("width", "100%");
				$("#ctnUserForm").css("height", "100%");
			}
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&userId=${id}`;
	
	request.send(body);
}

/**************************************************
 * CLOSE USER FORM
 ***************************************************/
function closeUserForm()
{
	$("#ctnUserForm").html("");
	$("#ctnUserForm").css("width", "0");
	$("#ctnUserForm").css("height", "0");
}
