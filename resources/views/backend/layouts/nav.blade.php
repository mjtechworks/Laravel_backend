<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  	<ul class="navbar-nav">
	    <li class="nav-item">
	      	<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
	    </li>
	    {{-- <li class="nav-item d-none d-sm-inline-block">
	      	<a href="#" class="nav-link">Home Page</a>
	    </li> --}}
  	</ul>
  	<ul class="navbar-nav ml-auto">
    	<li class="nav-item">
    		<form action="{{ route('backend.auth.logout') }}" method="POST">
    			@csrf
    			<button type="submit" class="btn btn-link">
    				<i class="fas fa-sign-out-alt"></i> Logout
    			</button>
    		</form>
    	</li>
  	</ul>
</nav>