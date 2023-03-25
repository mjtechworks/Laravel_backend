@extends('backend.layouts.app')

@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<form action="{{ route('backend.user.update', $user) }}" method="POST" id="form_edit_user" autocomplete="off" enctype="multipart/form-data">
					@method('PATCH')
					@csrf
					<div class="card card-warning card-outline">
						<div class="card-header">
							<h3 class="card-title py-1"><i class="fas fa-wrench"></i> แก้ไข User</h3>
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
	$('#form_edit_user').validate({
		rules: {
			name: 'required',
			email: {
				email: true,
				remote: {
					url: '{{ route('backend.user.check-valid-email') }}',
					type: "get",
					data: {
						email: function() {
							return $( 'input[name="email"]' ).val();
						},
						id: {{ $user->id }}
					}
				}
			},
			password: {
				minlength: 8
			},
			password_confirmation: {
				equalTo: '#password'
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