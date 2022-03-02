
$( document ).ready(function(){
	let nav = $("#actuallyOpenedLi");
	let btn = $("#actuallyOpenedA");
	
	if(nav.hasClass("close"))
		nav.removeClass('close');
	
	//remove all opened class and add it to the only one opened
	removeAllOpenedBtn();
	if(btn.hasClass("opened") === false)
		btn.addClass('opened');
});

$(document).on("click", "#trigger-nav", function ()
{
	let nav = $("#nav");
	
	if(nav.hasClass("nav-close"))
		nav.removeClass('nav-close');
	else
		nav.addClass('nav-close');
});

$(document).on("click", ".nav-section", function ()
{
	let open = false;
	
	if($(this).hasClass("close"))
		open = true;
	
	closeAllNavSection();
	
	if($(this).hasClass("close") && open)
		$(this).removeClass('close');
	
});

function closeAllNavSection()
{
	$('.nav-section').addClass('close');
}

function removeAllOpenedBtn()
{
	$('.btn').removeClass('opened');
}