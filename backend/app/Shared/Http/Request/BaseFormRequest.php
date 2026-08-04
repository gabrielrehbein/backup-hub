<?php

namespace App\Shared\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseFormRequest extends FormRequest
{
    abstract public function toDTO(): object;
}
