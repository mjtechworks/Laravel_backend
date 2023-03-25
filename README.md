# laravel-backend
Laravel backend with AdminLTE 3 (Laravel ^7.0)

## Installation
1. ```git clone https://github.com/toyza55k/laravel-backend.git .```
1. ```composer install```
1. ```npm install``` (do not run in docker container)
1. edit database in .env file
	```
	APP_URL=YOUR_APP_URL
	.
	DB_CONNECTION=mysql
	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=laravel
	DB_USERNAME=root
	DB_PASSWORD=
	```
1. ```php artisan key:generate```
1. ```
	php artisan migrate:fresh --seed
	or 
	php artisan migrate
	php artisan db:seed
	```
1. ```php artisan storage:link```

## Username Password
	url: YOUR_APP_URL/backend
| Role  | Username | Password |
| --- | --- | --- |
| super admin  | superadmin@admin.com | superadmin_backend |
| admin  | admin@admin.com | admin_backend |
| general user  | general-user@admin.com | general_user_backend |

### Add permission
1. database/seeds/updates/UserRolePermissionSeeder.php
	```
	private function userPermissions()
	{
	    return [
	        'add example',
	        'edit example'
	    ];
	}
	```
1. ```
	php artisan db:seed --class=UserRolePermissionSeeder
	```
	all permission auto assigned to 'admin' role.

### Task Schedules
for removing activity log and force delete rows in trash.
```* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1```

### Production with shared host
in .env  file
```
FILESYSTEM_DRIVER=public_share_hosted
MEDIA_DISK=public_share_hosted
```

### use composer package
- spatie/laravel-activitylog
- maatwebsite/excel
- spatie/laravel-medialibrary
- spatie/laravel-permission
- spatie/laravel-view-models
- tightenco/quicksand
- yajra/laravel-datatables-oracle

### use npm package
- admin-lte
- inputmask
- jquery-validation
- ladda
- toastr

### adminLTE 
- document https://adminlte.io/docs/3.0/index.html
- demo https://adminlte.io/themes/v3/index.html

