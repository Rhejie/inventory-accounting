<?php

namespace Database\Seeders;

use App\Models\Accounting\BankAccount;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BankAccount::create([
            'holder_name' => 'Cash',
            'bank_name' => ' ',
            'account_number' => ' ',
            'opening_balance' => '0.00',
            'contact_number' => ' ',
            'bank_address' => ' ',
        ]);
    }
}
