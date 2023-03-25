<?php

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
*/

// Auth::routes();

Route::get('/', function(){
	return redirect()->route('backend.dashboard');
});

Route::name('backend.auth.')
	->namespace('Backend\Auth')
	->group(function(){
		Route::get('/login', 'LoginController@showLoginForm')->name('login.form');
		Route::post('/login', 'LoginController@login')->name('login');
		Route::post('/logout', 'LoginController@logout')->name('logout');           
});

Route::name('backend.')
	->namespace('Backend')
	->middleware(['backend.auth', 'user.active'])
	->group(function(){
		Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

		// Trash
		Route::name('trash.')
			->prefix('trash')
			->group(function(){
				Route::get('/', 'TrashController@index')->name('index');
				Route::get('/{model}/restore-all', 'TrashController@restoreAll')->name('restore-all');
				Route::get('/{model}/remove-all', 'TrashController@removeAll')->name('remove-all');
				Route::get('/{model}/{modelId}/restore', 'TrashController@restore')->name('restore');
				Route::get('/{model}/{modelId}/remove', 'TrashController@remove')->name('remove');
			});

		// Profile
		Route::name('profile.')
			->prefix('profile')
			->group(function(){
				Route::get('/', function(){
					return redirect(route('backend.profile.edit'));
				});
				Route::get('/edit', 'ProfileController@edit')->name('edit');
				Route::patch('/', 'ProfileController@update')->name('update');
				Route::get('/check-valid-email', 'UserController@isValidEmail')->name('check-valid-email');
			});

		// User
		Route::name('user.')
			->prefix('user')
			->group(function(){
				Route::get('/list-data', 'UserController@listData')->name('list-data');
				Route::get('/export', 'UserController@export')->name('export');
				Route::get('/check-valid-email', 'UserController@isValidEmail')->name('check-valid-email');
		});
		Route::resource('user', 'UserController'); // Resource must be last

		// Role
		Route::name('role.')
			->prefix('role')
			->group(function(){
				Route::get('/list-data', 'RoleController@listData')->name('list-data');
				Route::get('/check-valid-name', 'RoleController@isValidName')->name('check-valid-name');
		});
		Route::resource('role', 'RoleController'); // Resource must be last

		// Mockup
		Route::name('mockup.')
			->prefix('mockup')
			->group(function(){
				Route::get('/form', 'MockupController@form')->name('form');
		});

		// Laravel Filemanager
		Route::group(['prefix' => 'laravel-filemanager'], function () {
		    \UniSharp\LaravelFilemanager\Lfm::routes();
		});

});
