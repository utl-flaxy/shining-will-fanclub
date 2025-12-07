<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class PageHeader extends Component
{
    public string $title;
    public ?string $subtitle;

    public function __construct(string $title, string $subtitle = null)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
    }

    public function render()
    {
        return view('components.admin.page-header');
    }
}
