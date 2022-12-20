<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;



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

Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/get-company', [App\Http\Controllers\Auth\LoginController::class, 'getCompany']);
Route::get('/get-branch', [App\Http\Controllers\Auth\LoginController::class, 'getBranch']);
Route::get('/get-fyear', [App\Http\Controllers\Auth\LoginController::class, 'getFyear']);
Route::get('/exist-user', [App\Http\Controllers\Auth\LoginController::class, 'existUser']);
Route::get('/exist-pass', [App\Http\Controllers\Auth\LoginController::class, 'existPass']);
Route::post('/checkPeriodClosing', [App\Http\Controllers\CommonController::class, 'checkPeriodClosing']);
Route::post('/getDocNoByEvent', [App\Http\Controllers\CommonController::class, 'getDocNoByEvent']);
Route::post('/check_approval_level', [App\Http\Controllers\CommonController::class, 'check_approval_level']);
Route::post('/GetConvFector', [App\Http\Controllers\CommonController::class, 'GetConvFector']);
Route::post('/getItemCost', [App\Http\Controllers\CommonController::class, 'getItemCost']);
Route::post('/general_leadger_master', [App\Http\Controllers\CommonController::class, 'general_leadger_master']);

Route::group(['middleware'=>'auth'],function (){

//master route for index and show
Route::get('master/{form_id}/{crud_action}/{id?}', function($form_id,$crud_action,$id=null){

    $paramenters = [];
    if(!empty($id)){
        $paramenters['id']=$id;
    }
	
    $controller = App::make("\App\Http\Controllers\Masters\\"."MstFrm".$form_id."Controller");
    return $controller->callAction($crud_action, $paramenters );

})->name("master");


//
//Route::POST('/masters/getcountries', [App\Http\Controllers\Masters\MastersController::class, 'getcountries'])->name('masters.getcountries');
Route::POST('master/{form_id}/{crud_action}', function($form_id,$crud_action,Request $request){

    $parameters = [];
    if(!empty($request)){
        $parameters['request']=$request;
    }
   
    $controller = App::make("\App\Http\Controllers\Masters\\"."MstFrm".$form_id."Controller");
    return $controller->callAction($crud_action,$parameters);

})->name("mastergetlist");

//update master form
Route::PUT('master/{form_id}/{crud_action}', function($form_id,$crud_action,Request $request){

    $parameters = [];

    if(!empty($request)){
        $parameters['request']=$request;
    }
   
    $controller = App::make("\App\Http\Controllers\Masters\\"."MstFrm".$form_id."Controller");
    return $controller->callAction($crud_action,$parameters);

})->name("mastermodify");

//report route for index and show
Route::get('report/{form_id}/{crud_action}/{id?}', function($form_id,$crud_action,$id=null){

    $paramenters = [];
    if(!empty($id)){
        $paramenters['id']=$id;
    }
    $controller = App::make("\App\Http\Controllers\Reports\\"."RptFrm".$form_id."Controller");
    return $controller->callAction($crud_action, $paramenters );

})->name("report");

Route::POST('report/{form_id}/{crud_action}', function($form_id,$crud_action,Request $request){

    $parameters = [];
    if(!empty($request)){
        $parameters['request']=$request;
    }
   
    $controller = App::make("\App\Http\Controllers\Reports\\"."RptFrm".$form_id."Controller");
    return $controller->callAction($crud_action,$parameters);

})->name("reportgetlist");

//update master form
Route::PUT('report/{form_id}/{crud_action}', function($form_id,$crud_action,Request $request){

    $parameters = [];

    if(!empty($request)){
        $parameters['request']=$request;
    }
   
    $controller = App::make("\App\Http\Controllers\Reports\\"."RptFrm".$form_id."Controller");
    return $controller->callAction($crud_action,$parameters);

})->name("reportmodify");

//transaction route for index and show
Route::get('transaction/{form_id}/{crud_action}/{id?}', function($form_id,$crud_action,$id=null){

    $paramenters = [];
    if(!empty($id)){
        $paramenters['id']=$id;
    }
	
    $controller = App::make("\App\Http\Controllers\Transactions\\"."TrnFrm".$form_id."Controller");
    return $controller->callAction($crud_action, $paramenters );

})->name("transaction");


//
Route::POST('transaction/{form_id}/{crud_action}', function($form_id,$crud_action,Request $request){

    $parameters = [];
    if(!empty($request)){
        $parameters['request']=$request;
    }
   
    $controller = App::make("\App\Http\Controllers\Transactions\\"."TrnFrm".$form_id."Controller");
    return $controller->callAction($crud_action,$parameters);

})->name("transactiongetlist");

//update transaction form
Route::PUT('transaction/{form_id}/{crud_action}', function($form_id,$crud_action,Request $request){

    $parameters = [];

    if(!empty($request)){
        $parameters['request']=$request;
    }
   
    $controller = App::make("\App\Http\Controllers\Transactions\\"."TrnFrm".$form_id."Controller");
    return $controller->callAction($crud_action,$parameters);

})->name("transactionmodify");



Route::fallback(function () {
    echo('Sorry, URL not found.');
});

}); //group