<?php

use Illuminate\Support\Facades\Route;

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

/* redirects */
Route::get('/', function () { return redirect('transactions'); });
Route::get('/home', function () { return redirect('transactions'); });

/* transactions routes */
Route::get('/transactions/getupdate', 'TransactionsController@getUpdate')->middleware('auth.custom')->name('transactions.getupdate');
Route::get('/transactions/{id}/asyncdestroy', 'TransactionsController@asyncDestroy')->middleware('auth.custom')->name('transactions.asyncdestroy');
Route::resource('transactions', 'TransactionsController')->middleware('auth');
