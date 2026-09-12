<?php

namespace App\Modules\Systems\Models;

use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    protected $fillable = [
        "name"
    ];

    public function systems(){
        return $this->hasMany(System::class);
    }
}
