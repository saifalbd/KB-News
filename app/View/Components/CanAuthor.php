<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CanAuthor extends Component
{
    public $author;
    public $can;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($author,$can)
    {
        $this->author = $author;
        $this->can = $can;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.can-author');
    }
}
