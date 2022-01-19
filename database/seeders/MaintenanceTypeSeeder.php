<?php

namespace Database\Seeders;

use App\Models\Maintenance\MaintenanceType;
use Illuminate\Database\Seeder;

class MaintenanceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MaintenanceType::create([
            'type' => 'Change Oil'
        ]);
        MaintenanceType::create([
            'type' => 'Change Tire'
        ]);
    }
}
