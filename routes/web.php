<?php

use Illuminate\Support\Facades\Route;
use App\Models\Ip;

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

Route::group(['namespace' => 'App\Http\Controllers'], function() {

    Route::group(['middleware' => ['auth', 'verified', 'ips']], function () {
        /**
         * Standard routes
         */
        Route::get('/', 'DashBoardController@index')->name('dashboard');
        Route::get('/profile', 'ProfileController@index')->name('profile');
        /**
         * Resource routes
         */
        Route::resource('/agencies', 'AgencyController');
        Route::resource('/categories', 'CategoryController');
        Route::resource('/countries', 'CountryController');
        Route::resource('/forms', 'FormController');
        Route::resource('/roles', 'RoleController');
        Route::resource('/states', 'StateController');
        Route::resource('/users', 'UserController');
        Route::resource('/completed-forms', 'ValidateController', ['except' => ['create', 'update']]);
        Route::resource('/geographic-zones', 'ZoneController');
        Route::resource('/missions', 'MissionController');
        Route::resource('/societies', 'SocietyController');
        Route::resource('/emails', 'EmailController');
        /**
         * Tools routes
         */
        Route::get('/pdf/display/{id}', 'PDFController@index')->name('pdf.display');
        Route::get('/pdf/download/{id}', 'PDFController@download')->name('pdf.download');
        Route::post('/modals/{slug}', 'ModalController@index')->name('ajax.modals');
        Route::post('/ajax/{slug}', 'AjaxController@index')->name('ajax.actions');
    });
});
/*
 * Errors routes
 */
Route::get('/banished-ip', function(){

    $ip = Ip::select('attempts', 'is_ban')->where('address', \Request::ip())->first();
    if ($ip === null || $ip->attempts < config('auth.attempts')) {
        return redirect('login');
    }
    return view('errors.banish');
    
})->name('banish');


