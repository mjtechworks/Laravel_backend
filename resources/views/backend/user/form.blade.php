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

@if (url()->current() == route('backend.user.create'))
	<div class="form-group row">
		<label for="password" class="col-sm-2 col-form-label text-lg-right">Password <span class="text-danger">*</span></label>
		<div class="col-sm-6">
			<input type="password" class="form-control" name="password" id="password">
			<small class="form-text text-muted">ขั้นต่ำ 8 ตัวอักษร</small>
		</div>
	</div>
	<div class="form-group row">
		<label for="password_confirmation" class="col-sm-2 col-form-label text-lg-right">Confirm Password <span class="text-danger">*</span></label>
		<div class="col-sm-6">
			<input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
			<small class="form-text text-muted">เหมือนกับ Password</small>
		</div>
	</div>
@else
	<div class="form-group row">
		<label class="col-md-2 col-form-label text-lg-right">Reset Password</label>
		<div class="col-md-6">
			<div class="card card-warning border border-warning">
				<div class="card-header">
					<h3 class="card-title text-white">If you need to reset the password for this user.</h3>
				</div>
				<div class="card-body">
					<div class="form-group row">
						<label for="password" class="col-md-4 col-form-label text-lg-right">New Password</label>
						<div class="col-md-8">
							<input type="password" class="form-control" name="password" id="password">
							<small class="form-text text-muted">ขั้นต่ำ 8 ตัวอักษร</small>
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
@endif

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
		<small class="form-text text-muted">Only .jpg, .jpeg, .png, ขนาดไม่เกิน 2MB</small>
	</div>
</div>

<div class="form-group row">
	<label for="roles" class="col-sm-2 col-form-label text-lg-right">Role</label>
	<div class="col-sm-6">
		<select class="w-100 select2" name="roles[]" id="roles" multiple="multiple" data-placeholder="เลือก Role">
			@foreach($roleOptions as $role)
				<option {{ $selectedRoles($role->name) }}>{{ $role->name }}</option>
			@endforeach
		</select>
	</div>
</div>

<div class="form-group row">
	<label for="phone" class="col-sm-2 col-form-label text-lg-right">สถานะ</label>
	<div class="col-sm-4">
		<select name="status" id="status" class="form-control">
			@foreach($statuses as $value => $text)
				<option value="{{ $value }}" {{ $selectedStatus($value) }}>{{ $text }}</option>
			@endforeach
		</select>
	</div>
</div>

@isset($user->created_at)
<div class="form-group row">
	<label for="type" class="col-sm-2 col-form-label text-lg-right">สร้างเมื่อ</label>
	<div class="col-sm-10">
	      <input type="text" readonly class="form-control-plaintext" value="{{ $user->created_at->diffForHumans() }} ({{ $user->display_created_at_full_thai }})">
	</div>
</div>
@endisset