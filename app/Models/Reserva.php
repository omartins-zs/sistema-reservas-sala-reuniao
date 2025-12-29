<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reserva extends Model
{
    protected $table = 'reservas';

    protected $fillable = [
        'usuario_id',
        'sala_id',
        'data_reserva',
        'horario_inicio',
        'horario_fim',
    ];

    protected $casts = [
        'data_reserva' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function sala(): BelongsTo
    {
        return $this->belongsTo(Sala::class, 'sala_id');
    }
}
