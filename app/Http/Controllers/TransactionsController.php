<?php

namespace App\Http\Controllers;

use Auth;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $plinks = $transactions->links();  //get the pagination links
        $transactions = $transactions->getCollection(); //get the transactions from the paginator

        //get the user's current balance
        $balance = Auth::user()->transactions()->sum('amount');

        return view('transactions', ['transactions' => $transactions->toJson(), 'balance' => $balance, 'plinks' => $plinks]);
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
        $transactions = $transactions->getCollection();

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
        //return $user->transactions()->select('id', 'label', 'date', 'amount')->orderBy('date', 'desc')->take(config('finance.transaction.numTransactionsToList'))->get();
        return $user->transactions()->select('id', 'label', 'date', 'amount')->orderBy('date', 'desc')->simplePaginate(config('finance.transaction.numTransactionsToList'));
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
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function asyncStore(Request $request)
    {
        $data = $request->all();
        $label = $data['label'];
        $label = htmlentities(strip_tags(stripslashes(trim($label))));

        //validate the input
        $validator = Validator::make($request->all(), [
          'label' => 'required|max:' . config('finance.transaction.maxLabelLength'),
          'date' => 'required|date',
          'amount' => 'required|numeric|max:' . config('finance.transaction.maxAmount') . '|min:' . config('finance.transaction.minAmount'),
        ]);

        if ($validator->fails()) {
          $errors = $validator->errors();
          return response()->json([
              'status' => 'failed',
              'error' => $errors->all(),
          ]);
        }

        //update the record
        $transaction = new Transaction;
        $validatedData = $validator->valid();
        $transaction->user_id = Auth::user()->id;
        $transaction->label = $validatedData['label'];
        $transaction->date = $validatedData['date'];
        $transaction->amount = $validatedData['amount'];
        $transaction->save();

        return response()->json([
            'status' => 'created',
            'transaction' => $transaction->id,
        ]);
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
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function asyncUpdate(Request $request, $id)
    {
      //get the transaction record
      $transaction = Transaction::find($id);

      //check that user owns this resource
      if($transaction && $transaction->user_id != Auth::user()->id) {
        return response()->json([
            'status' => 'unauthorized',
            'transaction' => $id,
        ]);
      }

      //if the record is found
      if($transaction) {
        $data = $request->all();
        $label = $data['label'];
        $label = htmlentities(strip_tags(stripslashes(trim($label))));

        //validate the input
        $validator = Validator::make($request->all(), [
          'label' => 'required|max:' . config('finance.transaction.maxLabelLength'),
          'date' => 'required|date',
          'amount' => 'required|numeric|max:' . config('finance.transaction.maxAmount') . '|min:' . config('finance.transaction.minAmount'),
        ]);

        if ($validator->fails()) {
          $errors = $validator->errors();
          return response()->json([
              'status' => 'failed',
              'error' => $errors->all(),
              'transaction' => $id,
          ]);
        }

        //update the record
        $validatedData = $validator->valid();
        $transaction->label = $validatedData['label'];
        $transaction->date = $validatedData['date'];
        $transaction->amount = $validatedData['amount'];
        $transaction->save();

        return response()->json([
            'status' => 'updated',
            'transaction' => $id,
        ]);
      }

      //record not found
      return response()->json([
          'status' => 'failed',
          'error' => 'Transaction not found',
          'transaction' => $id,
      ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function asyncDestroy($id)
    {
      //get the transaction record
      $transaction = Transaction::find($id);

      //check that user owns this resource
      if($transaction && $transaction->user_id != Auth::user()->id) {
        return response()->json([
            'status' => 'unauthorized',
            'transaction' => $id,
        ]);
      }

      //delete the record
      if($transaction) {
        $transaction->delete();
        return response()->json([
            'status' => 'deleted',
            'transaction' => $id,
        ]);
      }

      //record not found
      return response()->json([
          'status' => 'failed',
          'transaction' => $id,
      ]);
    }
}
