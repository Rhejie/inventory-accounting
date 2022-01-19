<?php

namespace Database\Seeders;

use App\Models\ProjectStatus;
use Illuminate\Database\Seeder;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectStatus::create([
            'name' => 'Active'
        ]);

        ProjectStatus::create([
            'name' => 'On Going'
        ]);

        ProjectStatus::create([
            'name' => 'Pending'
        ]);

        ProjectStatus::create([
            'name' => 'Cancelled'
        ]);

        ProjectStatus::create([
            'name' => 'Complete'
        ]);
    }
}
