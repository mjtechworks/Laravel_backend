@push('before-styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/r-2.2.3/datatables.min.css"/>
@endpush

@prepend('after-scripts')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/r-2.2.3/datatables.min.js"></script>
<script type="text/javascript" src="{{ mix('js/backend/my-dt-func.js') }}"></script>
@endprepend

@push('after-scripts')
<script>
	$(document).on( 'processing.dt', function ( e, settings, processing ) {
		$(e.target).css('opacity',  processing ? 0.3 : 1);
	});
</script>
@endpush