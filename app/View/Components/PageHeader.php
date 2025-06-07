<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageHeader extends Component
{
    public $title, $description, $buttonUrl, $buttonText, $buttonIcon;

    public function __construct($title, $description = null, $buttonUrl = null, $buttonText = null, $buttonIcon = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->buttonUrl = $buttonUrl;
        $this->buttonText = $buttonText;
        $this->buttonIcon = $buttonIcon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.page-header');
    }
}
