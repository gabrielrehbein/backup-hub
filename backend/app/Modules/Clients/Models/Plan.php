<?php

namespace App\Modules\Clients\Models;

use App\Modules\Risks\Models\Risk;
use App\Modules\Clients\Database\Factories\PlanFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function risks()
    {
        return $this->hasMany(Risk::class);
    }

    protected static function newFactory()
    {
        return PlanFactory::new();
    }
}
