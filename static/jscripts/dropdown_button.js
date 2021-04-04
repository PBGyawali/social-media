/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown
 content - This allows the user to have multiple dropdowns without any conflict */
/*var dropdown = document.getElementsByClassName("dropdown-btn");
var i; 
for (i = 0; i < dropdown.length; i++) 
{
  dropdown[i].addEventListener("click", function() 
  {
  this.classList.toggle("active_class");
  var dropdownContent = this.nextElementSibling;
  if (dropdownContent.style.display === "block") {
  dropdownContent.style.display = "none";
  } else {
  dropdownContent.style.display = "block";
  }
  });
}*/
$(document).ready(function(){
  $('.dropdown-btn').each(function ()	{
          var dropdown= $(this);
          dropdown.on("click", function()  {
                $(this).toggleClass("active_class");
                var dropdownContent = $(this).siblings();
                $(dropdownContent).toggle();  
            });
		});

});

