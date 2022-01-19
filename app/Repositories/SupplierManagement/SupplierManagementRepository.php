<?php

namespace App\Repositories\SupplierManagement;

use App\Models\SupplierManagement;
use App\Repositories\Repository;

class SupplierManagementRepository extends Repository
{

    public function __construct(SupplierManagement $model)
    {
        parent::__construct($model);
    }

    public function getSuppliers($params)
    {

        if($params->search) {
            $suppliers = $this->model()->where(function ($query) use ($params) {
                $query->orWhere('name', 'LIKE', "%$params->search%");
                $query->orWhere('contact_no', 'LIKE', "%$params->search%");
                $query->orWhere('contact_person', 'LIKE', "%$params->search%");
                $query->orWhere('address', 'LIKE', "%$params->search%");
                $query->orWhere('delivery_time', 'LIKE', "%$params->search%");
            })->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $suppliers;
        }

        $suppliers = $this->model()->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $suppliers;

    }

    public function storeSupplier($request)
    {

        $data = new $this->model();
        $data->name = $request->name;
        $data->contact_no = $request->contact_no;
        $data->contact_person = $request->contact_person;
        $data->delivery_time = $request->delivery_time;
        $data->address = $request->address;
        $data->email = $request->email;
        $data->billing_name = $request->billing_name;
        $data->billing_country = $request->billing_country;
        $data->billing_state = $request->billing_state;
        $data->billing_city = $request->billing_city;
        $data->billing_phone = $request->billing_phone;
        $data->billing_zip = $request->billing_zip;
        $data->billing_address = $request->billing_address;
        $data->shipping_name = $request->shipping_name;
        $data->shipping_country = $request->shipping_country;
        $data->shipping_state = $request->shipping_state;
        $data->shipping_city = $request->shipping_city;
        $data->shipping_phone = $request->shipping_phone;
        $data->shipping_zip = $request->shipping_zip;
        $data->shipping_address = $request->shipping_address;

        if($data->save()) {
            return $data;
        }

    }

    public function getSupplier($id)
    {

        $supplier = $this->model()->find($id);

        return $supplier;

    }

    public function updateSupplier($id, $request)
    {

        $data = $this->model()->find($id);

        $data->name = $request->name;
        $data->contact_no = $request->contact_no;
        $data->contact_person = $request->contact_person;
        $data->delivery_time = $request->delivery_time;
        $data->address = $request->address;
        $data->email = $request->email;
        $data->billing_name = $request->billing_name;
        $data->billing_country = $request->billing_country;
        $data->billing_state = $request->billing_state;
        $data->billing_city = $request->billing_city;
        $data->billing_phone = $request->billing_phone;
        $data->billing_zip = $request->billing_zip;
        $data->billing_address = $request->billing_address;
        $data->shipping_name = $request->shipping_name;
        $data->shipping_country = $request->shipping_country;
        $data->shipping_state = $request->shipping_state;
        $data->shipping_city = $request->shipping_city;
        $data->shipping_phone = $request->shipping_phone;
        $data->shipping_zip = $request->shipping_zip;
        $data->shipping_address = $request->shipping_address;
        if($data->save()) {
            return $data;
        }

    }

    public function deleteSupplier($id)
    {

        $delete = $this->model()->find($id);
        $delete->delete();

        return 'Successfully Deleted';

    }

    public function getSuppliersData($params)
    {

        if($params->search) {

            $suppliers = $this->model()->where('name', 'LIKE', "%$params->search%")->limit(20)->get();

            return $suppliers;

        }

    }

}
