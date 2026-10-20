<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sticker extends Model
{
    use HasFactory;

    protected $fillable = ['codigo', 'verification_token', 'vehicle_id', 'boleta_id', 'user_id', 'fecha_emision', 'estado', 'motivo_anulacion', 'anulado_por', 'anulado_at'];

    protected function casts(): array
    {
        return ['fecha_emision' => 'date', 'anulado_at' => 'datetime'];
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class)->withTrashed();
    }

    public function boleta(): BelongsTo
    {
        return $this->belongsTo(BoletaCirculacion::class, 'boleta_id');
    }

    public function emisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getContenidoQrAttribute(): string
    {
        return route('stickers.verify', $this->verification_token);
    }
}
