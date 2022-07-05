<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
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
        $client = new Client;
        $client->user_id = Auth::id();
        $client->name = $request->post('name');
        $client->address = $request->post('address');
        $client->code = $request->post('code');
        $client->vat_code = $request->post('vat_code');
        $client->save();

        return redirect()->route('user-panel');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    public function create()
    {
        return view('user.clients-create');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClientRequest  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        //
    }


    public function destroy(Client $client)
    {
        $client->update([
            'active' => 0
        ]);

        return redirect()->route('user-panel');
    }
}
