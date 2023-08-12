<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    public function index(){
        $expenses = Expense::all();

        return Inertia::render('Expenses', [
            "expenses" => $expenses
        ]);
    }
    
}
