
(function( filemanager, $, undefined ) {
    "use strict";
    
    var _settings;
    
    
    // public method
    filemanager.init = function(settings) {
        _settings = $.extend({}, settings);
    }
    
    
}



$(function() {
    
    context.init({
        fadespeed: 100,
        above: 'auto',
        preventDoubleContext: true,
        compress: false,
    });
    
    context.attach('.image-thumbnail .thumbnail',[
        {
            text: 'View',
            action: function(e){
                alert(this.href);
                window.open($(this).attr('href'),'imageWindow');
            },
        },
        {
            text: 'Download',
        },
        /*{
            text: 'Edit',
        },*/
        {
            text: 'Properties',
            action: function(e){
                e.preventDefault();
                $('#editProperties').modal({
                    remote : '/index.php?r=filemanager/files/properties',
                });
            },
        },
        {
            divider: true,
        },
        {
            text: 'Delete',
        },
    ]);
    
    $('#fileUploadBtn').click(function(e){
       
       e.preventDefault();
       
       $(this).addClass('disabled');
       
       $('#fileGridBtn').removeClass('disabled');
       
       $('#fileGridManager,#fileGridFooter').hide();
       
       $('#filemanagerUpload').show();
        
    });
    
    $('#fileGridBtn').click(function(e){
       
       e.preventDefault();
       
       $(this).addClass('disabled');
       
       $('#fileUploadBtn').removeClass('disabled');
       
       $('#filemanagerUpload').hide();
       
       $('#fileGridManager,#fileGridFooter').show();
        
    });
    
    $('.image-thumbnail').click(function(e){
        
        if($(this).hasClass('selected')){
            $(this).removeClass('selected');
        }else{
            $(this).addClass('selected');
            setImage($(this).attr('data-id'));
        }
        
    });
    
    $('.image-thumbnail a').click(function(e){
        e.preventDefault();
    });
    
});


ccm_editorSetupImagePicker = function() {
    tinyMCE.activeEditor.focus();
    var bm = tinyMCE.activeEditor.selection.getBookmark();
    ccm_chooseAsset = function(obj) {
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
    
    
    
    function setImage(imageId){
        var ed = top.tinymce;
        var html = '';
        
        if(typeof ed != 'undefined'){
            _csrf:yii.getCsrfToken()
            
            var formData = {id:imageId};
            
            $.ajax({
                url: "/index.php?r=filemanager%2Ffiles%2Fgetimage&id="+imageId,
                type: "POST",
                data: formData,
                success: function (data) {
                    html = '<img src="'+data.url+'" alt="'+data.title+'">';
            
            		ed.activeEditor.insertContent(html);
            		ed.activeEditor.windowManager.close();
                }
            });
        }
    }