<div class="title"><?=$title;?></div>

<script type="text/javascript">
// Convert divs to queue widgets when the DOM is ready
$(function() {
	$("#uploader").plupload({
		// General settings
		runtimes : 'gears,flash,silverlight,browserplus,html5',
		url : '/dashboard/photos/uploadtoserver',
		max_file_size : '2mb',
		chunk_size : '1mb',
		//unique_names : true,

		// Resize images on clientside if we can
		//resize : {width : 320, height : 240, quality : 90},

		// Specify what files to browse for
		filters : [
			{title : "Image files", extensions : "jpg"}
		],

		// Flash settings
		flash_swf_url : '/js/plupload/js/plupload.flash.swf',

		// Silverlight settings
		silverlight_xap_url : '/js/plupload/js/plupload.silverlight.xap'
	});

	// Client side form validation
	$('form').submit(function(e) {
        var uploader = $('#uploader').plupload('getUploader');

        // Files in queue upload them first
        if (uploader.files.length > 0) {
            // When all files are uploaded submit form
            uploader.bind('StateChanged', function() {
                if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
                    $('form')[0].submit();
                }
            });
                
            uploader.start();
        } else
            alert('You must at least upload one file.');

        return false;
    });
});
</script>


<div>
    <?=form_open_multipart('/dashboard/photos/upload',array('name'=>'photoupload'));?> 
        <div id="uploader"></div>
    </form>
</div>