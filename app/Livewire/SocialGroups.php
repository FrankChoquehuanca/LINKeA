<?php

namespace App\Livewire;

use Livewire\Component;

class SocialGroups extends Component
{
    public $search = '';
    public $groups = [
        ['name' => 'Pichangas', 'color' => 'blue', 'initial' => 'P'],
        ['name' => 'Ayuda de trabajos', 'color' => 'green', 'initial' => 'A'],
        ['name' => 'Estudiantes Informática', 'color' => 'purple', 'initial' => 'E'],
        ['name' => 'Deportes U', 'color' => 'yellow', 'initial' => 'D'],
    ];

    public function getFilteredGroupsProperty()
    {
        return collect($this->groups)->filter(fn($g) =>
            str_contains(strtolower($g['name']), strtolower($this->search))
        );
    }

    public function render()
    {
        return view('livewire.social-groups');
    }
}
