<?php

use Illuminate\Support\Facades\Route;

// Importação dos Controllers organizados por perfil
use App\Http\Controllers\Publico\HomeController as PublicoHomeController;
use App\Http\Controllers\Publico\PontoDeColetaController as PublicoPontoDeColetaController;
use App\Http\Controllers\Publico\OngController as PublicoOngController;

use App\Http\Controllers\Ong\DashboardController as OngDashboardController;
use App\Http\Controllers\Ong\PerfilController as OngPerfilController;
use App\Http\Controllers\Ong\PontoDeColetaController as OngPontoDeColetaController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OngController as AdminOngController;

/*
|--------------------------------------------------------------------------
| 1. Rotas Públicas (Visitante / Usuário Comum - Sem necessidade de Login)
|--------------------------------------------------------------------------
*/
Route::name('publico.')->group(function () {
    // Página inicial do sistema
    Route::get('/', [PublicoHomeController::class, 'index'])->name('home');

    // Consulta de pontos de coleta e detalhes
    Route::get('/pontos', [PublicoPontoDeColetaController::class, 'index'])->name('pontos.index');
    Route::get('/pontos/{ponto}', [PublicoPontoDeColetaController::class, 'show'])->name('pontos.show');

    // Consulta do perfil institucional da ONG
    Route::get('/ongs/{ong}', [PublicoOngController::class, 'show'])->name('ongs.show');
});

/*
|--------------------------------------------------------------------------
| 2. Rotas do Perfil ONG (Área autenticada da instituição)
|--------------------------------------------------------------------------
| Nota: Quando implementar o login, adicione a proteção de perfil com o middleware:
| Route::prefix('ong')->name('ong.')->middleware(['auth', 'perfil:ong'])->group(function () { ... });
*/
Route::prefix('ong')->name('ong.')->group(function () {
    // Dashboard da ONG
    Route::get('/dashboard', [OngDashboardController::class, 'index'])->name('dashboard');

    // Edição do perfil institucional da própria ONG
    Route::get('/perfil', [OngPerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil', [OngPerfilController::class, 'update'])->name('perfil.update');

    // Gerenciamento dos pontos de coleta da própria ONG (CRUD básico)
    Route::get('/pontos', [OngPontoDeColetaController::class, 'index'])->name('pontos.index');
    Route::get('/pontos/criar', [OngPontoDeColetaController::class, 'create'])->name('pontos.create');
    Route::post('/pontos', [OngPontoDeColetaController::class, 'store'])->name('pontos.store');
    Route::get('/pontos/{ponto}/editar', [OngPontoDeColetaController::class, 'edit'])->name('pontos.edit');
    Route::put('/pontos/{ponto}', [OngPontoDeColetaController::class, 'update'])->name('pontos.update');
    Route::delete('/pontos/{ponto}', [OngPontoDeColetaController::class, 'destroy'])->name('pontos.destroy');
});

/*
|--------------------------------------------------------------------------
| 3. Rotas do Perfil Administrador (Gestão geral do sistema)
|--------------------------------------------------------------------------
| Nota: Futuramente você pode adicionar o middleware auth e verificação de admin.
| Exemplo: Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(...)
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard do Administrador
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Gerenciamento de ONGs cadastradas
    Route::get('/ongs', [AdminOngController::class, 'index'])->name('ongs.index');
    Route::get('/ongs/criar', [AdminOngController::class, 'create'])->name('ongs.create');
    Route::post('/ongs', [AdminOngController::class, 'store'])->name('ongs.store');
    Route::get('/ongs/{ong}/editar', [AdminOngController::class, 'edit'])->name('ongs.edit');
    Route::put('/ongs/{ong}', [AdminOngController::class, 'update'])->name('ongs.update');
    Route::patch('/ongs/{ong}/status', [AdminOngController::class, 'toggleStatus'])->name('ongs.toggle-status');
});
