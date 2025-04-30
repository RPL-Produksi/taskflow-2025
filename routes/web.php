<?php

use App\Http\Controllers\Admin\ManageTaskerController;
use App\Http\Controllers\Admin\ManageWorkerController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Tasker\DashboardTaskerController;
use App\Http\Controllers\Tasker\ManageAssignSiswa;
use App\Http\Controllers\Tasker\ManageSoalController;
use App\Http\Controllers\Tasker\ManageSubtaskController;
use App\Http\Controllers\Tasker\ManageSubtaskWorkerController;
use App\Http\Controllers\Tasker\ManageTaskController;
use App\Http\Controllers\Tasker\ManageTaskWorkerController;
use App\Http\Controllers\Tasker\ManageTesController;
use App\Http\Controllers\Worker\DashboardWorkerController;
use App\Http\Controllers\Worker\PrivateSubTaskController;
use App\Http\Controllers\Worker\PrivateTaskController;
use App\Http\Controllers\Worker\SubtaskController;
use App\Http\Controllers\Worker\TaskController;
use App\Http\Controllers\Worker\TesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('index');

Route::group(['prefix' => 'auth', 'controller' => AuthController::class], function() {
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
    Route::get('/register', 'register')->name('register');
    Route::get('/profile', 'profile')->name('profile');
    Route::post('/store', 'store')->name('store.register');
    Route::post('/update/{id}', 'update')->name('update.profile');
});

Route::group(['prefix' => 'admin', 'middleware' => ['can:admin']], function() {
    Route::group(['prefix' => 'manage-tasker', 'controller' => ManageTaskerController::class], function() {
        Route::get('/', 'index')->name('manage.tasker');
        Route::get('/dashboard', 'dashboard')->name('dashboard.admin');
        Route::get('/add', 'add')->name('add.tasker');
        Route::get('/edit/{id}', 'edit')->name('edit.tasker');
        Route::post('/store', 'store')->name('store.tasker');
        Route::post('/update/{id}', 'update')->name('update.tasker');
        Route::post('/delete/{id}', 'delete')->name('delete.tasker');
    });
    Route::group(['prefix' => 'manage-worker', 'controller' => ManageWorkerController::class], function() {
        Route::get('/', 'index')->name('manage.worker');
        Route::get('/add', 'add')->name('add.worker');
        Route::get('/edit/{id}', 'edit')->name('edit.worker');
        Route::post('/store', 'store')->name('store.worker');
        Route::post('/update/{id}', 'update')->name('update.worker');
        Route::post('/delete/{id}', 'delete')->name('delete.worker');
    });
});

