<?php

namespace Database\Seeders;

use App\Models\Sale\Sale;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UserAdminSeeder::class);
        $this->call(ProjectStatusSeeder::class);
        $this->call(JobOrderTypeSeeder::class);
        $this->call(MaintenanceTypeSeeder::class);
        $this->call(BillOfMaterialSeederDescription::class);
        $this->call(BillOfMaterialSeederItem::class);
        $this->call(BankAccountSeeder::class);
        // Sale::factory()
        //     ->count(100)
        //     ->create();
    }
}
