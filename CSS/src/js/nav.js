
$(document).on("click", "#trigger-nav", function (){
	let nav = $("#nav");
	
	if(nav.hasClass("nav-close")){
		nav.removeClass('nav-close');
	}else{
		nav.addClass('nav-close');
	}
});

$(document).on("click", ".nav-section", function (){
	let open = false;
	
	if($(this).hasClass("close")){
		open = true;
	}
	
	closeAllNavSection();
	
	if($(this).hasClass("close") && open){
		$(this).removeClass('close');
	}
	
});

function closeAllNavSection(){
	$('.nav-section').addClass('close');
}

function removeAllOpenedBtn(){
	$('.btn').removeClass('opened');
}