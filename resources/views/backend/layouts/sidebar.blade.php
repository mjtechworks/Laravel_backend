<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<a href="{{ route('backend.dashboard') }}" class="brand-link">
		<img src="{{ asset('images/backend/logo.png') }}"
		alt="AdminLTE Logo"
		class="brand-image img-circle elevation-3"
		style="opacity: .8">
		<span class="brand-text font-weight-light">Laravel Backend</span>
	</a>

	<div class="sidebar">

		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="{{ auth()->user()->avatar_thumb }}" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="{{ route('backend.profile.edit') }}" class="d-block">{{ auth()->user()->name }}</a>
			</div>
		</div>

		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false" data-expandSidebar="true">
				<li class="nav-item">
					<a href="{{ route('backend.dashboard') }}" class="nav-link {{ request()->routeIs('backend.dashboard*') ? 'active' : '' }}">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Dashboard
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon far fa-file-alt"></i>
						<p>Mockup Menu</p>
					</a>
				</li>
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-vector-square"></i>
						<p>
							Mockup
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('backend.mockup.form') }}" class="nav-link {{ request()->routeIs('backend.mockup*') ? 'active' : '' }}">
								<i class="fas fa-clipboard-list nav-icon"></i>
								<p>Form Inputs</p>
							</a>
						</li>
					</ul>
				</li>
				@canany(['access user list', 'access role list'])
					<li class="nav-item has-treeview">
						<a href="#" class="nav-link">
							<i class="nav-icon fas fa-cogs"></i>
							<p>
								Settings
								<i class="fas fa-angle-left right"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							@can('access user list')
								<li class="nav-item">
									<a href="{{ route('backend.user.index') }}" class="nav-link {{ request()->routeIs('backend.user*') ? 'active' : '' }}">
										<i class="far fa-user nav-icon"></i>
										<p>Users</p>
									</a>
								</li>
							@endcan
							@can('access role list')
								<li class="nav-item">
									<a href="{{ route('backend.role.index') }}" class="nav-link {{ request()->routeIs('backend.role*') ? 'active' : '' }}">
										<i class="fas fa-cog nav-icon"></i>
										<p>Roles</p>
									</a>
								</li>
							@endcan
						</ul>
					</li>
				@endcanany
				@canany(['access trash list'])
					<li class="nav-header">OTHERS</li>
					<li class="nav-item">
						<a href="{{ route('backend.trash.index') }}" class="nav-link {{ request()->routeIs('backend.trash*') ? 'active' : '' }}">
							<i class="nav-icon fas fa-trash-alt"></i>
							<p>
								Trash
							</p>
						</a>
					</li>
				@endcanany
			</ul>
		</nav>
	</div>
</aside>