<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class BuscarPerfiles extends Component
{
    public $query = '';

    public function render()
    {
        $usuarios = User::where('name', 'like', "%{$this->query}%")
                        ->orderBy('name')
                        ->limit(20)
                        ->get();

        return view('livewire.buscar-perfiles', compact('usuarios'))
            ->layout('layouts.app');
    }
}
