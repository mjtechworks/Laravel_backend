<div class="form-group row">
	<label for="name" class="col-sm-2 col-form-label text-lg-right">Name <span class="text-danger">*</span></label>
	<div class="col-sm-6">
		<input type="text" class="form-control" name="name" id="name" value="{{ old('name', $role->name) }}">
	</div>
</div>

<div class="form-group row">
	<label for="name" class="col-sm-2 col-form-label text-lg-right">Permissions</label>
	@foreach ($permissionOptions->chunk(20) as $chunk)
		<div class="col-sm-4">
			@foreach($chunk as $permission)
				<div class="form-check">
		  	        <input class="form-check-input" type="checkbox" id="{{ $permission->name_slug }}" name="permissions[]" value="{{ $permission->name }}" {{ $checkedPermissions($permission->name) }}>
		  	        <label class="form-check-label" for="{{ $permission->name_slug }}">{{ $permission->name }}</label>
			  	</div>
			@endforeach
		</div>
	@endforeach
</div>

@isset($role->created_at)
<div class="form-group row">
	<label for="type" class="col-sm-2 col-form-label text-lg-right">สร้างเมื่อ</label>
	<div class="col-sm-10">
	      <input type="text" readonly class="form-control-plaintext" value="{{ $role->created_at->diffForHumans() }} ({{ $role->display_created_at_full_thai }})">
	</div>
</div>
@endisset