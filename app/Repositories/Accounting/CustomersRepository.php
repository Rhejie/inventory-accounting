<?php

namespace App\Repositories\Accounting;

use App\Models\Accounting\Customer;
use App\Repositories\Repository;

class CustomersRepository extends Repository {

    public function __construct(Customer $model)
    {

        parent::__construct($model);

    }

    public function getCustomers($params)
    {

        $customers = $this->model();

        if($params->search) {
            $customers = $customers->where(function ($query) use ($params) {
                $query->orWhere('name', 'LIKE', "%$params->search%");
                $query->orWhere('email', 'LIKE', "%$params->search%");
                $query->orWhere('contact', 'LIKE', "%$params->search%");
                $query->orWhere('billing_name', 'LIKE', "%$params->search%");
                $query->orWhere('billing_state', 'LIKE', "%$params->search%");
                $query->orWhere('billing_city', 'LIKE', "%$params->search%");
                $query->orWhere('billing_phone', 'LIKE', "%$params->search%");
            })->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $customers;
        }

        $customers = $customers->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $customers;

    }

    public function storeCustomer($request)
    {

        $data = new $this->model();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->contact = $request->contact;
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

    public function updateCustomer($id, $request)
    {

        $data = $this->model()->find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->contact = $request->contact;
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

    public function deleteCustomer($id)
    {

        $data = $this->model()->find($id);
        $data->delete();

    }

    public function searchCustomers($params)
    {

        if($params->search) {
            $customers = $this->model()
                ->orWhere('name', 'LIKE', "%$params->search%")
                ->limit(20)->get();
            return $customers;
        }

    }

    public function findCustomer($id)
    {

        $customer = $this->model()->find($id);

        return $customer;

    }

}
