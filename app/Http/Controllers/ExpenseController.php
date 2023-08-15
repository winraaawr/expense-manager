<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    public function index(){
        $user = Auth::user();

        if($user->role_id === 1){
            $expenses = Expense::with('category', 'user')->get();
        }else{
            $expenses = Expense::where('user_id', $user->id)->with('category', 'user')->get();
        }
        
        $categories = Category::all();

        return Inertia::render('Expenses', [
            "expenses" => $expenses,
            "categories" => $categories,
        ]);
    }

    public function show(){
        $user = Auth::user();
        if($user->role_id === 1){
            $expenses = DB::table('categories')
            ->select('category_name', DB::raw('COALESCE(SUM(amount)) as total_amount'))
            ->groupBy('category_name', 'category_id')
            ->leftJoin('expenses', 'expenses.category_id', '=', 'categories.id')
            ->get();
        }else{
            $expenses = DB::table('categories')
            ->select('category_name', DB::raw('COALESCE(SUM(amount)) as total_amount'))
            ->groupBy('category_name', 'category_id')
            ->leftJoin('expenses', 'expenses.category_id', '=', DB::raw('categories.id AND user_id ='.$user->id) )
            ->get();
        }
        

        // $expense = DB::table('categories')->select('category_id, category_name')

        return Inertia::render('Dashboard', [
            "expenses" => $expenses,
        ]);
    }

    public function store(StoreExpenseRequest $request)
    {
        Expense::create($request->validated());

        return redirect()->route(route: 'expenses')->with('message', 'New expense created successfully.');
    }

    public function update(Expense $expense, UpdateExpenseRequest $request)
    {
        $expense->update($request->validated());
        return redirect()->route(route: 'expenses')->with('message', 'An expense was updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route(route: 'expenses')->with('message', 'An expense was deleted successfully.');
    }
    
}
