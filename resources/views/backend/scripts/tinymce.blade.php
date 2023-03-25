@prepend('after-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.2.2/tinymce.min.js" referrerpolicy="origin"></script>
@endprepend

@push('after-scripts')
<script>
	var editorConfig = {
		pathAbsolute : "/backend/",
		selector: "textarea#tinymce_textarea",
		plugins: [
		"advlist autolink lists link image charmap print preview hr anchor pagebreak",
		"searchreplace wordcount visualblocks visualchars code fullscreen",
		"insertdatetime media nonbreaking save table contextmenu directionality",
		"emoticons template paste textcolor colorpicker textpattern"
		],
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
		relative_urls: false,
		file_picker_callback: function (callback, value, meta) {
	        let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
	        let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

	        let type = 'image' === meta.filetype ? 'Images' : 'Files',
	            url  = editorConfig.pathAbsolute + 'laravel-filemanager?editor=tinymce5&type=' + type;

	        tinymce.activeEditor.windowManager.openUrl({
	            url : url,
	            title : 'Filemanager',
	            width : x * 0.8,
	            height : y * 0.8,
	            onMessage: (api, message) => {
	                callback(message.content);
	            }
	        });
	    }
	};
</script>
@endpush
