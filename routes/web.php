<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoicesDetalisController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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



Auth::routes();
//Auth::routes(['register' => false]);

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::get('/', function () {
        if (Auth::check()) {
            // المستخدم مسجل الدخول، قم بتوجيهه إلى الصفحة الرئيسية
            return redirect()->route('home');
        } else {
            // المستخدم غير مسجل الدخول، قم بتوجيهه إلى صفحة تسجيل الدخول
            return view('auth.login');
        }
    });



    Route::group(['middleware' => 'auth'], function () {

        Route::get('/home', 'HomeController@index')->name('home');

        Route::resource('invoices', 'InvoicesController');

        Route::resource('sections', 'SectionsController');

        Route::resource('products', 'ProductController');

        Route::resource('InvoiceAttachments', 'InvoiceAttachmentsController');

        Route::get('/section/{id}', 'InvoicesController@getproducts');


        Route::get('/InvoicesDetails/{id}/{notification_id}', [InvoicesDetalisController::class, 'edit'])->name('InvoicesDetails');


        Route::get('View_file/{invoice_number}/{file_name}', 'InvoicesDetalisController@open_file');

        Route::get('download/{invoice_number}/{file_name}', 'InvoicesDetalisController@get_file');

        Route::post('delete_file', 'InvoicesDetalisController@destroy')->name('delete_file');

        Route::get('/edit_invoice/{id}', 'InvoicesController@edit')->name('edit_invoice');

        Route::get('/Status_show/{id}', 'InvoicesController@show')->name('Status_show');

        Route::post('/Status_Update/{id}', 'InvoicesController@Status_Update')->name('Status_Update');

        Route::resource('/archive', 'InvoiceArchiveController');

        Route::get('/Invoice_Paid', 'InvoicesController@Invoice_Paid')->name('Invoice_Paid');

        Route::get('/Invoice_unPaid', 'InvoicesController@Invoice_unPaid')->name('Invoice_unPaid');

        Route::get('/Invoice_Partial', 'InvoicesController@Invoice_Partial')->name('Invoice_Partial');

        Route::get('/Print_invoice/{id}', 'InvoicesController@Print_invoice');

        Route::get('sendEmail/{id}', 'InvoicesController@sendEmail')->name('sendEmail');
        Route::get('sendEmailView/{id}', 'InvoicesController@sendEmailView');

        Route::get('export_invoices', 'InvoicesController@export');

        Route::get('generate-pdf/{id}', 'InvoicesController@pdf');


        Route::resource('roles', 'RoleController');
        Route::resource('users', 'UserController');

        Route::get('invoices_report', 'Invoices_ReportController@index')->name('invoices_report');

        Route::post('Search_invoices', 'Invoices_ReportController@Search_invoices')->name('Search_invoices');

        Route::get('customers_report', 'Customers_ReportController@index')->name("customers_report");

        Route::post('Search_customers', 'Customers_ReportController@Search_customers')->name('Search_customers');

        Route::get('MarkAsRead_all', 'InvoicesController@MarkAsRead_all')->name('MarkAsRead_all');
    });
});

Route::get('/{page}', 'AdminController@index');

// توجيه إلى الصفحة الرئيسية إذا كان المسار غير موجود
Route::fallback(function () {
    if (Auth::check()) {
        // المستخدم مسجل الدخول، قم بتوجيهه إلى الصفحة الرئيسية
        return redirect()->route('home');
    } else {
        // المستخدم غير مسجل الدخول، قم بتوجيهه إلى صفحة تسجيل الدخول
        return view('auth.login');
    }
});
