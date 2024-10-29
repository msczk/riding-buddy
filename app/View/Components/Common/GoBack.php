<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GoBack extends Component
{
    private string $url;

    /**
     * Create a new component instance.
     */
    public function __construct(string $url = '')
    {
        if (empty($url)) {
            $this->url = url()->previous();
        } else {
            $this->url = $url;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.common.go-back')->with('url', $this->url);
    }
}
