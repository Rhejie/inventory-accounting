<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Project\ProjectStoreDocumentRequest;
use App\Http\Requests\Project\StoreProjectCustomeRequest;
use App\Http\Requests\Project\UpdateDocumentCustomRequest;
use App\Http\Requests\Project\UpdateProjectCustomRequest;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Repositories\Project\ProjectFixedAssetRepository;
use App\Repositories\Project\ProjectRepository as AppProjectRepository;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // private $helper;
    private $projectRepository;
    private $projectFixedAssetRepository;

    public function __construct(AppProjectRepository $projectRepository, ProjectFixedAssetRepository $projectFixedAssetRepository)
    {

        $this->middleware('auth');
        $this->projectRepository = $projectRepository;
        $this->projectFixedAssetRepository = $projectFixedAssetRepository;

    }

    // public function index(ProjectRepository $projectRepository)
    public function index()
    {
        $statusProject = ProjectStatus::get();
        return view('project/index', compact('statusProject'));
    }

    public function getProjects(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getProjects = $this->projectRepository->getProjects(json_decode(json_encode($params)));

        return response()->json($getProjects, 200);

    }

    public function storeProject(StoreProjectCustomeRequest $request)
    {
        $storeProject = $this->projectRepository->storeProject($request);

        return response()->json($storeProject, 200);
    }

    public function updateProject($id, UpdateProjectCustomRequest $request)
    {
        $updateProject = $this->projectRepository->updateProject($id, $request);

        return response()->json($updateProject, 200);
    }

    public function showDetails($id) {

        $projectDetails = $this->projectRepository->getProjectDetails($id);

        return response()->json($projectDetails, 200);

    }

    public function storeProjectDocument($id, ProjectStoreDocumentRequest $request)
    {
        $storeProjectDocument = $this->projectRepository->storeProjectDocument($id, $request);

        return response()->json($storeProjectDocument, 200);
    }

    public function getProjectDocuments($id, Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getProjectDocuments = $this->projectRepository->getProjectDocuments($id, json_decode(json_encode($params)));

        return response()->json($getProjectDocuments, 200);
    }

    public function deleteProject($id) {

        $deleteProject = $this->projectRepository->deleteProject($id);

        return response()->json($deleteProject, 200);

    }

    public function viewProjectDocument(Request $request) {

        $file = $request->file;

        return view('project.view-project-document', compact('file'));

    }

    public function deleteDocument($id)
    {
        $delete = $this->projectRepository->deleteDocument($id);

        return response()->json($delete, 200);
    }

    public function updateDocument($id, UpdateDocumentCustomRequest $request)
    {
        $updateDocument = $this->projectRepository->updateDocument($id, $request);

        return response()->json($updateDocument, 200);
    }

    public function getProjectsData(Request $request)
    {
        $search = $request->search ? $request->search : '';

        $params = [
            'search' => $search
        ];

        $projects = $this->projectRepository->getProjectsData(json_decode(json_encode($params)));

        return response()->json($projects, 200);

    }

    public function getFixedAssets($id, Request $request)
    {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        // $getFixedAssets = $this->projectRepository->getFixedAssets($id, json_decode(json_encode($params)));
        $getFixedAssets = $this->projectFixedAssetRepository->getFixedAssets($id, json_decode(json_encode($params)));

        return response()->json($getFixedAssets, 200);

    }

    public function getConsumableSupplies($id, Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search
        ];

        $getFixedAssets = $this->projectRepository->getConsumableSupplies($id, json_decode(json_encode($params)));

        return response()->json($getFixedAssets, 200);
    }

    public function storeProjectFixedAsset(Request $request)
    {

        $fixedAsset = $this->projectFixedAssetRepository->store(json_decode(json_encode($request->all())));

        return response()->json($fixedAsset, 200);

    }

    public function deleteProjectFixedAsset(Request $request)
    {

        $deleteFixedAsset = $this->projectFixedAssetRepository->deleteFixedAsset(json_decode(json_encode($request->all())));

        return response()->json($deleteFixedAsset, 200);

    }

}
