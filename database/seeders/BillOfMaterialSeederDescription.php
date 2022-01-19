<?php

namespace Database\Seeders;

use App\Models\Project\BillOfMaterialDescription;
use Illuminate\Database\Seeder;

class BillOfMaterialSeederDescription extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'Mobilization / Demobilization'],
            ['name' => 'Materials Sampling and Testing'],
            ['name' => 'As-built, Shop Drawings, Submittals and Reports'],
            ['name' => 'Construction Survey, Site Survey and Stake out'],
            ['name' => 'Temporary Facilities'],
        ];

        foreach ($items as $item) {
            BillOfMaterialDescription::create($item);
        }
    }
}
