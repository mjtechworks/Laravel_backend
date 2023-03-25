@push('before-styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@prepend('after-scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
@endprepend

@push('after-scripts')
<script>
	$('.select2').select2()

	$('.select2bs4').select2({
		theme: 'bootstrap4'
	})
</script>
@endpush