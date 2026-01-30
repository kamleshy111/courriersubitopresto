<?php

use App\Http\Controllers\Admin\DispatchController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\StatusController;
use App\Http\Controllers\SettingController;
use App\Models\Waybill;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestEmailController;
use App\Http\Controllers\DownloadController;
use Illuminate\Support\Facades\Storage;
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

// ============== Debug Ends ================


Route::get('/app/download', [\App\Http\Controllers\DownloadController::class, 'index']);
// store/update chauffer waybill data
Route::post('/update-cell', [\App\Http\Controllers\Admin\DriverController::class, 'driverWaybillUpdate'])->name('driver.waybill.update');

Route::get('/admin/my-profile', function () {
    return redirect()->route(
        'admin.clients.edit',
        auth()->user()->client_id
    );
})->name('admin.client.profile')->middleware('auth');

// update user profile for clients

/*Route::get('/admin/client-password-update', function () {
    return redirect()->route(
        'admin.users.edit',
        auth()->id()
    );
})->name('admin.user.profile')->middleware('auth');*/


Route::get('/admin/my-account', function () {
    return redirect()->route(
        'admin.users.edit',
        auth()->id()
    );
})->name('admin.user.profile')->middleware('auth');



Route::get('/', function () {
    return redirect('/admin');
});

Auth::routes();

