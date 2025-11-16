<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddProjectModal extends Component
{
    public string $id;
    /**
     * Create a new component instance.
     */
    public function __construct(string $id = 'add-project-modal')
    {
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.add-project-modal');
    }
}
