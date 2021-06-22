<?php

namespace App\Exports;

use App\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubscriptionsExport implements FromCollection, WithHeadings
{
    protected $event_id;
    
    public function __construct($event_id) {
        $this->event_id = $event_id;
    }

    public function headings():array {
        return [
            'ID',
            'Nombre',
            'Apellido',
            'Email',
            'Fecha suscripción'
        ];
    }

    public function collection() {
        return Event::where('id', $this->event_id)->first()->users;
    }
}