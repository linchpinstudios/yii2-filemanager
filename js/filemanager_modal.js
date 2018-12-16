(function (filemanager, $, undefined) {
  "use strict";
  var _settings;

  // public method
  filemanager.init = function (settings) {
    _settings = $.extend({}, settings);
  }

  filemanager.getSettings = function () {
    return _settings;
  }

}(window.filemanager = window.filemanager || {}, jQuery));

$(function () {
  context.init({
    fadespeed: 100,
    above: 'auto',
    preventDoubleContext: true,
    compress: false,
  });

  context.attach('.image-thumbnail .thumbnail', [{
      text: 'View',
      action: function (e) {
        alert(this.href);
        window.open($(this).attr('href'), 'imageWindow');
      },
    }, {
      text: 'Download',
    }, {
      text: 'Properties',
      action: function (e) {
        e.preventDefault();
        $('#editProperties').modal({
          remote: '/index.php?r=filemanager/files/properties',
        });
      },
    }, {
      divider: true,
    }, {
      text: 'Delete',
    },
  ]);

  $('#fileUploadBtn').click(function (e) {
    e.preventDefault();
    $(this).addClass('disabled');

    $('#fileGridBtn').removeClass('disabled');
    $('#fileGridManager,#fileGridFooter').hide();
    $('#filemanagerUpload').show();
  });

  $('#fileGridBtn').click(function (e) {
    e.preventDefault();

    $(this).addClass('disabled');
    $('#fileUploadBtn').removeClass('disabled');
    $('#filemanagerUpload').hide();
    $('#fileGridManager,#fileGridFooter').show();
  });

  $('.image-thumbnail').click(function (e) {
    if ($(this).hasClass('selected')) {
      $(this).removeClass('selected');
    } else {
      $(this).addClass('selected');
      if (typeof window.parent.filemanagertiny.setImage !== 'undefined' && $.isFunction(window.parent.filemanagertiny.setImage)) {
        window.parent.filemanagertiny.setImage($(this).attr('data-id'));
      } else if (typeof window.parent.filePicker !== 'undefined' && $.isFunction(window.parent.filePicker)) {
        window.parent.filePicker($(this).attr('data-id'));
      }
    }
  });

  $('.image-thumbnail a').click(function (e) {
    e.preventDefault();
  });

});
