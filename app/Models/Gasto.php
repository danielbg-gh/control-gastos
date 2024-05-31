<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gasto extends Model
{
    use HasFactory;
    
    protected $table = 'gasto';

    protected $fillable = [
        'id_tipo_pago',
        'fecha',
        'monto',
        'descripcion',
    ];

    public function tipoPago(): BelongsTo
    {
        return $this->belongsTo(TipoPago::class, 'id_tipo_pago', 'id_tipo_pago');
    }
}
