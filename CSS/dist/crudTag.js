/**************************************************
 * AJAX : DISPLAY DONATION TIER
 ***************************************************/
function displayTag()
{
	const requestType = "display";
	
	const request = new XMLHttpRequest();
	request.open('POST', '/tag');
	
	request.onreadystatechange = function(){
		if(request.readyState === 4){
			if (request.responseText !== ""){
				console.log("AJAX : display request completed");
				$("#tagList").html(request.responseText);
				
				$(document).ready(function (){
					$('#tagTable').DataTable();
				});
			}
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}`;
	request.send(body);
}

/**************************************************
 * AJAX : INSERT TAG
 ***************************************************/
function insertTag(data)
{
	const requestType      = "insert";
	const tagName          = $('#input-name').val();
	const tagDescription   = $('#input-description').val();
	
	const request = new XMLHttpRequest();
	request.open('POST', '/tag');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			console.log("AJAX : request insert completed");
			console.log(request.responseText);
			window.location.href = "/tag";
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&data=${data}&tagName=${tagName}&tagDescription=${tagDescription}`;
	
	request.send(body);
}

/**************************************************
 * AJAX : UPDATE TAG
 ***************************************************/
function updateTag()
{
	const requestType      = "update";
	const tagId            = $('#input-id').val();
	const tagName          = $('#input-name').val();
	const tagDescription   = $('#input-description').val();
	
	const request = new XMLHttpRequest();
	request.open('POST', '/tag');
	
	request.onreadystatechange = function(){
		if(request.readyState === 4){
			console.log("AJAX : Update request completed");
			console.log(request.responseText);
			displayTag();
			closeForm();
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&tagId=${tagId}&tagName=${tagName}&tagDescription=${tagDescription}`;
	
	request.send(body);
}

/**************************************************
 * AJAX : DELETE TAG
 ***************************************************/
function deleteTag(){
	const requestType   = "delete";
	let tagList        = $(".idTag");
	let tagNameList    = [];
	let tagIdList      = [];
	
	for (let i = 0; i < tagList.length; i++){
		if (tagList[i].checked){
			tagIdList.push(tagList[i].name);
			tagNameList.push($("#" + tagList[i].name).html());
		}
	}
	
	if(tagNameList.length > 0){
		if(confirm((`Êtes-vous sûr de vouloir supprimer la(es) catégorie(s) : ${tagNameList.join(", ")} ?`))){
			const request = new XMLHttpRequest();
			request.open('POST', '/tag');
			
			request.onreadystatechange = function(){
				if(request.readyState === 4){
					console.log("AJAX : delete request completed");
					displayTag();
				}
			};
			
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			const body = `requestType=${requestType}&tagIdList=${tagIdList}`;
			
			request.send(body);
		}
	}else
		alert("Veuillez sélectionner au minimum une catégories à supprimer.");
}

/**************************************************
 * AJAX : OPEN TAG FORM
 ***************************************************/
function openForm(id = "")
{
	const requestType = "openForm";
	
	const request = new XMLHttpRequest();
	request.open('POST', '/tag');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			if (request.responseText !== "")
			{
				console.log("AJAX : request open form completed");
				$("#ctnTagForm").html(request.responseText);
				$("#ctnTagForm").css("width", "300%");
				$("#ctnTagForm").css("height", "300%");
			}
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&tagId=${id}`;
	
	request.send(body);
}

/**************************************************
 * CLOSE DONATION TIER FORM
 ***************************************************/
function closeForm()
{
	$("#ctnTagForm").html("");
	$("#ctnTagForm").css("width", "0");
	$("#ctnTagForm").css("height", "0");
}

/**************************************************
 * EVENT LISTENER
 ***************************************************/
$("#tagList").ready(displayTag);