<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\RevenueCustomRequest;
use App\Http\Requests\Accounting\RevenueUpdateCustomRequest;
use App\Repositories\Accounting\RevenueRepository;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    private $revenueRepository;

    public function __construct(RevenueRepository $revenueRepository)
    {

        $this->revenueRepository = $revenueRepository;

    }

    public function getRevenues(Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $revenues = $this->revenueRepository->getRevenues(json_decode(json_encode($params)));

        return response()->json($revenues, 200);

    }

    public function storeRevenue(RevenueCustomRequest $request)
    {

        $revenue = $this->revenueRepository->storeRevenue($request);

        return response()->json($revenue, 200);

    }

    public function updateRevenue($id, RevenueUpdateCustomRequest $request)
    {

        $revenue = $this->revenueRepository->updateRevenue($id, $request);

        return response()->json($revenue, 200);

    }

    public function deleteRevenue($id)
    {

        $revenue = $this->revenueRepository->deleteRevenue($id);

        return response()->json($revenue, 200);

    }
}
