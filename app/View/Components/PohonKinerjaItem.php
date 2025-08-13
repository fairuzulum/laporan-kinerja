<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PohonKinerjaItem extends Component
{
    public $item;
    public $level;

    /**
     * Create a new component instance.
     *
     * @param mixed $item Instance of PohonKinerja model
     * @param int $level The current depth level of the item
     */
    public function __construct($item, $level = 0)
    {
        $this->item = $item;
        $this->level = $level;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.pohon-kinerja-item');
    }
}