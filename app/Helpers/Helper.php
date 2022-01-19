<?php
namespace App\Helpers;

use Illuminate\Http\Request;

use App\Models\ProjectStatus;
use App\Models\Project;

class Helper{

	public $activeProjectStatuses;
	public $projectStatuses;
	public $totalProjects;

	public static function activeProjectStatuses(){
		$activeProjectStatuses = ProjectStatus::where('is_archive', 'no')->get();
		return $activeProjectStatuses;
	}

    public static function projectStatuses(){
		$projectStatuses = ProjectStatus::all();
		return $projectStatuses;
	}

	public static function totalProjects()
	{
		$totalProjects = Project::count();
		return $totalProjects;
	}

}