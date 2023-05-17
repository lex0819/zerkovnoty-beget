jQuery(document).ready(function ($) {
   const
      linkPdfFile = $('.pdf-link').data('pdf'),
      postID = $('.pdf-link').data('postid');
      //console.log(postID);

   function countDownLoad(postID) {
      $.ajax({
         type: 'POST',
         url: lexKlirosAjax.ajaxUrl,
         data: {
            'action': 'lex_kliros_file_download_summation',
            'nonce': lexKlirosAjax.nonce,
            'postid': postID
         },
         success: function (data) {
            //console.log(data);
         },
         error: function (errorThrown) {
            console.log(errorThrown);
         }

      });
   }

   $('.score-show').on('load', function () {
      console.log('load');
      countDownLoad(postID);
   });

   $('.pdf-link').on('click', function () {
      countDownLoad(postID);
      window.open(linkPdfFile, '_blank'); //open pdf-file
   });
   // $('.pdf-link').on('vclick', function () {
   //    countDownLoad(postID);
   //    window.open(linkPdfFile, '_blank').focus(); //open pdf-file
   // });

   //если на тачскринах телефонов и планшетов - не показывать ноты PDF в <embed>
   if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      $(".score-show").css({
         "display": "none"
      });
      $(".content-single").css({
         "min-height": "auto"
      });
      $(".pdf-link").text("Download pdf file");
   }
});