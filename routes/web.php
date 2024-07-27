<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\ClinicalTestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use Illuminate\Foundation\Application;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Spatie\Browsershot\Browsershot;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('clinical-test', ClinicalTestController::class);
    Route::resource('doctor', DoctorController::class);
    Route::resource('patient', PatientController::class);
    Route::resource('appointment', AppointmentController::class);
    Route::resource('account', AccountController::class);
    Route::resource('billing', BillingController::class);

    Route::get('/invoices/{filename}', function ($filename) {
        $path = storage_path('app/invoice/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });

});
Route::get('pdf', function () {
//    return view('invoice.invoice');
    /*$template = view('invoice.invoice')->render();
    Browsershot::html($template)
        ->footerHtml(view('invoice.invoice-footer')->render())
        ->waitUntilNetworkIdle()
        ->noSandbox()
        ->usePipe()
        ->ignoreHttpsErrors()
        ->showBackground()
        ->margins(4, 0, 4, 0)
        //->landscape()
        ->format('A4')
        ->save(storage_path('/app/reports/example.pdf'));*/
});

require __DIR__ . '/auth.php';
