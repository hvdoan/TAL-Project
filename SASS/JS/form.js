
$(document).on("click", ".show-password", function ()
{
	$("#password").attr("type", "text");
	$(this).addClass("hide");
	$(".hide-password").removeClass("hide");
});

$(document).on("click", ".show-confirmPassword", function ()
{
	$("#confirmPassword").attr("type", "text");
	$(this).addClass("hide");
	$(".hide-confirmPassword").removeClass("hide");
});

$(document).on("click", ".hide-password", function ()
{
	$("#password").attr("type", "password");
	$(this).addClass("hide");
	$(".show-password").removeClass("hide");
});

$(document).on("click", ".hide-confirmPassword", function ()
{
	$("#confirmPassword").attr("type", "password");
	$(this).addClass("hide");
	$(".show-confirmPassword").removeClass("hide");
});