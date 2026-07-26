<?php

namespace App\Modules\Risks\Models;

use App\Modules\Clients\Models\Plan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risk extends Model
{
    /** @use HasFactory<\Database\Factories\RiskFactory> */
    use HasFactory;

    protected $fillable = [
        "name",
        "level",
        "description",
        "notifiable",
        "max_delay_limit_in_minutes",
        "max_size_loss_in_percent",
        "plan_id",
    ];

    public function plans(){
        return $this->belongsTo(Plan::class);
    }
}
