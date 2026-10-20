<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActaEntrega extends Model
{
    use HasFactory;

    protected $table = 'actas_entrega';

    protected $fillable = [
        'folio',
        'vehicle_id',
        'boleta_id',
        'user_id',
        'entrega_nombre',
        'recibe_nombre',
        'recibe_identidad',
        'recibe_email',
        'fecha_entrega',
        'observaciones',
        'enviado_email_at',
        'estado',
        'motivo_anulacion',
        'anulada_por',
        'anulada_at',
    ];

    protected function casts(): array
    {
        return [
            'fecha_entrega' => 'date',
            'enviado_email_at' => 'datetime',
            'anulada_at' => 'datetime',
        ];
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class)->withTrashed();
    }

    public function boleta(): BelongsTo
    {
        return $this->belongsTo(BoletaCirculacion::class, 'boleta_id');
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

