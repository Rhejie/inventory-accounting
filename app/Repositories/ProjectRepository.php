<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\ProjectDocuments;
use File;
use DB;
class ProjectRepository
{
    public function model()
    {
        return Project::orderBy('updated_at', 'desc')->get();
    }

    public function showProjectDocument($project_id)
    {
        return ProjectDocuments::orderBy('updated_at', 'desc')
        ->where('project_id', $project_id)
        ->get();

    }

    public function show($id)
    {
        return Project::find($id);
    }

    public function store($request)
    {

        $request = $this->storeImage($request);
        $data = new Project;
        $data->name = $request->name;
        $data->location = $request->location;
        $data->description = $request->description;
        $data->date_start = $request->date_start;
        $data->date_end = $request->date_end;
        $data->budget = $request->budget;
        $data->status_id = $request->status_id;
        $data->percentage = $request->percentage;
        $data->photo = $request->photo;
        $data->save();

        return 'Project created successfully!';
    }

    public function update($request, $id)
    {
        $request = $this->storeImage($request);
        $data = Project::find($id);
        $data->name = $request->name;
        $data->location = $request->location;
        $data->description = $request->description;
        $data->date_start = $request->date_start;
        $data->date_end = $request->date_end;
        $data->budget = $request->budget;
        $data->status_id = $request->status_id;
        $data->percentage = $request->percentage;
        if($request->photo != NULL)
        {
            $data->photo = $request->photo;
        }
        $data->save();

        return 'Project updated successfully!';
    }

    public function destroy($id)
    {
        $data = Project::findOrFail($id);
        $image_path = app_path("public/assets/img/project/{$data->photo}");

        if (File::exists($image_path)) {
            File::delete($image_path);
        }

        $data->delete();
        return 'Project Site Deleted Successfully!';
    }

    public function storeImage($request)
    {
        if($request->hasFile('photo'))
        {
            $folder = "/project/photo";
            $media = $request->file('photo');
            $name = time() . '.' . $media->extension();
            $link = $media->storeAs($folder, $name, 'public');

            $request->photo = $name;
        }

        return $request;
    }

    public function searchProjects($request)
    {
        return Project::where('name', 'like', '%' . $request->value . '%')
        ->orWhere('location', 'like', '%' .$request->value . '%')->orderBy('updated_at', 'desc')->get();
    }

    public function storeProjectDocuments($request)
    {
        if($request->file()){

            $file = $request->file('file');
            $data = new ProjectDocuments();
            $data->project_id = $request->project_id;

            $fileName = time()  . '.' . $request->file->extension();
            $file->storeAs('public/assets/file', $fileName);

            $data->file_name = $fileName;
            $data->type = $request->type;
            $data->remarks = $request->remarks;

            $data->save();

            return $data;
        }
    }
}
