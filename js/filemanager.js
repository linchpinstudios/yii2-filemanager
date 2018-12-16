(function (filemanager, $, undefined) {
  "use strict";

  var _settings;
  // public method
  filemanager.init = function (settings) {
    _settings = $.extend({}, settings);
    //this.contextSetup();
  }

  /**
   * Setup context
   */
  filemanager.contextSetup = function () {

    context.init({
      fadespeed: 100,
      above: 'auto',
      preventDoubleContext: true,
      compress: false,
    });

    context.attach('.image-thumbnail .thumbnail', [{
        text: 'View',
        action: function (e) {
          var id = $(this).attr('href');
          alert(id);
          window.open($(this).attr('href'), 'imageWindow');
        },
      },
      {
        text: 'Download',
      },
      {
        text: 'Properties',
        action: function (e) {
          e.preventDefault();
          $('#editProperties').modal({
            remote: '/index.php?r=filemanager/files/properties',
          });
        },
      },
      {
        divider: true,
      },
      {
        text: 'Delete',
        action: function (e) {
          e.preventDefault();
          var id = $(this).attr('data-id');
          console.log(id);
          filemanager.deleteFile(id);
        },
      },
    ]);

  }

  filemanager.getSettings = function () {
    return _settings;
  }

  filemanager.deleteFile = function (id) {
    if (typeof id !== "undefined" && id !== null) {
      console.log(id);
    }
  }

}(window.filemanager = window.filemanager || {}, jQuery));


function createTag(form) {

  if ($(form).find('.has-error').length) {
    return false;
  }

  $.ajax({
    url: form.attr('action'),
    type: 'post',
    data: form.serialize(),
    success: function (data) {
      if (data.error) {
        $('.field-filetag-name').addClass('has-error');
        $('.field-filetag-name .help-block').text(data.error.name);
      }
      if (data.success) {
        $('#myModal').modal('hide');
        $('#filetag-name').val('');
        $('#tag-con').append('<div class=\"col-md-3\"><label><input type=\"checkbox\" name=\"tag[]\" checked=\"checked\" value=\"' + data.model.id + '\"> ' + data.model.name + '</label></div>');
      }
    }
  });

  return false;
}


$(function () {

  $(document).on('submit', '#create_tag', function () {
    event.preventDefault();
    createTag($(this));
    return false;
  });

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
        e.preventDefault();
        window.parent.filemanagertiny.setImage($(this).find('.thumbnail').attr('data-id'));
      } else if (typeof window.parent.filePicker !== 'undefined' && $.isFunction(window.parent.filePicker)) {
        window.parent.filePicker($(this).attr('data-id'));
      }
    }
  });
});


ccm_editorSetupImagePicker = function () {
  tinyMCE.activeEditor.focus();
  var bm = tinyMCE.activeEditor.selection.getBookmark();
  ccm_chooseAsset = function (obj) {
    var mceEd = tinyMCE.activeEditor;
    mceEd.selection.moveToBookmark(bm);
    var args = {};
    tinymce.extend(args, {
      src: obj.filePathInline,
      alt: obj.title,
      width: obj.width,
      height: obj.height
    });
    mceEd.execCommand("mceInsertContent", false, '<img id="__mce_tmp" src="javascript:;" />', {
      skip_undo: 1
    });
    mceEd.dom.setAttribs("__mce_tmp", args);
    mceEd.dom.setAttrib("__mce_tmp", "id", "");
    mceEd.undoManager.f()
  };
  return false
};
