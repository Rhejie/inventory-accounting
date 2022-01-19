<?php

namespace App\Http\Controllers\Inventory;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inventory\AssetCategory;
use App\Repositories\FixedAsset\FixedAssetRepository;
class FixedAssetController extends Controller
{
    private $fixedAssetRepository;

    public function __construct(FixedAssetRepository $fixedAssetRepository)
    {
        $this->fixedAssetRepository = $fixedAssetRepository;

        $this->middleware('auth');
    }

    public function index()
    {
        $AssetCategory = AssetCategory::All();
        return view('inventory.fixed_assets', compact('AssetCategory'));
    }

    public function getFixedAssets(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $type = $request->type && $request->type != '' && $request->type !== 'null' ? $request->type : null;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search,
            'type' => $type
        ];

        $getFixedAssets = $this->fixedAssetRepository->getFixedAssets(json_decode(json_encode($params)));

        return response()->json($getFixedAssets, 200);
    }

    public function getFixedAssetsToRequest(Request $request)
    {
        $search = $request->search ? $request->search : null ;

        $params = [
            'search' => $search
        ];

        $requestFixedAssets = $this->fixedAssetRepository->getFixedAssetsRequest(json_decode(json_encode($params)));

        return response()->json($requestFixedAssets, 200);
    }

}
