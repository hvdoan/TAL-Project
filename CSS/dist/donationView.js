function checkSelf(div){
	let allInput = document.getElementsByClassName("donationTier");
	
	for(let i = 0; i < allInput.length; i++){
		allInput[i].checked = false;
	}
	
	removeAllCheckedClass();
	
	$(div).find('input').prop('checked', true);
	$(div).addClass("checked");
}

function removeAllCheckedClass(){
	let allDiv = document.getElementsByClassName("checked");
	$(allDiv).each(function(){
		$(this).removeClass("checked");
	});
}

$("#cards").ready(removeAllCheckedClass);