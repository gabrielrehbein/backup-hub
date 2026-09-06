<?php


require base_path('app/Modules/Clients/Routes/planRoutes.php');
require base_path('app/Modules/Risks/Routes/riskRoutes.php');
require base_path('app/Modules/Clients/Routes/clientRoutes.php');
require base_path('app/Modules/Users/Routes/userRoutes.php');
require base_path('app/Modules/Systems/Routes/systemRoutes.php');
require base_path('app/Modules/Systems/Routes/systemInstanceRoutes.php');
require base_path('app/Modules/Backups/Routes/backupRoutes.php');
require base_path('app/Modules/Auth/Routes/authRoutes.php');
require base_path('app/Modules/Dashboard/Routes/dashboardRoutes.php');

use App\Modules\Notifications\Http\Controllers\NotificationController;
use App\Shared\Http\Controllers\SeederController;
use Illuminate\Support\Facades\Route;

Route::post('/notifications/send', [NotificationController::class, 'send']);
Route::post('/seed', [SeederController::class, 'seed']);
