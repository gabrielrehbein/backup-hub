<?php

namespace App\Modules\Systems\Models;

use App\Modules\Systems\Enums\SystemCategoryEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    /** @use HasFactory<\Database\Factories\SystemFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
    ];

    protected $casts = [
        'category' => SystemCategoryEnum::class,
    ];

    public function instances()
    {
        return $this->hasMany(SystemInstance::class);
    }
}
