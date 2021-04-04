$('document').ready(function(){



$("#login_guest").click(function() {
    $("#login_username").removeAttr("required");
    $("#login_password").removeAttr("required");
});



$(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $(this).siblings("input");
  var type=input.attr("type");
  if (type == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
  });

});