Route::name('admin.')->prefix('admin')->middleware(['auth'])->group(function() {



    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'updateInfo']);
    Route::get('/account', [\App\Http\Controllers\Admin\ProfileController::class, 'account'])->name('account.index');

    // Route::get('/route-chauffeur', [\App\Http\Controllers\Admin\RouteChauffeurController::class, 'index'])->name('route-chauffeur.index');
    // Route::get('/driver/single-waybill/{id}', [\App\Http\Controllers\Admin\DriverController::class, 'singleUpload'])->name('single.upload');
    Route::get('/drivers/single-waybill/{id}', [\App\Http\Controllers\Admin\DriverController::class, 'singleUpload'])->name('single.upload');
    Route::get('/drivers/single-waybill-image-view/{id}', [\App\Http\Controllers\Admin\DriverController::class, 'singleImageView'])->name('single.image.view');
    // Route::get('/driver-waybill/{id}', [\App\Http\Controllers\Admin\DriverController::class, 'driverWaybill']); //old

    // dirver waybills individuals

    Route::get('/driver-waybill/{id}', [\App\Http\Controllers\Admin\DriverController::class, 'clientDriverWaybill']);
    Route::get('/driver-waybill/{id}/in-progress', [\App\Http\Controllers\Admin\DriverController::class, 'clientDriverWaybillOnProgress']);
    Route::get('/driver-waybill/{id}/pickedup', [\App\Http\Controllers\Admin\DriverController::class, 'clientDriverWaybillPickedUp']);
    Route::get('/driver-waybill/{id}/delivered', [\App\Http\Controllers\Admin\DriverController::class, 'clientDriverWaybillDelivered']);

    //old summary table
    // Route::get('/driver-summary-table/{id}', [\App\Http\Controllers\Admin\DriverController::class, 'driverSummaryTable']);
    Route::get('/drivers-progress', [\App\Http\Controllers\Admin\DriverProgressController::class, 'index'])->name('driver_progress.index');
    Route::post('/update-driver-id', [\App\Http\Controllers\Admin\DriverProgressController::class, 'assignDriver']);
    Route::get('/driversList', [\App\Http\Controllers\Admin\DriverProgressController::class, 'driversList']);
    // Route::post('/admin/update-sticky-note', [\App\Http\Controllers\Admin\DriverProgressController::class, 'updateStickyNote']);
    Route::post('/update-sticky-note', [\App\Http\Controllers\Admin\DriverProgressController::class, 'updateStickyNote']);
    Route::post('/remove-sticky-note-position', [\App\Http\Controllers\Admin\DriverProgressController::class, 'removePosition']);
    Route::post('/update-cheque-absent',[\App\Http\Controllers\Admin\DriverProgressController::class, 'updatChequeStatus']);


    Route::post('/driver-summary-table/email', [\App\Http\Controllers\Admin\DriverController::class, 'emailReport']);
    Route::get('/driver-summary-table/{id}', [\App\Http\Controllers\Admin\DriverController::class, 'driverSummaryTable']);
    Route::get('/driver/{id}/summaryTable', [\App\Http\Controllers\Admin\DriverController::class, 'getDriverWaybills']);
    Route::get('/driver-waybill-admin/{id}', [\App\Http\Controllers\Admin\DriverController::class, 'adminDriverWaybill']);
    Route::get('/driver-waybill-list', [\App\Http\Controllers\Admin\DriverController::class, 'driverWaybillList']);
    Route::get('/drivers-list', [\App\Http\Controllers\Admin\DriverController::class, 'driversList']);
    Route::get('/list-drivers', [\App\Http\Controllers\Admin\DriverProgressController::class, 'drivers']);
    Route::get('/waybills/today', [\App\Http\Controllers\Admin\DriverProgressController::class, 'getTodayWaybills']);
    Route::get('/api/clients', [\App\Http\Controllers\Admin\DriverProgressController::class, 'clients_api']);
    // order save in bottom box of dashboard
    Route::post('/waybills/update-order', [\App\Http\Controllers\Admin\DriverProgressController::class, 'updateOrder']);
    // order save in popup window
    Route::post('/waybills/update-popup-order', [\App\Http\Controllers\Admin\DriverProgressController::class, 'updatePopupOrder']);
    Route::get('/waybills/get-popup-order', [\App\Http\Controllers\Admin\DriverProgressController::class, 'getPopupPositions']);
    // check driver is assigned or not for mira
    Route::get('/waybills/{id}/mira-driver-status', [\App\Http\Controllers\Admin\DriverProgressController::class, 'checkMiraDriverStatus']);


    Route::get('clients/autocomplete', [\App\Http\Controllers\Admin\ClientsController::class, 'autocomplete'])->name('clients.autocomplete');
    Route::get('waybills/clients/{client}', [\App\Http\Controllers\Admin\WaybillsController::class, 'client_bulk'])->name('waybills.client_bulk');
    Route::get('waybills/form_helper/{counter}', [\App\Http\Controllers\Admin\WaybillsController::class, 'formHelper'])->name('waybills.form_helper')->whereNumber('counter');
    Route::get('waybills/last_created', [\App\Http\Controllers\Admin\WaybillsController::class, 'show_last_created'])->name('waybills.last_created');
    Route::post('waybills/upload-signature', [\App\Http\Controllers\Admin\WaybillsController::class, 'uploadSignature'])->name('waybills.uploadSignature');//new
    Route::post('waybills/{id}/upload-SignatureNote', [\App\Http\Controllers\Admin\WaybillsController::class, 'uploadSignatureNote'])->name('waybills.uploadSignatureNote');//new
    Route::post('waybills/{id}/upload-pickup-image', [\App\Http\Controllers\Admin\WaybillsController::class, 'uploadPickupImage'])->name('waybills.uploadPickupImage');
    // below is the new line
    Route::post('waybills/{id}/upload-pickup-image-updated', [\App\Http\Controllers\Admin\WaybillsController::class, 'uploadPickupImageUpdated'])->name('waybills.uploadPickupImageUpdated');
    Route::post('waybills/{id}/upload-drop-image', [\App\Http\Controllers\Admin\WaybillsController::class, 'uploadDropImage'])->name('waybills.uploadDropImage');
    // new route for drop image added below
    Route::post('waybills/{id}/upload-drop-image-updated', [\App\Http\Controllers\Admin\WaybillsController::class, 'uploadDropImageUpdated'])->name('waybills.uploadDropImageUpdated');
    Route::post('waybills/{id}/delivered', [\App\Http\Controllers\Admin\WaybillsController::class, 'markDelivered'])->name('waybills.markDelivered');
    Route::get('waybill/{id}', [\App\Http\Controllers\Admin\WaybillsController::class, 'waybillPageView']);
    // new ribbon update in admin table
    Route::post('/waybills/mark-as-viewed/{id}', [\App\Http\Controllers\Admin\WaybillsController::class, 'markAsViewed']);


    // admin waybills table

    Route::get('/driver-waybill/admin/in-progress/{id}', [\App\Http\Controllers\Admin\DriverController::class, 'adminDriverWaybillOnProgress']);
    Route::get('/driver-waybill/admin/pickedup/{id}', [\App\Http\Controllers\Admin\DriverController::class, 'adminDriverWaybillPickedUp']);
    Route::get('/driver-waybill/admin/delivered/{id}', [\App\Http\Controllers\Admin\DriverController::class, 'adminDriverWaybillDelivered']);

    // client delivery status
    Route::get('/client/in-progress', [\App\Http\Controllers\Client\WaybillController::class, 'clientDeliveryInprogress']);
    Route::get('/client/pickedup', [\App\Http\Controllers\Client\WaybillController::class, 'clientDeliveryPickedup']);
    Route::get('/client/delivered', [\App\Http\Controllers\Client\WaybillController::class, 'clientDeliveryCompleted']);
    // new update for date filter in delivery
    Route::get('/client/waybills/by-date', [\App\Http\Controllers\Client\WaybillController::class, 'clientWaybillsByDate']);
    // new for name search filter
    Route::get('/client/waybills-by-name', [\App\Http\Controllers\Client\WaybillController::class, 'clientWaybillsByName']);
    // search by dynamic waybill id
    Route::post('/client/waybills/waybill-by-id', [\App\Http\Controllers\Client\WaybillController::class, 'clientByWaybillID']);
    // client name search
    Route::get('/clients/search', [\App\Http\Controllers\Client\WaybillController::class, 'clientNameSearch']);

    // admin search by waybill id
    Route::post('/waybills/waybill-by-id', [\App\Http\Controllers\Admin\WaybillsController::class, 'adminByWaybillID'])->name('waybills.search-by-id');
    // admin summary table with date filter
    // summary table
    Route::get('/delivery/summary-table', [\App\Http\Controllers\Admin\WaybillsController::class, 'adminDeliveryCompleted']);
    Route::get('/summary-table/by-date', [\App\Http\Controllers\Admin\WaybillsController::class, 'adminWaybillsByDate']);


    Route::resource('roles', \App\Http\Controllers\Admin\RolesController::class);
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionsController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UsersController::class);
    // pass update mail

    Route::post('/users/request-password-update', [App\Http\Controllers\Admin\UsersController::class, 'requestPasswordUpdate'])->name('users.requestPasswordUpdate');


    Route::post('waybills/approve/{id}', [\App\Http\Controllers\Admin\WaybillsController::class, 'approve']);
    Route::post('waybills/reject/{id}', [\App\Http\Controllers\Admin\WaybillsController::class, 'reject']);
    Route::post('waybills/delete/{id}', [\App\Http\Controllers\Admin\WaybillsController::class, 'deleteRejectedSubmission']);
    Route::post('waybills/delete-by-admin/{id}', [\App\Http\Controllers\Admin\WaybillsController::class, 'deleteSubmissionByAdmin']);
    Route::resource('waybills', \App\Http\Controllers\Admin\WaybillsController::class);
    // Route::post('/admin/update-approval-status', [\App\Http\Controllers\Admin\WaybillsController::class, 'updateApprovalStatus']);
    Route::post('/admin/update-approval-status', [\App\Http\Controllers\Admin\WaybillsController::class, 'updateApprovalStatus']);

    Route::get('waybills-client-index', [\App\Http\Controllers\Client\WaybillController::class, 'clientDataTable']);
    Route::get('waybills-admin-index', [\App\Http\Controllers\Client\WaybillController::class, 'adminDataTable']);
    Route::get('admin-submission-archive-index', [\App\Http\Controllers\Client\WaybillController::class, 'adminArchivedSubmissionDataTable']);
    Route::get('client-submission-archive-index', [\App\Http\Controllers\Client\WaybillController::class, 'clientArchivedSubmissionDataTable']);
    // new email for submission price discussion
    Route::post('/send-price-dispute-email', [\App\Http\Controllers\Client\WaybillController::class, 'disputeEmail']);

    // pdf upload for client profile
    Route::post('upload-client/pdf', [\App\Http\Controllers\Admin\ClientsController::class, 'store_pdf'])->name('clients.store_pdf');
    // Delete PDF for client
    Route::delete('clients/{client}/pdf',[\App\Http\Controllers\Admin\ClientsController::class, 'delete_pdf'])->name('clients.delete_pdf');


    Route::get('clients-client-index', [\App\Http\Controllers\DataTables\Client\ClientController::class, 'index']);
    Route::get('clients-admin-index', [\App\Http\Controllers\DataTables\Admin\ClientController::class, 'index']);
    Route::get('clients-admin-address-index', [\App\Http\Controllers\DataTables\Admin\ClientController::class, 'addressIndex']);
    Route::post('client-password-request', [\App\Http\Controllers\DataTables\Admin\ClientController::class,'emailClientPassUpdate'])->name('client.password.request');

    Route::get('clients/{user_id}/user-clients', [\App\Http\Controllers\Admin\ClientsController::class, 'userClients']);
    Route::get('clients-user-clients-index/{user_id}', [\App\Http\Controllers\DataTables\Admin\ClientController::class, 'userClientsDataTable']);

    Route::DELETE('clients/delete-user/{user_id}', [\App\Http\Controllers\Admin\ClientsController::class, 'deleteUser']);
    Route::DELETE('clients/delete-client/{client_id}', [\App\Http\Controllers\Admin\ClientsController::class, 'deleteClient']);
    Route::resource('clients', \App\Http\Controllers\Admin\ClientsController::class);
    Route::post('notes-save', [\App\Http\Controllers\Admin\NoteController::class, 'store'])->name('notes.store');
    // Route::post('safe-note-update', [\App\Http\Controllers\Admin\NoteController::class, 'store'])->name('notes.store');

    Route::get('drivers-index', [DriverController::class, 'indexDataTable']);
    Route::resource('drivers', DriverController::class);

    Route::get('dispatches-index', [DispatchController::class, 'indexDataTable']);
    Route::resource('dispatches', DispatchController::class);

    Route::get('statuses-index', [StatusController::class, 'indexDataTable']);
    Route::resource('statuses', StatusController::class);

    Route::resource('settings', SettingController::class);


});
