<?php

namespace App\Repositories\OtherInventory;

use App\Models\Inventory\OtherAssetDocument;
use App\Repositories\Repository;

class OtherInventoryDocumentRepository extends Repository
{

    public function __construct(OtherAssetDocument $model)
    {
        parent::__construct($model);
    }

    public function getDocuments($id, $params)
    {
        if($params->search) {
            $documents = $this->model()->where(function ($query) use ($params) {
                $query->orWhere('attached_file', 'LIKE', "%$params->search%");
                $query->orWhere('file_type', 'LIKE', "%$params->search%");
                $query->orWhere('file_name', 'LIKE', "%$params->search%");
            })->where('other_asset_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $documents;
        }

        $documents = $this->model()->where('other_asset_id', $id)->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $documents;
    }

    public function storeDocument($id, $request)
    {

        if($request->hasFile('attached_file')) {
            $folder = "/other_inventory/documents";
            $media = $request->file('attached_file');
            $name =  $id . "_" . time() . '.' . $media->extension();
            $link = $media->storeAs($folder, $name, 'public');

            $document = new $this->model();
            $document->file_type = $request->file_type;
            $document->attached_file = $name;
            $document->file_name = $request->file_name;
            $document->other_asset_id = $id;

            if($document->save()) {
                return $document;
            }
        }

    }

    public function updateDocument($id, $request)
    {
        $data = $this->model()->find($id);
        $data->file_type = $request->file_type;

        if($request->hasFile('attached_file')){
            \Storage::disk('public')->delete('/other_inventory/documents/'. $data->attached_file);
            $folder = "/other_inventory/documents";
            $media = $request->file('attached_file');
            $name =  $id . "_" . time() . '.' . $media->extension();
            $link = $media->storeAs($folder, $name, 'public');

            $data->attached_file = $name;
            $data->file_name = $request->file_name;

            if($data->save()) {
                return $data;
            }
        }

        if($data->save()) {
            return $data;
        }
    }

    public function deleteDocument($id)
    {

        $data = $this->model()->find($id);

        \Storage::disk('public')->delete('/other_inventory/documents/'. $data->attached_file);

        $data->delete();

    }
}
