<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sala extends Model
{
    use HasFactory;
    protected $table = 'salas';

    protected $fillable = [
        'nome',
        'capacidade',
        'localizacao',
        'horario_abertura',
        'horario_fechamento',
    ];

    protected $casts = [
        'capacidade' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'sala_id');
    }
}
