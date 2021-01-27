<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class ExpenseController extends Controller
{
   

      //add validated expenses
      public function addValidatedUserExpenses(Request $request)
      {
  
        //   $user = Auth::user();
          $this->validate($request,[
               'expense_amount'=>'required|numeric',
               'expense_date'=>'required|before_or_equal:'. now()->format('Y-m-d'),
               'note'=> 'required',
               'expense_category' => 'required'
           ]);
          
    
           $user = User::findOrFail($request->user_id);
           $expense =  $user->expenses()->create([
                'expense_amount' => $request->expense_amount,
                'note' => $request->note,
                'expense_date' =>$request->expense_date ,
                'expense_category' => $request->expense_category
            ]);
           
            if ($expense){
                  return response()->json([
                      'success' => true,
                      'data' => $expense  
                  ]);
            }else{
                  return response()->json([
                      'success' => false,
                      'message' => 'Expense not added'
                  ], 500);
          }
}
    


    //method for deleting expense of specific user
    public function deleteUserExpenses(Request $request, $id)
    {
        $user = Auth::user();
        $response = [];

        try{
            $userId = DB::table('expenses')->where('user_id', $user->id)->where('id', $id)->delete();
            $response["code"] = 200;
            $response["message"] = "Record has been deleted";
           
        }catch(\Exception $e){
            $response["error"] = "Expense not found.";
            $response["code"] = 400;
        }

        return response($response, $response["code"]);
       
    }




   //method for updating expense of specific user
    public function updateUserExpenses(Request $request, $id)
    {
        $user = Auth::user();
        $response = [];
        try{
            $update = DB::table('expenses')->where('user_id', $user->id)->where('id', $id)->update([
                'expense_amount'=> $request->expense_amount,
                'note' => $request->note,
                'expense_date'=>$request->expense_date,
                'expense_category'=>$request->expense_category
            ]);

            $response["message"] = "Record has been updated";
            $response["code"] = 200;
           
        }
        catch(\Exception $e){
            $response["error"] = "Record not found. $e";
            $response["code"] = 400;
        }
        return response($response, $response['code']);
    }




    //method for getting expenses of specific user by category
    public function getExpenseOfUserByCategory(Request $request)
    {
       $user = Auth::user();
       $response = [];
        try{
            $userExpense = DB::table('expenses')->where('user_id', $user->id)->get()->groupBy('expense_category');
            $response['userExpense'] = $userExpense;
            $response['code'] = 200;
       }
        catch(\Exception $e){
            $response["error"] = "Record not found.";
            $response["code"] = 400;
       }
        return response($response, $response['code']);
    }




    //method for getting expenses of specific user
    public function getExpenseOfUser(Request $request)
    {
        $user = Auth::user();
        $response = [];
        try{
            $userExpense = DB::table('expenses')->where('user_id', $user->id)->get();
            $response['userExpense'] = $userExpense;
            $response['code'] = 200;
       }
        catch(\Exception $e){
            $response["error"] = "Record not found.";
            $response["code"] = 400;
       }
        return response($response, $response['code']);
    }




    //method for getting specific expense of specific  user expense id
    public function getExpenseOfUserById(Request $request, $id)
    {
        $user = Auth::user();
        $response = [];
        try{
            $userExpense = DB::table('expenses')->where('user_id', $user->id)->where('id', $id)->get();
            $response['userExpense'] = $userExpense;
            $response['code'] = 200;
       }
        catch(\Exception $e){
            $response["error"] = "Record not found.";
            $response["code"] = 400;
       }
        return response($response, $response['code']);
    }




    //show all expenses
    public function expensesListOrderedByDate()
    {
        $user = Auth::user();
        $expenses = Expense::where('user_id', $user->id)->orderBy('expense_date', 'ASC')->get();
        // $expenses = $user->expenses()->orderBy('expense_date','DSC')->get();
        return $expenses;
    }



    //search expense
    public function searchExpenses(Request $request, $amount)
    {
        $user = Auth::user();
        $result = Expense::where('expense_amount', $amount)->orWhere('note', $amount);
        return $result;
    }



    //get clothing category
    public function clothingCategory()
    {
        $user = Auth::user();
        $clothingCategory = Expense::where('user_id', $user->id)->where('expense_category', 'Clothing')->orderBy('expense_date', 'ASC')->get();
        return $clothingCategory;
    }




    //get food category
    public function foodCategory()
    {
        $user = Auth::user();
        $foodCategory = Expense::where('user_id', $user->id)->where('expense_category', 'Food')->orderBy('expense_date', 'ASC')->get();
        return $foodCategory;
    }




    //get electricity bill category
    public function electricityBillCategory()
    {
        $user = Auth::user();
        $electriceityBillCategory = Expense::where('user_id', $user->id)->where('expense_category', 'Electricity Bill')->orderBy('expense_date', 'ASC')->get();
        return $electriceityBillCategory;
    }




    //get personal care category
    public function personalCareCategory()
    {
        $user = Auth::user();
        $personalCareCategory = Expense::where('user_id', $user->id)->where('expense_category', 'Personal Care')->orderBy('expense_date', 'ASC')->get();
        return $personalCareCategory;
    }



    //get water bill category
    public function waterBillCategory()
    {
        $user = Auth::user();
        $waterBillCategory = Expense::where('user_id', $user->id)->where('expense_category', 'Water Bill')->orderBy('expense_date', 'ASC')->get();
        return $waterBillCategory;
    }



    //get phone bill category
    public function phoneBillCategory()
    {
        $user = Auth::user();
        $phoneBillCategory = Expense::where('user_id', $user->id)->where('expense_category', 'Phone Bill')->orderBy('expense_date', 'ASC')->get();
        return $phoneBillCategory;
    }




    //get transportation category
    public function transportationCategory()
    {
        $user = Auth::user();
        $transportationCategory = Expense::where('user_id', $user->id)->where('expense_category', 'Transportation')->orderBy('expense_date', 'ASC')->get();
        return $transportationCategory;
    }




    //get transportation category
    public function savingsCategory()
    {
        $user = Auth::user();
        $savingsCategory = Expense::where('user_id', $user->id)->where('expense_category', 'Savings')->orderBy('expense_date', 'ASC')->get();
        return $savingsCategory;
    }


}


