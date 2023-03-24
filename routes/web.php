<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoutesImportController;
use App\Http\Controllers\TrucksImportController;
use App\Http\Controllers\ExpensesDataTableController;
use App\Http\Controllers\ReportExportController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {



    Route::group(['middleware' => ['role:Super Admin']], function () {
        Route::get('/trucks', \App\Http\Livewire\Trucks::class)->name('trucks');
        Route::get('/stations', \App\Http\Livewire\Stations::class)->name('stations');
        Route::get('/comments', \App\Http\Livewire\Comments::class)->name('comments');
        Route::get('/routes', \App\Http\Livewire\Routes::class)->name('routes');
        Route::post('/routes/import', [RoutesImportController::class, 'upload']);
        Route::get('/routes/upload', [RoutesImportController::class, 'showUploadForm'])->name('import.routes');
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::post('/trucks/import', [TrucksImportController::class, 'upload']);
        Route::get('/trucks/upload', [TrucksImportController::class, 'showUploadForm'])->name('import.trucks');
        Route::get('/local',  \App\Http\Livewire\Local::class)->name('local');
        Route::get('/distances/{local}', \App\Http\Livewire\AddDistance::class)->name('add.distance');
    });

    Route::get('/fuel/modify', \App\Http\Livewire\Fuel::class)->name('fuel.modify');

    // Route::get('/reports', \App\Http\Livewire\FuelReport::class)->name('reports');

    Route::get('/lpos/{loading}', \App\Http\Livewire\AddLpo::class)->name('add.lpo');

    // Route::get('/invoice',  [InvoiceGenController::class, 'invoice']);
    Route::get('/invoice',  \App\Http\Livewire\InvoiceGen::class)->name('gen.lpo');

    Route::get('/analysis',  \App\Http\Livewire\Analysis::class)->name('analysis');

    Route::get('/reports',  \App\Http\Livewire\Report::class)->name('reports');

    // Route::get('/reports', [ExpensesDataTableController::class, 'show'])->name('reports');

    Route::get('/export/reports', [ReportExportController::class, 'export'])->name('export');

    // Route::get('/distance/reports',  \App\Http\Livewire\DistanceReport::class)->name('distance.reports');


});
