<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class AdminController extends Controller
{
    //Display All Users
    public function allUsers()
    {
        $admin = Auth::user();
        if ($user)
        {
            $allUsers = User::all();
            return $allUsers;
        }
    }



    //method for getting/viewing expenses history of specific user
    public function getUserExpensesHistory(Request $request, $id)
    {

        $response = [];

        try{
            $userExpensesHistory = Expense::Where('user_id', $id)
            ->groupBy('expense_category')  
            ->select([DB::raw("SUM(expense_amount) as total_amount, expense_category")])
            ->pluck('total_amount', 'expense_category');
            $response["code"] = 200;
            $response["userExpensesHistory"] = $userExpensesHistory;
          
          
        }
        catch(\Expense $e){
            $response["error"] = "Record not found.";
            $response["code"] = 400;
        }
        return response($response, $response["code"]);
    }



    //method for deleting a speicific user
    public function deleteUser($id)
    {
        $response = [];

        try{
            $user = DB::table('expenses')->where('id', $id )->delete();
            $response["code"] = 200;
            $response["message"] = "Record has been deleted";
        }
        catch(\Exception $e)
        {
            $response["error"] = "Expense not found.";
            $response["code"] = 400;
        }
        
        return response($response, $response['code']);
     
    
    }



    
}
