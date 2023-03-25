@extends('backend.layouts.app')

@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<form action="{{ route('backend.role.store') }}" method="POST" id="form_create_role" autocomplete="off">
					@csrf
					<div class="card card-success card-outline">
						<div class="card-header">
							<h3 class="card-title py-1"><i class="fas fa-plus"></i> เพิ่ม Role</h3>
							<div class="card-tools">
								<a href="{{ route('backend.role.index') }}" class="btn btn-sm btn-default">Back to List</a>
							</div>
						</div>
						<div class="card-body">
							@include('backend.role.form')
						</div>
						<div class="card-footer">
							<button type="button" class="btn btn-default reset-form">Reset Form</button>
							<button type="submit" class="btn btn-success float-right">Submit</button>
						</div>
					</div>
				</form>
				<!-- /.card -->
			</div>
		</div>
	</div>
</section>
@endsection

@include('backend.scripts.validation')
@include('backend.scripts.select2')

@push('after-scripts')
<script>
	$('#form_create_role').validate({
		rules: {
			name: {
				required: true,
				remote: '{{ route('backend.role.check-valid-name') }}'
			},
		},
		messages: {
			name: {
				remote: 'Role นี้มีอยู่แล้วในระบบ กรุณาเปลี่ยนใหม่'
			}
		}
	});
</script>
@endpush