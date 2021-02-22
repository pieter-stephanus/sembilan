<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDI\SocialiteLoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

// JetStream Routes
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Socialite Google Login
Route::get('/solo/{provider}', [SocialiteLoginController::class, 'redirectToProvider'])->name('solo.auth');
Route::get('/solo/{provider}/callback', [SocialiteLoginController::class, 'handleProviderCallback'])->name('solo.callback');


