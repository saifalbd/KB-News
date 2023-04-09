<?php

namespace App\View\Components;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\View\Component;

class RightSideBar extends Component
{


    public $populars;

    public $trendings;
    public $tags;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $populars = Post::query()->where('on_popular',true)->list()->withCount('views')->get();
        $trendings = Post::query()->where('on_trending',true)->list()->get();
        $this->tags = Tag::query()->popular()->get();
        $this->populars = $populars;
        $this->trendings = $trendings;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.right-side-bar');
    }
}
