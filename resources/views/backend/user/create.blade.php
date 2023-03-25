@extends('backend.layouts.app')

@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<form action="{{ route('backend.user.store') }}" method="POST" id="form_create_user" autocomplete="off" enctype="multipart/form-data">
					@csrf
					<div class="card card-success card-outline">
						<div class="card-header">
							<h3 class="card-title py-1"><i class="fas fa-plus"></i> เพิ่ม User</h3>
							<div class="card-tools">
								<a href="{{ route('backend.user.index') }}" class="btn btn-sm btn-default">Back to List</a>
							</div>
						</div>
						<div class="card-body">
							@include('backend.user.form')
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
@include('backend.scripts.file-upload')
@include('backend.scripts.select2')

@push('after-scripts')
<script>
	$('#form_create_user').validate({
		rules: {
			name: 'required',
			email: {
				required: true,
				email: true,
				remote: '{{ route('backend.user.check-valid-email') }}'
			},
			password: {
				required: true,
				minlength: 8
			},
			password_confirmation: {
				equalTo: '#password'
			},
			profile_image_file: {
				extension: 'png|jpe?g',
				maxsize: 2048000,
			}
		},
		messages: {
			email: {
				remote: 'Email นี้มีผู้ใช้งานแล้ว กรุณาเปลี่ยนใหม่'
			},
			password_confirmation: {
				equalTo: 'กรุณากรอกให้เหมือนกับ Password'
			}
		}
	});
</script>
@endpush