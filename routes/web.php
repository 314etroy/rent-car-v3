<?php

use App\Http\Controllers\HandleRoute;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [HandleRoute::class, 'show_home'])->name('home');

Route::get('/' . __('messages.faqs'), [HandleRoute::class, 'show_faqs'])->name('faqs');
Route::get('/' . __('messages.gdpr'), [HandleRoute::class, 'show_gdpr'])->name('gdpr');
Route::get('/' . __('messages.contact'), [HandleRoute::class, 'show_contact'])->name('contact');
Route::get('/' . __('messages.about_us'), [HandleRoute::class, 'show_about_us'])->name('about_us');
Route::get('/' . __('messages.car_fleet'), [HandleRoute::class, 'show_car_fleet'])->name('car_fleet');
Route::get('/' . __('messages.reserve_now'), [HandleRoute::class, 'show_reserve_now'])->name('reserve_now');
Route::get('/' . __('messages.return_policy'), [HandleRoute::class, 'show_return_policy'])->name('return_policy');
Route::get('/' . __('messages.privacy_notice'), [HandleRoute::class, 'show_privacy_notice'])->name('privacy_notice');
Route::get('/' . __('messages.airport_transfer'), [HandleRoute::class, 'show_airport_transfer'])->name('airport_transfer');
Route::get('/' . __('messages.cancellation_policy'), [HandleRoute::class, 'show_cancellation_policy'])->name('cancellation_policy');
Route::get('/' . __('messages.terms_and_conditions'), [HandleRoute::class, 'show_terms_and_conditions'])->name('terms_and_conditions');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/' . __('messages.dashboard'), [HandleRoute::class, 'show_dashboard'])->name('dashboard');
    Route::get('/' . __('messages.reserveACar'), [HandleRoute::class, 'show_reserveACar'])->name('reserve_a_car');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('/foo', function () {
//     $target = '/home/starentinchirier/rent_files/storage/app/public';
//     $link = '/home/starentinchirier/public_html/storage';
//     symlink($target, $link);
// });

require __DIR__ . '/auth.php';
