<?php

namespace Database\Seeders;

use App\Models\Project\BillOfMaterialItem;
use Illuminate\Database\Seeder;

class BillOfMaterialSeederItem extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => '1.0', 'description' => 'General Requirements'],
            ['name' => '2.0', 'description' => 'Information'],
            ['name' => '3.0','description' => 'Information'],
            ['name' => '4.0', 'description' => 'Information'],
            ['name' => '5.0', 'description' => 'Information'],
        ];

        foreach ($items as $item) {
            BillOfMaterialItem::create($item);
        }
    }
}
