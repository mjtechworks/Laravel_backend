@extends('backend.layouts.app')

@section('content')
<section class="content">
	<div class="container-fluid">

		@if ($users->count() > 0)
			<div class="row">
				<div class="col">
					<div class="card card-primary card-outline">
						<div class="card-header">
							<h3 class="card-title py-1">User List</h3>
							<div class="card-tools">
								<a class="btn btn-sm btn-info" href="{{ route('backend.trash.restore-all', ['model' => 'user']) }}">
									Restore All
								</a>
								<a class="btn btn-sm btn-danger" href="{{ route('backend.trash.remove-all', ['model' => 'user']) }}">
									Remove Permanently All
								</a>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body text-sm">
							<div class="row">
								@foreach ($users as $user)
									<div class="col col-md-3">
										<div class="card">
											<div class="card-body">
												<dl class="row">
													<dt class="col-4">ID</dt>
													<dd class="col-8">{{ $user->id }}</dd>
													<dt class="col-4">Name</dt>
													<dd class="col-8 text-truncate">{{ $user->name }}</dd><dt class="col-4">Email</dt>
													<dd class="col-8 text-truncate">{{ $user->email }}</dd>
													<dt class="col-4">Deleted</dt>
													<dd class="col-8">{{ $user->deleted_at->diffForHumans() }}</dd>
												</dl>
												<a href="{{ route('backend.trash.restore', ['user', $user->id]) }}" class="card-link text-info">Restore</a>
												<a href="{{ route('backend.trash.remove', ['user', $user->id]) }}" class="card-link text-danger">Remove Permanently</a>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
			</div>
		@endif

	</div>
</section>
@endsection

@push('after-scripts')
	<script>
		$('a[href$="restore-all"]').on('click', function(){
			return confirm('ต้องการ Restore All ?');
		});
		$('a[href$="remove-all"]').on('click', function(){
			return confirm('ต้องการ Remove Permanently All ?');
		});
		$('a[href$="restore"]').on('click', function(){
			return confirm('ต้องการ Restore ?');
		});
		$('a[href$="remove"]').on('click', function(){
			return confirm('ต้องการ Remove Permanently ?');
		});
	</script>
@endpush