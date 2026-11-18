<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'placa',
        'numero_equipo',
        'chasis',
        'motor',
        'marca',
        'modelo',
        'linea',
        'anio',
        'color',
        'naturaleza_origen',
        'sap_codigo',
        'dependencia',
        'denominacion',
        'estado_sap',
        'tipo_equipo',
        'centro_costo',
        'centro',
        'kilometraje',
    ];

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
        $idRef = $this->numero_equipo ? "Eq. {$this->numero_equipo}" : ($this->placa ?: 'S/P');
        $desc = trim("{$this->marca} {$this->modelo}");
        return $desc !== '' ? "{$idRef} - {$desc}" : $idRef;
    }
}
