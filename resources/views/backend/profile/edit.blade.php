@extends('backend.layouts.app')

@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<form action="{{ route('backend.profile.update') }}" method="POST" id="form_edit_profile" autocomplete="off" enctype="multipart/form-data">
					@method('PATCH')
					@csrf
					<div class="card card-warning card-outline">
						<div class="card-header">
							<h3 class="card-title py-1"><i class="fas fa-wrench"></i> แก้ไข Profile</h3>
						</div>
						<div class="card-body">
							<div class="form-group row">
								<label for="name" class="col-sm-2 col-form-label text-lg-right">Name <span class="text-danger">*</span></label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="name" id="name" value="{{ old('name', $user->name) }}">
								</div>
							</div>
							<div class="form-group row">
								<label for="email" class="col-sm-2 col-form-label text-lg-right">Email <span class="text-danger">*</span></label>
								<div class="col-sm-6">
									<input type="email" class="form-control" name="email" id="email" value="{{ old('email', $user->email) }}">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-md-2 col-form-label text-lg-right">Change Password</label>
								<div class="col-md-6">
									<div class="card card-warning border border-warning">
										<div class="card-header">
											<h3 class="card-title text-white">If you want to change your password.</h3>
										</div>
										<div class="card-body">
											<div class="form-group row">
												<label for="old_password" class="col-md-4 col-form-label text-lg-right">Old Password</label>
												<div class="col-md-8">
													<input type="password" class="form-control" name="old_password" id="old_password">
													<small class="form-text text-muted">รหัสผ่านเดิม</small>
												</div>
											</div>
											<div class="form-group row">
												<label for="password" class="col-md-4 col-form-label text-lg-right">New Password</label>
												<div class="col-md-8">
													<input type="password" class="form-control" name="password" id="password">
													<small class="form-text text-muted">ขั้นต่ำ 8 ตัวอักษร, ต้องแตกต่างจาก password เดิม</small>
												</div>
											</div>
											<div class="form-group row">
												<label for="password_confirmation" class="col-md-4 col-form-label text-lg-right">Confirm Password</label>
												<div class="col-md-8">
													<input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
													<small class="form-text text-muted">เหมือนกับ New Password</small>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<label for="profile_image_file" class="col-sm-2 col-form-label text-lg-right">Profile Image</label>
								<div class="col-sm-4">
									<div class="input-group">
										<div class="custom-file">
											<input type="file" class="custom-file-input" name="profile_image_file" id="profile_image_file" accept="image/*">
											<label class="custom-file-label text-left" for="profile_image_file">Choose file</label>
										</div>
										@if ($user->has_avatar)
											<div class="input-group-append">
												<img src="{{ $user->avatar_thumb }}" alt="Avatar Image" height="38">
											</div>
										@endif
									</div>
									<small id="emailHelp" class="form-text text-muted">Only .jpg, .jpeg, .png, ขนาดไม่เกิน 2MB</small>
								</div>
							</div>
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

@push('after-scripts')
<script>
	$('#form_edit_profile').validate({
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