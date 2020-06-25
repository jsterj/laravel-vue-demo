<?php

use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //add the demo user
        $ts = Carbon::now();
        DB::table('users')->insert([
            'name' => 'Justin Green',
            'email' => 'justin@example.com',
            'email_verified_at' => $ts,
            'password' => Hash::make('password'),
            'profile_image' => '2f26c108-5344-489b-a51a-271281c25489',
            'created_at' => $ts,
            'updated_at' => $ts,
        ]);

        //add some random transactions
        $transactions = factory(App\Transaction::class, 300)->make();

        //make the first transaction an initial deposit
        $transactions[0]->amount = 5000;
        $transactions[0]->label = 'Initial Deposit';
        $transactions[0]->date = Carbon::now()->subDays(31);  //ensure this is first (factory has date range spanning back 30 days)

        //save the transactions
        foreach($transactions as $transaction) {
          $transaction->save();
        }
    }
}
