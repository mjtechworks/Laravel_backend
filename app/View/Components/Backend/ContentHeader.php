<?php

namespace App\View\Components\Backend;

use Illuminate\View\Component;

class ContentHeader extends Component
{
    public $contentHeader;

    public function __construct($contentHeader)
    {
        $this->contentHeader = $contentHeader;
    }

    public function render()
    {
        return view('backend.components.content-header');
    }
}
