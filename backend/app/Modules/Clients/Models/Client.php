<?php

namespace App\Modules\Clients\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
