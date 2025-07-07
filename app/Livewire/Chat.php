<?php

namespace App\Livewire;

use Livewire\Component;

class Chat extends Component
{
    public $usuarios = [];
    public $usuarioActivo;
    public $mensajes = [];
    public $nuevoMensaje = '';

    public function mount()
    {
        for ($i = 1; $i <= 10; $i++) {
            $this->usuarios[] = [
                'id' => $i,
                'nombre' => fake()->name(),
                'avatar' => rand(1, 70),
            ];
        }

        $this->usuarioActivo = $this->usuarios[0];

        // Inicializar mensajes por usuario (relleno)
        foreach ($this->usuarios as $user) {
            $this->mensajes[$user['id']] = collect([
                ['de' => 'otro', 'texto' => 'Hola, ¿cómo estás?', 'hora' => now()->subMinutes(rand(2, 10))->format('H:i')],
                ['de' => 'yo', 'texto' => 'Todo bien por aquí 😊', 'hora' => now()->subMinutes(rand(1, 5))->format('H:i')],
            ]);
        }
    }

    public function seleccionarUsuario($id)
    {
        foreach ($this->usuarios as $user) {
            if ($user['id'] == $id) {
                $this->usuarioActivo = $user;
                break;
            }
        }

        // Si no tiene mensajes, agrega simulados
        if (!isset($this->mensajes[$id])) {
            $this->mensajes[$id] = collect([
                ['de' => 'otro', 'texto' => '¿Hola? ¿Estás ahí?', 'hora' => now()->subMinutes(3)->format('H:i')],
            ]);
        }
    }

    public function enviarMensaje()
    {
        $mensaje = trim($this->nuevoMensaje);
        if ($mensaje === '') return;

        $this->mensajes[$this->usuarioActivo['id']][] = [
            'de' => 'yo',
            'texto' => $mensaje,
            'hora' => now()->format('H:i'),
        ];

        $this->nuevoMensaje = '';
    }

    public function render()
    {
        return view('livewire.chat')->layout('layouts.app');
    }
}
