<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use App\Http\Requests\StoreUserInfoRequest;
use App\Http\Requests\UpdateUserInfoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserInfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $phone = $request->post('phone') ?? null;
        $address = $request->post('address') ?? null;
        $pcode = $request->post('pcode') ?? null;
        $iacode = $request->post('iacode') ?? null;

        $userInfo = new UserInfo;
        $userInfo->user_id = Auth::id();
        $userInfo->phone = $phone;
        $userInfo->address = $address;
        $userInfo->personal_code = $pcode;
        $userInfo->ia_certificate_id = $iacode;
        $userInfo->save();

        return redirect()->route('user-panel');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserInfo  $userInfo
     * @return \Illuminate\Http\Response
     */
    public function show(UserInfo $userInfo)
    {
        //
    }

    public function edit()
    {
        $user = Auth::user();

        $data['details'] = $user->details;

        return view('user.edit', $data);
    }

    public function update(Request $request, UserInfo $userInfo)
    {
        $userInfo = UserInfo::find(Auth::id());

        $phone = $request->post('phone') ?? null;
        $address = $request->post('address') ?? null;
        $pcode = $request->post('pcode') ?? null;
        $iacode = $request->post('iacode') ?? null;

        $userInfo->update([
            'phone' => $phone,
            'address' => $address,
            'personal_code' => $pcode,
            'ia_certificate_id' => $iacode
        ]);

        return redirect()->route('user-panel');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserInfo  $userInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserInfo $userInfo)
    {
        //
    }
}
