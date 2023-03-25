@extends('backend.layouts.app')

@section('content')
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				@can('access user list')
					<div class="col-lg-3 col-6">
						<div class="small-box bg-teal position-relative">
							<div class="inner">
								<h3>{{ $countUser }}</h3>
								<p>User List</p>
							</div>
							<div class="icon">
								<i class="fas fa-user"></i>
							</div>
							<a href="{{ route('backend.user.index') }}" class="small-box-footer stretched-link">More info <i class="fas fa-arrow-circle-right"></i></a>
						</div>
					</div>
				@endcan
			</div>
		</div>
	</section>
@endsection