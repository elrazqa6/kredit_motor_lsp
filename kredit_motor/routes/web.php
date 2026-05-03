<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// ============================================================
// PUBLIC - Bisa diakses tanpa login
// ============================================================
Route::get('/', [\App\Http\Controllers\Client\DashboardController::class, 'index'])->name('home');

// Katalog motor PUBLIK (tanpa login)
Route::get('/motor',      [\App\Http\Controllers\Client\MotorController::class, 'index'])->name('client.motor.index');
Route::get('/motor/{id}', [\App\Http\Controllers\Client\MotorController::class, 'show'])->name('client.motor.show');

Auth::routes(['register' => true]);

// ============================================================
// ADMIN (Full Akses - Master Data & Transaksi)
// ============================================================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Master Data (Khusus Admin)
        Route::resource('motor',         \App\Http\Controllers\Admin\MotorController::class);

        Route::resource('jenis-cicilan', \App\Http\Controllers\Admin\JenisCicilanController::class);
        Route::resource('asuransi',      \App\Http\Controllers\Admin\AsuransiController::class);
        Route::resource('metode-bayar',  \App\Http\Controllers\Admin\MetodeBayarController::class);
        
        Route::resource('jenis-motor', \App\Http\Controllers\Admin\JenisMotorController::class);
Route::get('/jenis-motor/{id}/toggle', [\App\Http\Controllers\Admin\JenisMotorController::class, 'toggleStatus'])->name('jenis-motor.toggle');
           
        // Hero Banner
        Route::resource('hero', \App\Http\Controllers\Admin\HeroController::class);
        Route::get('/hero/{id}/toggle', [\App\Http\Controllers\Admin\HeroController::class, 'toggleStatus'])->name('hero.toggle');
        

        // Sistem (Khusus Admin)
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    });

    

// ============================================================
// MARKETING (Akses Transaksi - Tanpa Master Data)
// ============================================================
Route::prefix('marketing')
    ->name('marketing.')
    ->middleware(['auth', 'role:marketing'])
    ->group(function () {

        // Dashboard Marketing
        Route::get('/dashboard', [\App\Http\Controllers\Marketing\DashboardController::class, 'index'])->name('dashboard');

        Route::put('/pengajuan/{id}/update-status-dp', [\App\Http\Controllers\Marketing\PengajuanController::class, 'updateStatusDp'])
    ->name('pengajuan.update-status-dp');

        // Transaksi (Marketing bisa kelola)
        Route::resource('pengajuan',  \App\Http\Controllers\Marketing\PengajuanController::class);
        Route::resource('kredit',     \App\Http\Controllers\Marketing\KreditController::class);
        Route::resource('angsuran',   \App\Http\Controllers\Marketing\AngsuranController::class);
        Route::resource('pengiriman', \App\Http\Controllers\Marketing\PengirimanController::class);
        Route::put('pengiriman/{id}/status', [\App\Http\Controllers\Marketing\PengirimanController::class, 'updateStatus'])->name('pengiriman.updateStatus');

        // ========== PENGAJUAN OFFLINE ==========
        Route::prefix('pengajuan-offline')->name('pengajuan-offline.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Marketing\PengajuanOfflineController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Marketing\PengajuanOfflineController::class, 'create'])->name('create');
            Route::post('/store', [\App\Http\Controllers\Marketing\PengajuanOfflineController::class, 'store'])->name('store');
            Route::get('/success/{id}', [\App\Http\Controllers\Marketing\PengajuanOfflineController::class, 'success'])->name('success');
        });
    });

// ============================================================
// CLIENT - Harus login
// ============================================================
Route::prefix('client')
    ->name('client.')
    ->middleware(['auth', 'role:client'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Client\DashboardController::class, 'index'])->name('dashboard');

        // Kredit
        Route::resource('pengajuan', \App\Http\Controllers\Client\PengajuanController::class);
        Route::delete('pengajuan/{id}/cancel', [\App\Http\Controllers\Client\PengajuanController::class, 'cancel'])
            ->name('pengajuan.cancel');

        // Angsuran
        Route::resource('angsuran', \App\Http\Controllers\Client\AngsuranController::class)
            ->only(['index', 'show']);

        // Bayar angsuran via Midtrans (redirect)
        Route::get('/angsuran/{id}/bayar', function($id) {
            return redirect()->route('midtrans.pay.angsuran', $id);
        })->name('angsuran.form-bayar');

        // Print kwitansi
        Route::get('/angsuran/{id}/print', [App\Http\Controllers\Client\AngsuranController::class, 'print'])->name('angsuran.print');

        // Pengiriman (lacak)
        Route::get('/pengiriman',      [\App\Http\Controllers\Client\PengirimanController::class, 'index'])
            ->name('pengiriman.index');
        Route::get('/pengiriman/{id}', [\App\Http\Controllers\Client\PengirimanController::class, 'show'])
            ->name('pengiriman.show');

        // Profil
        Route::get('/profil', [\App\Http\Controllers\Client\ProfilController::class, 'index'])
            ->name('profil');
        Route::put('/profil', [\App\Http\Controllers\Client\ProfilController::class, 'update'])
            ->name('profil.update');
    });

   // ============================================================
// CEO ROUTES
// ============================================================
// ============================================================
// CEO ROUTES
// ============================================================
Route::prefix('ceo')
    ->name('ceo.')
    ->middleware(['auth', 'role:ceo'])
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [App\Http\Controllers\Ceo\DashboardController::class, 'index'])->name('dashboard');
        
        // Manajemen User
        Route::resource('users', App\Http\Controllers\Ceo\UserController::class);
        
        // Laporan Kredit
        Route::get('/kredit', [App\Http\Controllers\Ceo\KreditController::class, 'index'])->name('kredit.index');
        Route::get('/kredit/export', [App\Http\Controllers\Ceo\KreditController::class, 'export'])->name('kredit.export');
        
        // Data Motor
        Route::get('/motor', [App\Http\Controllers\Ceo\MotorController::class, 'index'])->name('motor.index');
        Route::get('/motor/export', [App\Http\Controllers\Ceo\MotorController::class, 'export'])->name('motor.export');
        
        // Analitik
        Route::get('/analitik', [App\Http\Controllers\Ceo\AnalitikController::class, 'index'])->name('analitik.index');
        Route::get('/analitik/export', [App\Http\Controllers\Ceo\AnalitikController::class, 'export'])->name('analitik.export');

         Route::get('/export', [App\Http\Controllers\Ceo\ExportController::class, 'index'])->name('export.index');
        Route::get('/export/process', [App\Http\Controllers\Ceo\ExportController::class, 'exportData'])->name('export.process');
        Route::get('/export/all', [App\Http\Controllers\Ceo\ExportController::class, 'exportAll'])->name('export.all');
    });
// ============================================================
// MIDTRANS ROUTES
// ============================================================
Route::prefix('midtrans')->name('midtrans.')->group(function () {
    Route::get('/pay-dp/{id}', [App\Http\Controllers\MidtransController::class, 'payDp'])->name('pay.dp');
    Route::get('/pay-angsuran/{id}', [App\Http\Controllers\MidtransController::class, 'payAngsuran'])->name('pay.angsuran');
    Route::post('/notification', [App\Http\Controllers\MidtransController::class, 'handleNotification'])->name('notification');
    Route::get('/success', [App\Http\Controllers\MidtransController::class, 'success'])->name('success');
    Route::get('/pending', [App\Http\Controllers\MidtransController::class, 'pending'])->name('pending');
    Route::get('/error', [App\Http\Controllers\MidtransController::class, 'error'])->name('error');
});

Route::post('/test-route', function() {
    return 'OK';
});