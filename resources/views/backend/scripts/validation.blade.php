@prepend('after-scripts')
<script src="{{ asset('node_modules/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset('node_modules/jquery-validation/dist/localization/messages_th.min.js') }}"></script>
<script src="{{ asset('node_modules/jquery-validation/dist/additional-methods.min.js') }}"></script>
@endprepend

@push('after-scripts')
<script>
	$.validator.setDefaults({
	  	errorClass: 'is-invalid',
	  	validClass: 'is-valid',
	  	errorElement: 'div',
	  	errorPlacement: function ( error, element ) {
	  		error.addClass('invalid-feedback').insertAfter(element);
	  	},
	  	invalidHandler: function(){
	  		Ladda.stopAll();
	  	}
	});
</script>
@endpush