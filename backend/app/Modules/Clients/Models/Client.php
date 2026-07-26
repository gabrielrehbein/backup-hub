<?php

namespace App\Modules\Clients\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;

    // PENSAR EM CRIAR CLASSE CONTATOS
    protected $fillable = [
        'name',
        'external_id',
        'plan_id',
        'api_key',
        'is_active',
        'description',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
