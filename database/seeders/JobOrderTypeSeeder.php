<?php

namespace Database\Seeders;

use App\Models\JobOrder\JobOrderType;
use Illuminate\Database\Seeder;

class JobOrderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JobOrderType::create([
            'type' => 'Change Oil'
        ]);


        JobOrderType::create([
            'type' => 'Renewal of Registration'
        ]);


        JobOrderType::create([
            'type' => 'Insurance'
        ]);
    }
}
