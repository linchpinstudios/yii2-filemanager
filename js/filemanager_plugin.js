
(function( filemanagertiny, $, undefined ) {
    "use strict";
    
    var _settings;
    
    // public method
    filemanagertiny.init = function(settings) {
        _settings = $.extend({}, settings);
    }
    
    
});
//'/index.php?r=filemanager/files/tinymce'

tinymce.PluginManager.add('filemanager', function(editor, url) {
	
	function fileman() {
		editor.windowManager.open({
			title: 'Upload an image',
			file : filemanagertiny._settings.tinymce,
			width : 960,
			height: 600,
			resizable : true,
			/*buttons: [{
				text: 'insert',
				classes:'widget btn primary first abs-layout-item',
				disabled : true,
				onclick: 'close',
			},
			{
				text: 'Close',
				onclick: 'close'
			}],*/
		});
	}
	
	// Add a button that opens a window
	editor.addButton('filemanager', {
		tooltip: 'File Manager',
		icon : 'image',
		text: 'Insert',
		onclick: fileman
	});

	// Adds a menu item to the tools menu
	editor.addMenuItem('filemanager', {
		text: 'File Manager',
		icon : 'image',
		context: 'Insert',
		onclick: fileman
	});
});



/*
				tinymce.activeEditor.insertContent(event.data.html);
				tinymce.activeEditor.windowManager.close();
*/