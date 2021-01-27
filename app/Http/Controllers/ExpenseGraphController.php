<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Expense;
use App\Models\User;
use App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ExpenseGraphController extends Controller
{

    //get  the expenses of a user from previous day
    public function yesterdayChart()
    {   
        $user = Auth::user();
        $data = Expense::select(
            DB::raw('expense_category as category'),
            DB::raw('sum(expense_amount) as amount'))
            ->where('user_id', $user->id)
            ->where('expense_date' ,now()->yesterday())
           ->groupBy('category')
           ->get();
      
        $array[] = ['Category', 'Amount'];

        foreach($data as $key => $value)
        {
          $array[++$key] = [$value->category, $value->amount];
        }

        return json_encode($array);
    }



     public function weeklyChart()
    {

        $user = Auth::user();
        $data = Expense::select(
            DB::raw('expense_category as category'),
            DB::raw('sum(expense_amount) as amount'))
            ->where('user_id', $user->id)
            ->where('expense_date','>', now()->subDays(7))
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



        //method for showing the expenses by current month of specific user in the pie graph
        public function monthlyChart()
        {
          $user = Auth::user();
            $data = Expense::select(
                DB::raw('expense_category as category'),
                DB::raw('sum(expense_amount) as amount'))
                ->where('user_id', $user->id)
                ->where('expense_date','>', now()->subMonth())
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



         //method for showing the expenses in the current year of specific user in the pie graph
    public function yearlyChart()
    {

      $user = Auth::user();
        $data = Expense::select(
            DB::raw('expense_category as category'),
            DB::raw('sum(expense_amount) as amount'))
            ->where('user_id', $user->id)
            ->where('expense_date','>', now()->subYear())
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

}  