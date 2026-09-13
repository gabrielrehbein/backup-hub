<?php

namespace App\Modules\Systems\Http\Controllers;

use App\Modules\Systems\Models\Category;
use App\Shared\Http\Controllers\Controller;
use App\Shared\Http\Responses\JSONResponse;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return JSONResponse::success($categories);
    }
}
