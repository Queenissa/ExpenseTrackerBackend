<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseGraphController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// this gets all users
Route::get('/', [UserController::class, 'index']);
// this return requested user
Route::get('/user',[ UserController::class, 'user'])->middleware('auth:api');
// This add user
Route::post('/register',[ UserController::class, 'register']);
// This gets specific user's detail
Route::get('/user/{id}',[ UserController::class, 'getUserById']);
// This for updating user
Route::put('/updateUser/{id}',[ UserController::class, 'updateUser']);
//This for deleting user
Route::delete('/deleteUser/{id}',[ UserController::class, 'deleteUser']);

Route::middleware('auth:api')->group(function (){
    Route::put('/users/updateprofile', [UserController::class, 'updateUserProfile']);
    Route::get('/userexpenses', [ExpenseController::class, 'getExpenseOfUser']);   
    Route::get('/userexpenses/{id}', [ExpenseController::class, 'getExpenseOfUserById']);
    Route::get('/userexpensesbycategory', [ExpenseController::class, 'getExpenseOfUserByCategory']);
    Route::put('/expenses/update/{id}', [ExpenseController::class, 'updateUserExpenses']);
    Route::delete('/expenses/delete/{id}', [ExpenseController::class, 'deleteUserExpenses']);

    Route::get('/expenses/search/{amount}', [ExpenseController::class, 'searchExpense']);
    Route::get('/allexpenses', [ExpenseController::class, 'expensesListOrderedByDate']);
    Route::get('/clothing', [ExpenseController::class, 'clothingCategory']);
    Route::get('/food', [ExpenseController::class, 'foodCategory']);
    Route::get('/savings', [ExpenseController::class, 'savingsCategory']);
    Route::get('/transportation', [ExpenseController::class, 'transportionCategory']);
    Route::get('/electricitybill', [ExpenseController::class, 'electricityBillCategory']);
    Route::get('/phonebill', [ExpenseController::class, 'phoneBillCategory']);
    Route::get('/waterbill', [ExpenseController::class, 'waterBillCategory']);
    Route::get('/personalcare', [ExpenseController::class, 'personalCareCategory']);
    
    Route::get('/chart/yesterday', [ExpenseGraphController::class, 'yesterdayChart']);
    Route::get('/chart/weekly', [ExpenseGraphController::class, 'weeklyChart']);
    Route::get('/chart/monthly', [ExpenseGraphController::class, 'monthlyChart']);
    Route::get('/chart/yearly', [ExpenseGraphController::class, 'yearlyChart']);
});


Route::post('/expenses/add',[ExpenseController::class,'addValidatedUserExpenses']);


