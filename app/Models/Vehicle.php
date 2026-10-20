<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['placa', 'numero_equipo', 'chasis', 'motor', 'marca', 'modelo', 'linea', 'anio', 'color', 'naturaleza_origen', 'sap_codigo'];

    protected function casts(): array
    {
        return ['anio' => 'integer'];
    }

    public function boletas(): HasMany
    {
        return $this->hasMany(BoletaCirculacion::class);
    }

    public function stickers(): HasMany
    {
        return $this->hasMany(Sticker::class);
    }

    public function actasEntrega(): HasMany
    {
        return $this->hasMany(ActaEntrega::class);
    }

    public function getNombreCortoAttribute(): string
    {
        return "{$this->placa} - {$this->marca} {$this->modelo}";
    }
}
