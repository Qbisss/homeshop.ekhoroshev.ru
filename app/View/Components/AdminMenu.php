<?php

namespace App\View\Components;

use Illuminate\View\Component;

class catalog extends Component
{
    public function __construct(
        public string $page = ''
    )
    {
        //
    }

    public function render()
    {
        return view('components.admin.menu');
    }
}
