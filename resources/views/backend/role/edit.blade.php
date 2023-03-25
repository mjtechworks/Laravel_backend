@extends('backend.layouts.app')

@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<form action="{{ route('backend.role.update', $role) }}" method="POST" id="form_edit_role" autocomplete="off">
					@method('PATCH')
					@csrf
					<div class="card card-warning card-outline">
						<div class="card-header">
							<h3 class="card-title py-1"><i class="fas fa-wrench"></i> แก้ไข Role</h3>
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

@push('after-scripts')
<script>
	$('#form_edit_role').validate({
		rules: {
			name: {
				required: true,
				remote: {
					url: '{{ route('backend.role.check-valid-name') }}',
					type: "get",
					data: {
						name: function() {
							return $( 'input[name="name"]' ).val();
						},
						id: {{ $role->id }}
					}
				}
			}
		},
		messages: {
			name: {
				remote: 'Role นี้มีอยู่แล้วในระบบ กรุณาเปลี่ยนใหม่'
			}
		}
	});
</script>
@endpush