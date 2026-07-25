<?php

namespace App\Modules\Backups\Http\Controllers;

use App\Shared\Http\Controllers\Controller;


class BackupControllerAPI extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'OK']);
    }
}
