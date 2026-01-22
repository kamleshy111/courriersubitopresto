<?php

use App\Http\Controllers\Admin\DispatchController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\StatusController;
use App\Http\Controllers\SettingController;
use App\Models\Waybill;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestEmailController;
use App\Http\Controllers\DownloadController;

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

// ============ Debug============
/*

Route::get('/test-env', function () {
    return [
        'app_name' => env('APP_NAME'),
        'email' => env('OWNER_EMAIL_TO_NOTIFICATION', 'Default Value'),
    ];
});

// route test
Route::get('/test', function () {
    return 'This is a test route';
});
Route::get('/email/debug', [\App\Http\Controllers\TestEmailController::class, 'testEmailVars']);
*/

// ============== Debug Ends ================


Route::get('/app/download', [\App\Http\Controllers\DownloadController::class, 'index']);


Route::get('/', function () {
    return redirect('/admin');
});

Auth::routes();

Route::name('admin.')->prefix('admin')->middleware(['auth'])->group(function() {
    
    

    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'updateInfo']);

    // Route::get('/route-chauffeur', [\App\Http\Controllers\Admin\RouteChauffeurController::class, 'index'])->name('route-chauffeur.index');
    // Route::get('/driver/single-waybill/{id}', [\App\Http\Controllers\Admin\DriverController::class, 'singleUpload'])->name('single.upload');
    Route::get('/drivers/single-waybill/{id}', [\App\Http\Controllers\Admin\DriverController::class, 'singleUpload'])->name('single.upload');
    Route::get('/drivers/single-waybill-image-view/{id}', [\App\Http\Controllers\Admin\DriverController::class, 'singleImageView'])->name('single.image.view');
    // Route::get('/driver-waybill/{id}', [\App\Http\Controllers\Admin\DriverController::class, 'driverWaybill']); //old
    Route::get('/driver-waybill/{id}', [\App\Http\Controllers\Admin\DriverController::class, 'clientDriverWaybill']);
    Route::get('/driver-waybill-admin/{id}', [\App\Http\Controllers\Admin\DriverController::class, 'adminDriverWaybill']);
    Route::get('/driver-waybill-list', [\App\Http\Controllers\Admin\DriverController::class, 'driverWaybillList']);
    Route::get('/drivers-list', [\App\Http\Controllers\Admin\DriverController::class, 'driversList']);
    Route::get('/drivers-progress', [\App\Http\Controllers\Admin\DriverProgressController::class, 'index'])->name('driver_progress.index');
    Route::post('/admin/update-sticky-note', [\App\Http\Controllers\Admin\DriverProgressController::class, 'updateStickyNote']);
    Route::get('/list-drivers', [\App\Http\Controllers\Admin\DriverProgressController::class, 'drivers']);
    Route::get('/waybills/today', [\App\Http\Controllers\Admin\DriverProgressController::class, 'getTodayWaybills']);
    Route::get('/api/clients', [\App\Http\Controllers\Admin\DriverProgressController::class, 'clients_api']);


    Route::get('clients/autocomplete', [\App\Http\Controllers\Admin\ClientsController::class, 'autocomplete'])->name('clients.autocomplete');
    Route::get('waybills/clients/{client}', [\App\Http\Controllers\Admin\WaybillsController::class, 'client_bulk'])->name('waybills.client_bulk');
    Route::get('waybills/form_helper/{counter}', [\App\Http\Controllers\Admin\WaybillsController::class, 'formHelper'])->name('waybills.form_helper')->whereNumber('counter');
    Route::get('waybills/last_created', [\App\Http\Controllers\Admin\WaybillsController::class, 'show_last_created'])->name('waybills.last_created');
    Route::post('waybills/upload-signature', [\App\Http\Controllers\Admin\WaybillsController::class, 'uploadSignature'])->name('waybills.uploadSignature');//new
    Route::post('waybills/{id}/upload-pickup-image', [\App\Http\Controllers\Admin\WaybillsController::class, 'uploadPickupImage'])->name('waybills.uploadPickupImage');
    Route::post('waybills/{id}/upload-drop-image', [\App\Http\Controllers\Admin\WaybillsController::class, 'uploadDropImage'])->name('waybills.uploadDropImage');
    Route::post('waybills/{id}/delivered', [\App\Http\Controllers\Admin\WaybillsController::class, 'markDelivered'])->name('waybills.markDelivered');



    Route::resource('roles', \App\Http\Controllers\Admin\RolesController::class);
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionsController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UsersController::class);


    Route::post('waybills/approve/{id}', [\App\Http\Controllers\Admin\WaybillsController::class, 'approve']);
    Route::post('waybills/reject/{id}', [\App\Http\Controllers\Admin\WaybillsController::class, 'reject']);
    Route::post('waybills/delete/{id}', [\App\Http\Controllers\Admin\WaybillsController::class, 'deleteRejectedSubmission']);
    Route::post('waybills/delete-by-admin/{id}', [\App\Http\Controllers\Admin\WaybillsController::class, 'deleteSubmissionByAdmin']);
    Route::resource('waybills', \App\Http\Controllers\Admin\WaybillsController::class);
    Route::post('/admin/update-approval-status', [\App\Http\Controllers\Admin\WaybillsController::class, 'updateApprovalStatus']);

    Route::get('waybills-client-index', [\App\Http\Controllers\Client\WaybillController::class, 'clientDataTable']);
    Route::get('waybills-admin-index', [\App\Http\Controllers\Client\WaybillController::class, 'adminDataTable']);
    Route::get('admin-submission-archive-index', [\App\Http\Controllers\Client\WaybillController::class, 'adminArchivedSubmissionDataTable']);
    Route::get('client-submission-archive-index', [\App\Http\Controllers\Client\WaybillController::class, 'clientArchivedSubmissionDataTable']);



    Route::get('clients-client-index', [\App\Http\Controllers\DataTables\Client\ClientController::class, 'index']);
    Route::get('clients-admin-index', [\App\Http\Controllers\DataTables\Admin\ClientController::class, 'index']);

    Route::get('clients/{user_id}/user-clients', [\App\Http\Controllers\Admin\ClientsController::class, 'userClients']);
    Route::get('clients-user-clients-index/{user_id}', [\App\Http\Controllers\DataTables\Admin\ClientController::class, 'userClientsDataTable']);

    Route::DELETE('clients/delete-user/{user_id}', [\App\Http\Controllers\Admin\ClientsController::class, 'deleteUser']);
    Route::DELETE('clients/delete-client/{client_id}', [\App\Http\Controllers\Admin\ClientsController::class, 'deleteClient']);
    Route::resource('clients', \App\Http\Controllers\Admin\ClientsController::class);
    Route::post('notes', [\App\Http\Controllers\Admin\NoteController::class, 'store'])->name('notes.store');

    Route::get('drivers-index', [DriverController::class, 'indexDataTable']);
    Route::resource('drivers', DriverController::class);

    Route::get('dispatches-index', [DispatchController::class, 'indexDataTable']);
    Route::resource('dispatches', DispatchController::class);

    Route::get('statuses-index', [StatusController::class, 'indexDataTable']);
    Route::resource('statuses', StatusController::class);

    Route::resource('settings', SettingController::class);


});
