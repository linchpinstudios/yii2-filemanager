



$(function() {
    
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
        
        $(this).addClass('selected');
                
        setImage($(this).attr('data-id'));
        
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
        mceEd.undoManager.add()
    };
    return false
};
    
    
    
    function setImage(imageId){
        var ed = top.tinymce;
        var html = '';
        _csrf:yii.getCsrfToken()
        
        var formData = {id:imageId};
        
        $.ajax({
            url: "/index.php?r=filemanager%2Ffiles%2Fgetimage&id="+imageId,
            type: "POST",
            data: formData,
            success: function (data) {
                console.log(data);
                html = '<img src="'+data.url+'" alt="'+data.title+'">';
        
        		ed.activeEditor.insertContent(html);
        		ed.activeEditor.windowManager.close();
            }
        });
    }