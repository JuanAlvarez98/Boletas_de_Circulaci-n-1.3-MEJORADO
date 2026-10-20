<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BoletaCirculacion extends Model
{
    use HasFactory;

    protected $table = 'boletas_circulacion';

    protected $fillable = ['folio', 'vehicle_id', 'user_id', 'fecha_emision', 'fecha_vigencia', 'estado', 'observaciones', 'motivo_anulacion', 'anulada_por', 'anulada_at'];

    protected function casts(): array
    {
        return ['fecha_emision' => 'date', 'fecha_vigencia' => 'date', 'anulada_at' => 'datetime'];
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class)->withTrashed();
    }

    public function emisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function stickers(): HasMany
    {
        return $this->hasMany(Sticker::class, 'boleta_id');
    }

    public function actasEntrega(): HasMany
    {
        return $this->hasMany(ActaEntrega::class, 'boleta_id');
    }

    public function getVigenteAttribute(): bool
    {
        return $this->estado === 'vigente' && $this->fecha_vigencia->isTodayOrFuture();
    }
}
