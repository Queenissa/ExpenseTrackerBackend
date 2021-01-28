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
    public function getAllUsers()
    {
        $allUsers = User::where('is_admin', 0)->orWhere('is_admin', null)->get();
        return $allUsers;
    }




    //method for getting/viewing expenses history of specific user
    public function getUserExpensesHistory($id)
    {

        $data = Expense::select(
            DB::raw('expense_category as category'),
            DB::raw('sum(expense_amount) as amount'))
            ->where('user_id', $id)
           ->groupBy('category')
           ->get();

        //    dd($data);
      
        $array[] = ['Category', 'Amount'];

        foreach($data as $key => $value)
        {
          $array[++$key] = [$value->category, $value->amount];
        }

        return json_encode($array);
        
            
        
    }




    //method for deleting a speicific user
    public function deleteUser($id)
    {
        $response = [];

        try{
            DB::table('expenses')->where('user_id', $id )->delete();
            DB::table('users')->where('id', $id )->delete();
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
