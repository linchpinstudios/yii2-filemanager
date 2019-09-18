(function( filemanager, $, undefined ) {
    "use strict";

    var _settings;
    var _selected;
    var _multiple = false;

    // public method
    filemanager.init = function(settings) {
        _settings = $.extend({}, settings);
    }

    filemanager.log = function(obj){
        if(_settings.debug == true){
            console.log(obj);
        }
    }

    /* Delete Building
     *
     *
     */
    filemanager.setup = function(){

        filemanager.log('Function Setup run');

        $('#fileupload').fileupload({
            url : _settings.fileUploadURL,
            autoUpload: true,
            done : function(e,data){
                console.log(data);
                filemanager.addToList(data.result.files[0]);
            },
        });

        $('#tabMedialibrary a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });

        $('#tabUploadFiles a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });

    }


    filemanager.markSelected = function(){

        filemanager.log('Mark Selected');


    }


    filemanager.selectFiles = function(){

        filemanager.log('Select Files');



    }

    /* Add to List Building
     *
     *
     */
    filemanager.addToList = function(data){

        var newImage = '<tr id="mediaImage_'+data.id+'"><td style="vertical-align:middle"><input class="selectedImage" checked="checked" data-id="'+data.id+'" data-path="'+data.thumbnailUrl+'" type="checkbox" value="1" name="imageSelected['+data.id+']" id="imageSelected_'+data.id+'"></td><td><div class="mediaManagerThumb" style="background-image:url('+data.thumbnailUrl+')"></td><td>'+data.name+'</td><td></td><td></td><td><div class="btn-group"><button type="button" class="btn btn-info dropdown-toggle pull-right" data-toggle="dropdown">Action <span class="caret"></span></button><ul class="dropdown-menu" role="menu"><li><a onClick="filemanager.deletePhoto('+data.id+');">Delete</a></li></ul></div></td></tr>';
        $('table#mediaTable > tbody > tr:first').before(newImage);

        $('#tabMedialibrary a').tab('show');

        return true;

    }

    /* Delete Photo
     *
     *
     */
    filemanager.deletePhoto = function(id){

		$.ajax({
			type		:	'POST',
			url			:	_settings.deleteURL,
			data		:	{
				id		:	id,
			},
			success	:	function(data){
				$('#mediaImage_'+id).hide();
			},
			error		:	function(request, status, error){
				console.log(request.responseText);
			}
		});

  }

}( window.filemanager = window.filemanager || {}, jQuery ));
