<?php

namespace App\Repositories\Accounting;

use App\Models\Accounting\BillItem;
use App\Repositories\Repository;

class BillItemRepository extends Repository
{

    public function __construct(BillItem $model)
    {

        parent::__construct($model);

    }

}
