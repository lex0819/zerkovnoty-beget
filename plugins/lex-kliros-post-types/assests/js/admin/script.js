jQuery(document).ready(function ($) {
   // console.log("ready!");

   let groups = $('.list').each(function () {
      let num = $(this).data('group');
      // console.log(num % 2);
      if (num % 2) {
         $(this).css("background-color", "#ff00e038");
         console.log($(this));
      } else {
         $(this).css("background-color", "#0080002e");
      }
   });

});