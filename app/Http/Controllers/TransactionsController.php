<?php

namespace App\Http\Controllers;

use Auth;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //obtain the user's most recent transactions
        $transactions = $this->getCurrentTransactions();

        //get the user's current balance
        $balance = Auth::user()->transactions()->sum('amount');

        return view('transactions', ['transactions' => $transactions->toJson(), 'balance' => $balance]);
    }

    /**
     * Obtain the user's most recent transactions and calculate their current balance
     *
     * @return JSON
     */
    public function getUpdate()
    {
        $user = Auth::user();

        //obtain the user's most recent transactions
        $transactions = $this->getCurrentTransactions();

        //get the user's current balance
        $balance = $user->transactions()->sum('amount');

        return response()->json([
            'status' => 'ok',
            'transactions' => $transactions,
            'balance' => $balance
        ]);
    }

    /**
     * Return the user's most recent transactions
     * (count defined in config 'finance.transaction.numTransactionsToList)
     *
     * @return Collection
     */
    private function getCurrentTransactions()
    {
        $user = Auth::user();
        return $user->transactions()->select('label', 'date', 'amount')->orderBy('date', 'desc')->take(config('finance.transaction.numTransactionsToList'))->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
