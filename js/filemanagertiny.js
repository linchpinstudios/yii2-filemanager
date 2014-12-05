(function( filemanagertiny, $, undefined ) {
    "use strict";
    
    var _settings;
    
    // public method
    filemanagertiny.init = function(settings) {
        _settings = $.extend({}, settings);
    }
    
    
    
    filemanagertiny.getSettings = function() {
        
        return _settings;
        
    }
    
    
    
    
    filemanagertiny.setImage = function( imageId ) {
        
        var ed = top.tinymce;
        var html = '';
        
        if( typeof ed != 'undefined' && typeof imageId != 'undefined' ){
            _csrf:yii.getCsrfToken()
            
            var formData = {id:imageId};
            
            $.ajax({
                url: _settings.getimage,
                type: "GET",
                data: formData,
                success: function (data) {
                    console.log(data);
                    
                    html = '<img src="'+data.url+'" alt="'+data.title+'">';
            
            		ed.activeEditor.insertContent(html);
            		ed.activeEditor.windowManager.close();
                }
            });
        }
        
    }
    
    
    
}( window.filemanagertiny = window.filemanagertiny || {}, jQuery ));