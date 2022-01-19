<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryInventory\StoreCategoryCustomRequest;
use App\Http\Requests\CategoryInventory\StoreCategoryCustoRequest;
use App\Http\Requests\CategoryInventory\UpdateCategoryCustomRequest;
use App\Repositories\CategoryInventory\CategoryInventoryRepository;
use  Carbon\Carbon;


class CategoryController extends Controller
{

    private $categoryInventoryRepository;

    public function __construct(CategoryInventoryRepository $categoryInventoryRepository)
    {

        $this->middleware('auth');
        $this->categoryInventoryRepository = $categoryInventoryRepository;

    }

    public function index(){

        return view('inventory.category');

    }

    public function getCategory(Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $categories = $this->categoryInventoryRepository->getCategories(json_decode(json_encode($params)));

        return response()->json($categories, 200);

    }

    public function storeCategory(StoreCategoryCustomRequest $request)
    {

        $category = $this->categoryInventoryRepository->storeCategory($request);

        return response()->json($category, 200);

    }

    public function updateCategory($id, UpdateCategoryCustomRequest $request)
    {

        $category = $this->categoryInventoryRepository->updateCategory($id, $request);

        return response()->json($category, 200);

    }

    public function deleteCategory($id)
    {

        $deleteCategory = $this->categoryInventoryRepository->deleteCategory($id);

        return response()->json($deleteCategory, 200);

    }

}
