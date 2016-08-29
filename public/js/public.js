(function ($) {
  'use strict';

  /**
   * Used to mask behavior of input type file
   * 
   * https://gist.github.com/jprieton/5e61253eaf239168557a93691a512621
   */
  $('.input-group-file').each(function (e, i) {
    var inputFile = $(i).find('input[type="file"]');
    var inputText = $(i).find('input[type=text]');
    var label = $(i).find('label');

    // Bind click to use the label behavior in the input text
    inputText.on('click', function () {
      label.trigger('click');
    });

    // On change update the input text value with the filename
    inputFile.on('change', function () {
      var fileName = inputFile.val().match(/[^\/\\]+$/)[0];
      inputText.val(fileName);
    });
  });

})(jQuery);
