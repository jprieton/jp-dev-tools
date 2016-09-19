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

  /**
   * Default ajaxForm behavior
   */
  $('.ajax-form').each(function () {
    var form = $(this);
    $(form).find('textarea,input').on('focus', function (i, e) {
      var button = form.find('button[type=submit]');
      button.attr('data-default', button.text());
    });
  });

  $('.ajax-form').ajaxForm({
    url: JPDevTools.ajaxUrl,
    dataType: 'json',
    method: 'post',
    beforeSubmit: function (formData, form, options) {
      var button = form.find('button[type=submit]');
      button.attr('disabled', '').text(JPDevTools.messages.sending);
      form.trigger('ajaxFormBeforeSubmit', [form]);
    },
    success: function (response, statusText, xhr, form) {
      var button = form.find('button[type=submit]');
      button.removeAttr('disabled');
      if (response.success) {
        var textSuccess = button.attr('data-success') ? button.attr('data-success') : JPDevTools.messages.success;
        button.text(textSuccess);
        form.trigger('ajaxFormSuccess', [response, form]);
      } else {
        var textError = button.attr('data-success') ? button.attr('data-success') : JPDevTools.messages.error;
        button.text(textError);
        form.trigger('ajaxFormError', [response, form]);
      }
    }
  });

})(jQuery);
