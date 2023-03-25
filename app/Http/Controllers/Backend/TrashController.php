<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function index()
    {
    	$this->authorize('access trash list');

    	$contentHeader = [
    	    'title' => 'Trash',
    	    'bcs' => [
    	        [
    	            'title' => 'Trash',
    	            'active' => true
    	        ]
    	    ]
    	];

        $users = \App\Model\User::onlyTrashed()->orderBy('deleted_at', 'desc')->get();

    	return view('backend.trash.index', compact('contentHeader', 'users'));
    }

    public function restore($model, $modelId)
    {
    	$this->authorize('restore trash list');

    	$this->getModel($model)::withTrashed()->find($modelId)->restore();

    	return $this->afterAction('Successfully restored!');
    }

    public function restoreAll($model)
    {
    	$this->authorize('restore all trash list');

    	$this->getModel($model)::withTrashed()->restore();

    	return $this->afterAction('Successfully restored all!');
    }

    public function remove($model, $modelId)
    {
    	$this->authorize('remove trash list');

    	$this->getModel($model)::withTrashed()->find($modelId)->forceDelete();

    	return $this->afterAction('Successfully removed permanently!');
    }

    public function removeAll($model)
    {
    	$this->authorize('remove all trash list');

        /**
         * This command will not remove medias in mediacollection because mass assignment in document
         */
    	// $this->getModel($model)::onlyTrashed()->forceDelete();
        
        $modelItems = $this->getModel($model)::onlyTrashed()->get();

        foreach($modelItems as $modelItem) {
            $modelItem->forceDelete();
        }

    	return $this->afterAction('Successfully removed permanently all!');
    }

    private function afterAction($alertText)
    {
    	$alert = [
    		'alert-type' => 'success',
    		'alert-message' => $alertText,
    	];

    	return redirect(route('backend.trash.index'))->with($alert);
    }

    private function getModel($model)
    {
    	$class = '\App\Model\Backend\\' . ucfirst($model);
        if (!class_exists($class)) {
            $class = '\App\Model\\' . ucfirst($model);
        }
        return get_class(new $class);
    }
}
