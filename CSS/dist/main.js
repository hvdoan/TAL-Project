$(document).on("click", "#trigger-nav", function () {
  var nav = $("#nav");

  if (nav.hasClass("nav-close")) {
    nav.removeClass('nav-close');
  } else {
    nav.addClass('nav-close');
  }
});
$(document).on("click", ".nav-section", function () {
  var open = false;

  if ($(this).hasClass("close")) {
    open = true;
  }

  closeAllNavSection();

  if ($(this).hasClass("close") && open) {
    $(this).removeClass('close');
  }
});

function closeAllNavSection() {
  $('.nav-section').addClass('close');
}

function removeAllOpenedBtn() {
  $('.btn').removeClass('opened');
}

$(document).on("click", ".show-password", function () {
  $("#password").attr("type", "text");
  $(this).addClass("hide");
  $(".hide-password").removeClass("hide");
});
$(document).on("click", ".show-confirmPassword", function () {
  $("#confirmPassword").attr("type", "text");
  $(this).addClass("hide");
  $(".hide-confirmPassword").removeClass("hide");
});
$(document).on("click", ".hide-password", function () {
  $("#password").attr("type", "password");
  $(this).addClass("hide");
  $(".show-password").removeClass("hide");
});
$(document).on("click", ".hide-confirmPassword", function () {
  $("#confirmPassword").attr("type", "password");
  $(this).addClass("hide");
  $(".show-confirmPassword").removeClass("hide");
});