Route::get('/soal/format/download', function () {
    return response()->download(storage_path('app/public/format soal.txt'));
})->name('download.format.soal');
Route::get('/nilai/export', [ManageTesController::class, 'export'])->name('nilai.export');
Route::group(['prefix' => 'tasker', 'middleware' => ['can:tasker']], function() {
    Route::group(['prefix' => 'manage-task', 'controller' => ManageTaskController::class], function() {
        Route::get('/', 'index')->name('manage.task');
        Route::get('/task-progress/{id}', 'getTaskProgress')->name('task.progress');
        Route::get('/add', 'add')->name('add.task');
        Route::get('/edit/{id}', 'edit')->name('edit.task');
        Route::post('/store', 'store')->name('store.task');
        Route::post('/delete/{id}', 'delete')->name('delete.task');
        Route::post('/update/{id}', 'update')->name('update.task');
    });
    Route::group(['prefix' => 'manage-subtask', 'controller' => ManageSubtaskController::class], function() {
        Route::get('/{task}', 'index')->name('manage.subtask');
        Route::post('/store', 'store')->name('store.subtask');
        Route::post('/delete/{id}', 'delete')->name('delete.subtask');
    });
    Route::group(['prefix' => 'manage-task-worker', 'controller' => ManageTaskWorkerController::class], function() {
        Route::get('/{task}', 'index')->name('manage.taskworker');
        Route::post('/store', 'store')->name('store.taskworker');
        Route::post('/delete/{id}', 'delete')->name('delete.taskworker');
    });
    Route::group(['prefix' => 'manage-subtaks-worker', 'controller' => ManageSubtaskWorkerController::class], function() {
        Route::get('/{task}/{worker}', 'index')->name('manage.subtaskworker');
        Route::post('/acc/{id}', 'acc')->name('acc');
        Route::post('/cancel/{id}', 'cancel')->name('cancel');
    });
    Route::group(['prefix' => 'manage-tes', 'controller' => ManageTesController::class], function () {
        Route::get('/', 'index')->name('manage.tes');
        Route::get('/add', 'add')->name('add.tes');
        Route::get('/edit/{id}', 'edit')->name('edit.tes');
        Route::get('/nilai/{tes}', 'nilai')->name('nilai.siswa');
        Route::post('/store', 'store')->name('store.tes');
        Route::post('/update/{id}', 'update')->name('update.tes');
        Route::post('/delete/{id}', 'delete')->name('delete.tes');
    });
    Route::group(['prefix' => 'manage-soal', 'controller' => ManageSoalController::class], function () {
        Route::get('/{tes}', 'index')->name('manage.soal');
        Route::get('/add/{tes}', 'add')->name('add.soal');
        Route::get('/edit/{id}', 'edit')->name('edit.soal');
        Route::post('/store', 'store')->name('store.soal');
        Route::post('/import', 'import')->name('import.soal');
        Route::post('/update/{id}', 'update')->name('update.soal');
        Route::post('/delete/{id}', 'delete')->name('delete.soal');
    });
    Route::group(['prefix' => 'manage-tes-siswa', 'controller' => ManageAssignSiswa::class], function () {
        Route::get('/{tes}', 'index')->name('manage.assign.siswa');
        Route::post('/store', 'store')->name('store.assign.siswa');
        Route::post('/delete/{id}', 'delete')->name('delete.tesSiswa');
    });
    Route::get('/', [DashboardTaskerController::class, 'index'])->name('dashboard.tasker');
});

Route::group(['prefix' => 'worker', 'middleware' => ['can:worker']], function() {
    Route::get('/', [DashboardWorkerController::class, 'index'])->name('dashboard.worker');
    Route::group(['prefix' => 'task', 'controller' => TaskController::class], function() {
        Route::get('/', 'index')->name('task');
    });
    Route::group(['prefix' => 'subtask', 'controller' => SubtaskController::class], function() {
        Route::get('/{task}', 'index')->name('subtask');
        Route::post('/progress', 'progress')->name('progress');
        Route::post('/review/{id}', 'review')->name('review');
        Route::post('/ulang/{id}', 'ulang')->name('ulang');
    });
    Route::group(['prefix' => 'private-task', 'controller' => PrivateTaskController::class], function() {
        Route::get('/', 'index')->name('private.task');
        Route::get('/add', 'add')->name('add.private.task');
        Route::get('/edit/{id}', 'edit')->name('edit.private.task');
        Route::post('/store', 'store')->name('store.private.task');
        Route::post('/update/{id}', 'update')->name('update.private.task');
        Route::post('/delete/{id}', 'delete')->name('delete.private.task');
    });
    Route::group(['prefix' => 'private-subtask', 'controller' => PrivateSubTaskController::class], function() {
        Route::get('/{task}', 'index')->name('private.subtask');
        Route::get('/start/{task}', 'start')->name('start.private.subtask');
        Route::post('/store', 'store')->name('store.private.subtask');
        Route::post('/delete/{id}', 'delete')->name('delete.private.subtask');
        Route::post('/done/{id}', 'done')->name('done.private.subtask');
    });
    Route::group(['prefix' => 'tes', 'controller' => TesController::class], function() {
        Route::get('/', 'index')->name('tes');
        Route::get('/start/{tes}', 'start')->name('start.tes');
        Route::post('/submit/{tes}', 'submit')->name('submit.tes');
        Route::post('/save-jawaban', 'saveJawaban')->name('save.jawaban');
    });
});
