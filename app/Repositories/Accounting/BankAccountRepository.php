<?php

namespace App\Repositories\Accounting;

use App\Models\Accounting\BankAccount;
use App\Models\Accounting\Attachment;
use App\Repositories\Repository;

class BankAccountRepository extends Repository
{

    public function __construct(BankAccount $model)
    {

        parent::__construct($model);

    }

    public function getBankAccounts($params)
    {

        $accounts = $this->model()->with(['attachable']);

        if($params->search) {

            $accounts = $accounts
                    ->orWhere('holder_name', 'LIKE', "%$params->search%")
                    ->orWhere('bank_name', 'LIKE', "%$params->search%")
                    ->orWhere('account_number', 'LIKE', "%$params->search%")
                    ->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

            return $accounts;

        }

        $accounts = $accounts->orderBy('id', 'desc')->paginate($params->count, ['*'], 'page', $params->page);

        return $accounts;

    }

    public function storeAccount($request)
    {

        $data = new $this->model();
        $data->holder_name = $request->holder_name;
        $data->bank_name = $request->bank_name;
        $data->account_number = $request->account_number;
        $data->opening_balance = $request->opening_balance;
        $data->contact_number = $request->contact_number;
        $data->bank_address = $request->bank_address;
        if($data->save()) {

            if($request->hasFile('file')) {

                $folder = '/bank/account/';
                $media = $request->file('file');
                $name = time() . '.' . $media->extension();
                $link = $media->storeAs($folder, $name, 'public');

                $attachment = new Attachment();
                $attachment->attachable_type = 'App\Models\Accounting\BankAccount';
                $attachment->attachable_id = $data->id;
                $attachment->file = $name;
                $attachment->file_name = $request->file_name;
                $attachment->path = $folder;
                $attachment->save();
            }

            return $this->model()->with(['attachable'])->find($data->id);
        }

    }

    public function updateAccount($id, $request)
    {

        $data = $this->model()->find($id);
        $data->holder_name = $request->holder_name;
        $data->bank_name = $request->bank_name;
        $data->account_number = $request->account_number;
        $data->opening_balance = $request->opening_balance;
        $data->contact_number = $request->contact_number;
        $data->bank_address = $request->bank_address;
        if($data->save()) {
            if($request->hasFile('file')) {

                $at = Attachment::where('attachable_type', 'App\Models\Accounting\BankAccount')->where('attachable_id', $id)->first();
                if($at) {
                    \Storage::disk('public')->delete("/bank/account/". $at->file);
                    $at->delete();
                }

                $folder = '/bank/account/';
                $media = $request->file('file');
                $name = time() . '.' . $media->extension();
                $link = $media->storeAs($folder, $name, 'public');

                $attachment = new Attachment();
                $attachment->attachable_type = 'App\Models\Accounting\BankAccount';
                $attachment->attachable_id = $data->id;
                $attachment->file = $name;
                $attachment->file_name = $request->file_name;
                $attachment->path = $folder;
                $attachment->save();
            }

            else if($request->remove_file) {
                $at = Attachment::where('attachable_type', 'App\Models\Accounting\BankAccount')->where('attachable_id', $id)->first();
                if($at) {
                    \Storage::disk('public')->delete("/bank/account/". $at->file);
                    $at->delete();
                }
            }
            return $this->model()->with(['attachable'])->find($id);
        }

    }

    public function deleteAccount($id)
    {

        $accounts = $this->model()->find($id);
        if($accounts) {
            $accounts->delete();
        }

    }

    public function searchAccount($params)
    {

        if($params->search) {

            $accounts = $this->model()
                ->orWhere('holder_name', 'LIKE', "%$params->search%")
                ->orWhere('bank_name', 'LIKE', "%$params->search%")
                ->orWhere('account_number', 'LIKE', "%$params->search%")
                ->limit(20)->get();

            return $accounts;

        }

    }

    public function addAmount($request)
    {

        $data = $this->model()->find($request->account_id);
        if($request->status == 'add') {
            $data->opening_balance += $request->amount;
            if($data->save()) {
                return 'add amount';
            }
        }

        else if ($request->status == 'update') {
            $data->opening_balance -= $request->previous_amount;
            $data->opening_balance += $request->amount;
            if($data->save()) {
                return 'update amount';
            }

        }

        $data->opening_balance -= $request->amount;
        if($data->save()) {
            return 'minus amount';
        }

    }

    public function transferAccount($request)
    {

        $account = $this->model()->find($request->from_account);
        $account->opening_balance -= $request->amount;

        if($account->opening_balance < 0) {
            return 'insufficient';
        }

        if($account->save()) {
            return 'save';
        }

    }

    public function transferAccountTo($request)
    {
        $account = $this->model()->find($request->to_account);
        $account->opening_balance += $request->amount;
        if($account->save()) {
            return 'save';
        }
    }

    public function updateAmountFromToNotChange($request)
    {

        $accountFrom = $this->model()->find($request->from_account);
        $accountFrom->opening_balance += $request->prev_amount;
        $accountFrom->opening_balance -= $request->new_amount;

        if($accountFrom->opening_balance < 0) {
            return 'insufficient';
        }

        if($accountFrom->save()) {
            $accountTo = $this->model()->find($request->to_account);
            $accountTo->opening_balance -= $request->prev_amount;

            if($accountTo->opening_balance < 0) {
                return 'insufficient';
            }

            $accountTo->opening_balance += $request->new_amount;

            if($accountTo->save()) {
                return 'save';
            }
        }

    }

