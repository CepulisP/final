<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\UserBank;
use App\Http\Requests\StoreUserBankRequest;
use App\Http\Requests\UpdateUserBankRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $bank = new UserBank();
        $bank->user_id = Auth::id();
        $bank->bank_id = $request->post('bank_id');
        $bank->account_number = $request->post('account_number');
        $bank->save();

        return redirect()->route('user-panel');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserBank  $userBank
     * @return \Illuminate\Http\Response
     */
    public function show(UserBank $userBank)
    {
        //
    }

    public function create()
    {
        $data['banks'] = Bank::all();

        return view('user.banks-create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserBankRequest  $request
     * @param  \App\Models\UserBank  $userBank
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserBankRequest $request, UserBank $userBank)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserBank  $userBank
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserBank $userBank)
    {
        $userBank->delete();

        return redirect()->route('user-panel');
    }
}
