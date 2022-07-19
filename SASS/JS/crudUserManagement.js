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
	let formData = new FormData();

	formData.append("requestType", "update");
	formData.append("userId", $('#input-id').val());
	formData.append("userLastname", $('#input-lastname').val());
	formData.append("userFirstname", $('#input-firstname').val());
	formData.append("userEmail", $('#input-email').val());
	formData.append("avatar", $('#input-avatar')[0].files[0]);
	formData.append("userIdRole", $('#input-idRole').val());
	formData.append("tokenForm", $('#tokenForm').val());

	// const requestType       = "update";
	// const userId            = $('#input-id').val();
	// const userLastName      = $('#input-lastname').val();
	// const userFirstname     = $('#input-firstname').val();
	// const userEmail         = $('#input-email').val();
	// const avatar         	= $('#input-avatar')[0].files[0];
	// const userIdRole        = $('#input-idRole').val();
	// const tokenForm         = $('#tokenForm').val();
	
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
			}
		}
	};
	
	// request.setRequestHeader('Content-Type', 'multipart/form-data');
	// const body = `requestType=${requestType}&tokenForm=${tokenForm}&userId=${userId}&avatar=${avatar}&userLastname=${userLastName}&userFirstname=${userFirstname}&userEmail=${userEmail}&userIdRole=${userIdRole}`;
	
	request.send(formData);
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
				$("#ctnUserForm").css("width", "300%");
				$("#ctnUserForm").css("height", "300%");
				$("body").addClass("overflowHidden");
			}
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&userId=${id}`;
	
	request.send(body);
}

/**************************************************
 * AJAX : DISPLAY USER AVATAR
 ***************************************************/
function displayUserAvatar()
{
	let formData = new FormData();

	formData.append("requestType", "displayAvatar");
	formData.append("avatar", $('#input-avatar')[0].files[0]);

	const request = new XMLHttpRequest();
	request.open('POST', '/user-management');

	request.onreadystatechange = function(){
		if(request.readyState === 4)
		{
			if (request.responseText === "login")
				window.location.href = "/login";
			else
				$("#avatar-preview").html(request.responseText);
		}
	};

	request.send(formData);
}

/**************************************************
 * CLOSE USER FORM
 ***************************************************/
function closeUserForm()
{
	$("#ctnUserForm").html("");
	$("#ctnUserForm").css("width", "0");
	$("#ctnUserForm").css("height", "0");
	$("body").removeClass("overflowHidden");
}
