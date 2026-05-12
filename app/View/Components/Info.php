<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Info extends Component
{
    public $label;
    public $value;

    public function __construct($label = null, $value = null)
    {
        $this->label = $label;
        $this->value = $value;
    }

    public function render()
    {
        return view('components.info');
    }
}
