@extends('backend.layouts.app')

@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<div class="card card-primary card-outline">
					<div class="card-header">
						<h3 class="card-title py-1"><i class="fas fa-icons"></i> Text ...</h3>
						<div class="card-tools">
							<a href="#" class="btn btn-sm btn-default">Button Link</a>
						</div>
					</div>
					<div class="card-body">
						Body
					</div>
					<div class="card-footer">
						<button type="button" class="btn btn-default reset-form">Footer button</button>
						<button type="button" class="btn btn-success float-right">Footer button</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@include('backend.scripts.validation')
@include('backend.scripts.file-upload')
@include('backend.scripts.select2')

@push('after-scripts')
<script>

</script>
@endpush