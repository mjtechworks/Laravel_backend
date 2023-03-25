@prepend('after-scripts')
<script src="{{ asset('node_modules/admin-lte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
@endprepend

@push('after-scripts')
<script>
	bsCustomFileInput.init();
</script>
@endpush