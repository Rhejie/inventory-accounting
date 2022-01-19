<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inventory\EquipmentDocument;
use App\Repositories\EquipmentDocumentRepository;
use App\Http\Requests\StoreDocumentRequest;
use Crypt;
use  Carbon\Carbon;

class EquipmentDocumentController extends Controller
{
    //
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function displayDocuments($id, EquipmentDocumentRepository $equipmentDocument){

    	 $query = $equipmentDocument->FindAll($id);

    	return datatables($query)
                ->addIndexColumn()
                ->addColumn('attached_file', function($row){

                	$link = '<a href="/assets/img/file/'.$row->attached_file.'" download="'.$row->attached_file .'">'.$row->attached_file .'</a>';

                	return $link;
                })

                ->addColumn('created_at', function($row){

                	return Carbon::parse($row->created_at)->format('d/m/Y');
                })

                ->addColumn('action', function($row){
                    $btn = '';

                     $btn = $btn . '<div class="btn-group " role="group" aria-label="" >';
                     $btn = $btn . '<a  href="javascript:;;"  class="btn flaticon2-edit"> Edit</a> ';
                    // $btn = $btn . '<a  onClick="editDoctor('.$row->id.')"   class="btn flaticon2-edit postbutton" data-toggle="modal" data-target="#editDoctorDialog" ></a> ';

                    $btn = $btn . '<button   class="btn flaticon2-trash" > Delete</button>';

                        return $btn;
                })
                ->rawColumns(['attached_file','action','checkbox'])
                ->make(true);
    }


    public function addDocument(StoreDocumentRequest $documentRequest, EquipmentDocumentRepository $equipmentDocument){

    	 $data = $equipmentDocument->store($documentRequest);
         return back()->with('success', $data);

    }

}
