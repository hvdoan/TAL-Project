/**************************************************
 * AJAX : DISPLAY DONATION TIER
 ***************************************************/
function displayDonationTier()
{
	const requestType = "display";
	
	const request = new XMLHttpRequest();
	request.open('POST', '/palier-donation');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			if (request.responseText === "login")
				window.location.href = "/login";
			else
			{
				$("#donationTierList").html(request.responseText);
				
				$(document).ready(function (){
					$('#donationTierTable').DataTable();
				});
			}
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}`;
	request.send(body);
}

/**************************************************
 * AJAX : INSERT DONATION TIER
 ***************************************************/
function insertDonationTier(data)
{
	const requestType               = "insert";
	const donationTierName          = $('#input-name').val();
	const donationTierDescription   = $('#input-description').val();
	const donationTierPrice         = $('#input-price').val();
	const tokenForm         		= $('#tokenForm').val();
	
	const request = new XMLHttpRequest();
	request.open('POST', '/palier-donation');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			if (request.responseText === "login")
				window.location.href = "/login";
			else
				window.location.href = "/palier-donation";
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&tokenForm=${tokenForm}&data=${data}&donationTierName=${donationTierName}&donationTierDescription=${donationTierDescription}&donationTierPrice=${donationTierPrice}`;
	
	request.send(body);
}

/**************************************************
 * AJAX : UPDATE DONATION TIER
 ***************************************************/
function updateDonationTier()
{
	const requestType               = "update";
	const donationTierId            = $('#input-id').val();
	const donationTierName          = $('#input-name').val();
	const donationTierDescription   = $('#input-description').val();
	const donationTierPrice         = $('#input-price').val();
	const tokenForm         		= $('#tokenForm').val();
	
	const request = new XMLHttpRequest();
	request.open('POST', '/palier-donation');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			if (request.responseText === "login")
				window.location.href = "/login";
			else
			{
				displayDonationTier();
				closeForm();
			}
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&tokenForm=${tokenForm}&donationTierId=${donationTierId}&donationTierName=${donationTierName}&donationTierDescription=${donationTierDescription}&donationTierPrice=${donationTierPrice}`;
	
	request.send(body);
}

/**************************************************
 * AJAX : DELETE DONATION TIER
 ***************************************************/
function deleteDonationTier(){
	const requestType   = "delete";
	let donationTierList        = $(".idDonationTier");
	let donationTierNameList    = [];
	let donationTierIdList      = [];
	
	for (let i = 0; i < donationTierList.length; i++)
	{
		if (donationTierList[i].checked)
		{
			donationTierIdList.push(donationTierList[i].name);
			donationTierNameList.push($("#" + donationTierList[i].name).html());
		}
	}
	
	if(donationTierNameList.length > 0){
		if(confirm((`Êtes-vous sûr de vouloir supprimer le(s) palier(s) de donation : ${donationTierNameList.join(", ")} ?`))){
			const request = new XMLHttpRequest();
			request.open('POST', '/palier-donation');
			
			request.onreadystatechange = function()
			{
				if(request.readyState === 4)
				{
					if (request.responseText === "login")
						window.location.href = "/login";
					else
						displayDonationTier();
				}
			};
			
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			const body = `requestType=${requestType}&donationTierIdList=${donationTierIdList}`;
			
			request.send(body);
		}
	}else{
		alert("Veuillez sélectionner au minimum un palier à supprimer.");
	}
}

/**************************************************
 * AJAX : OPEN DONATION TIER FORM
 ***************************************************/
function openDonationForm(id = "")
{
	const requestType = "openForm";
	
	const request = new XMLHttpRequest();
	request.open('POST', '/palier-donation');
	
	request.onreadystatechange = function()
	{
		if(request.readyState === 4)
		{
			if (request.responseText === "login")
				window.location.href = "/login";
			else
			{
				console.log(request.responseText);
				$("#ctnDonationTierForm").html(request.responseText);
				$("#ctnDonationTierForm").css("width", "300%");
				$("#ctnDonationTierForm").css("height", "300%");
				$("body").addClass("overflowHidden");
			}
		}
	};
	
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	const body = `requestType=${requestType}&donationTierId=${id}`;
	
	request.send(body);
}

/**************************************************
 * CLOSE DONATION TIER FORM
 ***************************************************/
function closeDonationForm()
{
	$("#ctnDonationTierForm").html("");
	$("#ctnDonationTierForm").css("width", "0");
	$("#ctnDonationTierForm").css("height", "0");
	$("body").removeClass("overflowHidden");
}
