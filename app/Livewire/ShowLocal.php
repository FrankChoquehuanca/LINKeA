<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;

class ShowLocal extends Component
{
    public $local;

    public $mostrarFormularioReserva = false;
    public $reservaConfirmada = false;

    // Propiedades para el formulario de reserva
    public $selectedPeople = 1;
    public $selectedDay;
    public $selectedTime;
    public $currentMonth;
    public $currentYear;
    public $tipoReserva = 'recoge'; // 'recoge' o 'delivery'

    public function mount($localId)
    {
        // Lista completa de locales con imágenes reales
        $locales = collect([
            1 => [
                'id' => 1,
                'name' => 'Café Central',
                'desc' => 'Un lugar acogedor para estudiar o relajarte.',
                'img' => 'https://estaticos.esmadrid.com/cdn/farfuture/DE3jQDUOPbXUNl2pqx3-WKq4aYORYm5gDWlJwIXeYxo/mtime:1524832504/sites/default/files/recursosturisticos/noche/CafeCentral_1412765300.719.jpg',
            ],
            2 => [
                'id' => 2,
                'name' => 'Kaos Universitario',
                'desc' => 'Ideal para socializar con estudiantes.',
                'img' => 'https://www.aragondigital.es/media/aragondigital/images/2023/09/17/20230917151956441645.jpg',
            ],
            3 => [
                'id' => 3,
                'name' => 'Cine Campus',
                'desc' => 'Descuentos para universitarios en cartelera.',
                'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRt1WYWSXQz6zgSm_6QhWK6Zsdyoop5MQhh7Q&s',
            ],
            4 => [
                'id' => 4,
                'name' => 'PizzaLink',
                'desc' => 'Pizzas y combos especiales para grupos.',
                'img' => 'https://nmrk.lat/wp-content/uploads/2023/01/pexels-max-vakhtbovych-6899401-scaled.jpg',
            ],
            5 => [
                'id' => 5,
                'name' => 'Biblioteca Cowork',
                'desc' => 'Espacio de estudio compartido con wifi.',
                'img' => 'https://i.ytimg.com/vi/Sh_Kj5OPriQ/sddefault.jpg',
            ],
            6 => [
                'id' => 6,
                'name' => 'Sala de Juegos U+',
                'desc' => 'Juegos de mesa, videojuegos y más.',
                'img' => 'https://s3-media0.fl.yelpcdn.com/bphoto/HDK4faLBcUAGqxFHhuJPsA/348s.jpg',
            ],
            7 => [
                'id' => 7,
                'name' => 'Green Smoothie Bar',
                'desc' => 'Jugos, batidos y meriendas saludables.',
                'img' => 'https://www3.gobiernodecanarias.org/medusa/ecoescuela/espacioscreativos/files/formidable/7/ima007.jpg',
            ],
            8 => [
                'id' => 8,
                'name' => 'Espacio Creativo',
                'desc' => 'Talleres de arte, manualidades y diseño.',
                'img' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/2a/c1/15/a4/caption.jpg?w=900&h=500&s=1',
            ],
            9 => [
                'id' => 9,
                'name' => 'Café Nocturno',
                'desc' => 'Café y música en vivo por las noches.',
                'img' => 'https://concepto.de/wp-content/uploads/2021/02/cine-e1614375646989.jpg',
            ],
        ]);

        $this->local = $locales->get($localId);

        if (!$this->local) {
            abort(404);
        }

        $now = now();
        $this->currentMonth = $now->month;
        $this->currentYear = $now->year;
        $this->selectedDay = $now->day;
    }

    public function reservar()
    {
        $this->mostrarFormularioReserva = true;
    }

    public function selectPeople($cantidad)
    {
        $this->selectedPeople = $cantidad;
    }

    public function selectDay($dia)
    {
        $this->selectedDay = $dia;
    }

    public function nextMonth()
    {
        if ($this->currentMonth == 12) {
            $this->currentMonth = 1;
            $this->currentYear++;
        } else {
            $this->currentMonth++;
        }
    }

    public function previousMonth()
    {
        if ($this->currentMonth == 1) {
            $this->currentMonth = 12;
            $this->currentYear--;
        } else {
            $this->currentMonth--;
        }
    }

    public function confirmarReserva()
    {
        // Validación básica
        if (!$this->selectedTime) {
            $this->addError('selectedTime', 'Por favor selecciona un horario');
            return;
        }

        // Aquí podrías guardar en base de datos si deseas
        $this->reservaConfirmada = true;
    }

    public function render()
    {
        return view('livewire.show-local')->layout('layouts.app');
    }
}
