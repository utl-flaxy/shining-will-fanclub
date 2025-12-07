<?php

namespace App\View\Components\Members;

use Illuminate\View\Component;

class Header extends Component
{
    public string $title;
    public string $back;

    public function __construct($title, $back)
    {
        $this->title = $title;
        $this->back = $back;
    }

    public function render()
    {
        return view('components.members.header');
    }
}
