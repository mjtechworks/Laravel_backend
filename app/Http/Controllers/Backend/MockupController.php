<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class MockupController extends Controller
{
    public function form()
    {
        $contentHeader = [
            'title' => 'Mockup',
            'subtitle' => 'Form Inputs',
            'bcs' => [
                [
                    'title' => 'Form Inputs',
                    'active' => true
                ]
            ]
        ];

        return view('backend.mockup.form', compact('contentHeader'));
    }
}