    public function updateAmountFromNotChange($request)
    {

        $accountFrom = $this->model()->find($request->from_account);
        $accountFrom->opening_balance += $request->prev_amount;
        $accountFrom->opening_balance -= $request->new_amount;

        if($accountFrom->opening_balance < 0) {

            return 'insufficient';
        }

        if($accountFrom->save()) {

            $accountTo = $this->model()->find($request->prev_account);
            $accountTo->opening_balance -= $request->prev_amount;
            if($accountTo->opening_balance < 0) {
                return 'insufficient';
            }

            if($accountTo->save()) {

                $newAccount = $this->model()->find($request->to_account);
                $newAccount->opening_balance += $request->new_amount;

                if($newAccount->opening_balance < 0) {
                    return 'insufficient';
                }

                if($newAccount->save()) {
                    return 'save';
                }
            }
        }
    }

    public function updateAmountToNotChange($request)
    {

        $prevFromAccount = $this->model()->find($request->prev_from_account);
        $prevFromAccount->opening_balance += $request->prev_amount;

        if($prevFromAccount->save()) {

            $fromAccount = $this->model()->find($request->from_account);
            $fromAccount->opening_balance -= $request->new_amount;

            if($fromAccount->opening_balance < 0) {

                $prevFromAccount->opening_balance -= $request->prev_amount;

                $prevFromAccount->save();

                return 'insufficient';
            }

            if($fromAccount->save()) {

                $toAccount = $this->model()->find($request->to_account);

                $toAccount->opening_balance -= $request->prev_amount;

                if($toAccount->opening_balance < 0) {

                    $prevFromAccount->opening_balance -= $request->prev_amount;

                    if($prevFromAccount->save()) {

                        $fromAccount->opening_balance += $request->new_amount;

                        $fromAccount->save();
                    }
                    return 'insufficient';
                }

                $toAccount->opening_balance += $request->new_amount;
                if($toAccount->save()) {
                    return 'save';
                }

            }
        }

    }

    public function updateAmountChange($request)
    {

        $prevFromAccount = $this->model()->find($request->prev_from_account);
        $prevFromAccount->opening_balance += $request->prev_amount;

        if($prevFromAccount->save()) {

            $prevToAccount = $this->model()->find($request->prev_to_account);
            $prevToAccount->opening_balance -= $request->prev_amount;
            if($prevToAccount->save()) {

                $fromAccount = $this->model()->find($request->from_account);
                $fromAccount->opening_balance -= $request->new_amount;

                if($fromAccount->opening_balance < 0) {
                    return 'insufficient';
                }

                if($fromAccount->save()) {

                    $toAccount = $this->model()->find($request->to_account);
                    $toAccount->opening_balance += $request->new_amount;

                    if($toAccount->save()) {
                        return 'save';
                    }
                }


            }

        }

    }

    public function billPaymentStore($request)
    {

        $account = $this->model->find($request->account_id);
        if($account->opening_balance < $request->amount) {
            return 'insufficient';
        }
        $account->opening_balance -= $request->amount;
        if($account->save()) {
            return 'save';
        }

    }

    public function updateBillPayment($request)
    {

        $prev_account = $this->model()->find($request->prev_account_id);
        $new_account = $this->model()->find($request->new_account_id);

        $prev_account->opening_balance += $request->prev_amount;

        if($new_account->opening_balance < $request->new_amount) return 'insufficient';

        if($prev_account->save()) {

            $new_account->opening_balance -= $request->new_amount;
            if($new_account->save()) {
                return 'save';
            }

        }

    }

    public function updateBillPaymentNewAmount($request)
    {

        $account = $this->model()->find($request->account_id);
        $account->opening_balance += $request->prev_amount;
        $account->opening_balance -= $request->new_amount;
        if($account->opening_balance < 0) {
            return 'insufficient';
        }

        if($account->save()) {
            return 'save';
        }

    }

    public function deleteAmount($request) {

        $fromAccount = $this->model()->find($request->from_account);
        $fromAccount->opening_balance += $request->amount;
        if($fromAccount->save()) {
            $toAccount = $this->model()->find($request->to_account);
            $toAccount->opening_balance -= $request->amount;
            if($toAccount->save()) {
                return 'save';
            }
        }

    }

    public function deletePaymentBill($request)
    {

        $account = $this->model()->find($request->account_id);
        $account->opening_balance += $request->amount;
        if($account->save()) {
            return 'save';
        }

    }

    public function payBill($request)
    {

        $account = $this->model()->find($request->account_id);
        if($account->opening_balance < $request->amount) {
            return 'insufficient';
        }

        $account->opening_balance -= $request->amount;
        if($account->save()) {
            return 'save';
        }

    }

    public function updatePayBillChangeAccount($request)
    {

        $prev_account = $this->model()->find($request->prev_account_id);
        $prev_account->opening_balance += $request->prev_amount;

        if($prev_account->save()) {

            $new_account = $this->model()->find($request->new_account_id);

            if($new_account->opening_balance < $request->new_amount) {

                return 'insufficient';

            }

            $new_account->opening_balance -= $request->new_amount;
            if($new_account->save()) {
                return 'save';
            }

        }

    }

    public function updatePayBillAccount($request)
    {

        $account = $this->model()->find($request->account_id);
        $account->opening_balance += $request->prev_amount;
        if($account->opening_balance < $request->new_amount) {
            return 'insufficient';
        }
        $account->opening_balance -= $request->new_amount;
        if($account->save()) {
            return 'save';
        }

    }
}
