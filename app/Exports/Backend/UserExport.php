<?php

namespace App\Exports\Backend;

use App\Model\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UserExport implements FromView, ShouldAutoSize
{
	public function view(): View
	{
		$users = User::latest()->with('roles')->get();

		return view('backend.exports.users', [
			'users' => $users
		]);
	}
}
