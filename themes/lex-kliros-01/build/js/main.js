jQuery(document).ready(function ($) {

   $("#composer").autocomplete({
      source: function (request, response) {
         var term = request.term;
         var pattern = new RegExp("^" + term, "i");

         var result = $.map(litsOfComposer, function (elem) {
            if (pattern.test(elem["label"])) {
               return elem; //elem = {label: "Шевцов", value: "shevzov"}
            }
         });
         response(result); //elem = {label: "Шевцов", value: "shevzov"}
      },
      select: function (event, ui) {
         //console.log(ui); ui = item: {label: "Чесноков", value: "chesnokov"}
         $('#composer').val(ui.item.label);
         $('#lex_kliros_composer').val(ui.item.value);
         return false;
      },
      focus: function (event, ui) {
         $("#composer").val(ui.item.label);
         return false;
      },
      minLength: 1,
      delay: 600
   });

   $("#chant").autocomplete({
      source: function (request, response) {
         var term = request.term;
         var pattern = new RegExp("^" + term, "i");

         var result = $.map(litsOfChant, function (elem) {
            if (pattern.test(elem["label"])) {
               return elem;
            }
         })
         response(result);
      },
      select: function (event, ui) {
         $('#chant').val(ui.item.label);
         $('#lex_kliros_chant').val(ui.item.value);
         return false;
      },
      focus: function (event, ui) {
         $("#chant").val(ui.item.label);
         return false;
      },
      minLength: 1,
      delay: 600
   });

   $('#composer').on('blur', function () {
      if ($(this).val().length > 0 && $('#lex_kliros_composer').val().length == 0) {
         $(this).addClass('error');
         $('#btn-search').attr('disabled', true);
      } else {
         $(this).removeClass('error');
         $('#btn-search').attr('disabled', false);
      }
   });

   $('#chant').on('blur', function () {
      if ($(this).val().length > 0 && $('#lex_kliros_chant').val().length == 0) {
         $(this).addClass('error');
      } else {
         $(this).removeClass('error');
         $('#btn-search').attr('disabled', false);
      }
   });

   $("#big-search-form").submit(function (e) {
      //убрать input из отправки get-запроса можно просто - не давать ему имя, атрибут name не писать в input-е и он не будет отправляться
      //$(this).find("#composer, #chant").attr("disabled", true);
      if (($('#composer').val().length > 0 && $('#lex_kliros_composer').val().length == 0) || ($('#chant').val().length > 0 && $('#lex_kliros_chant').val().length == 0)) {
         e.preventDefault();
      }
      if ($('#s').val().length == 0 &&
         $('#lex_kliros_composer').val().length == 0 &&
         $('#lex_kliros_chant').val().length == 0 &&
         $('#lex_kliros_tonality').val() == 0 &&
         $('#lex_kliros_onlyopus').val().length == 0 &&
         $('#lex_kliros_number').val().length == 0 &&
         $('#lex_kliros_quality').val() == 0 &&
         $('#lex_kliros_voices').val() == 0) {
         e.preventDefault();
      }
   });

});