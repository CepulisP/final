<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Invoice;
use App\Models\InvoiceType;
use App\Models\Service;
use App\Models\Unit;
use App\Models\UserBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{

    public function index()
    {
        $this->middleware('auth');

        $data['invoices'] = Invoice::where('user_id', '=', Auth::id())->get();

        return view('invoices.all', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return
     */
    public function create()
    {
        $data['banks'] = Bank::all();
        $data['units'] = Unit::all();
        $data['types'] = InvoiceType::all();
        $data['currencies'] = Currency::all();

        if (Auth::check()) {
            $data['userBanks'] = Auth::user()->banks;
            $data['clients'] = Auth::user()->clients;
            $data['details'] = Auth::user()->details;

            return view('invoices.invoice-with-user', $data);
        } else {
            return view('invoices.invoice-no-user', $data);
        }
    }

    public function store(Request $request)
    {
        $this->middleware('auth');

        $r = $request->post();
        $inv = new Invoice();

//        if (isset($r['icon']) && !empty($r['icon'])) {
//            $inv->icon_id = $r['icon'];
//        }

        $inv->user_id = Auth::id();
        $inv->series = $r['series'];
        $inv->serial_number = $r['seriesnr'];
        $inv->type_id = $r['type'];
        $inv->date = $r['date'];
        $inv->seller_name = $r['name'];
        $inv->seller_phone = $r['phone'];
        $inv->seller_address = $r['address'];

        if (isset($r['ak']) && !empty($r['ak'])) {
            $inv->seller_personal_code = $r['ak'];
        }

        if (isset($r['ivnr']) && !empty($r['ivnr'])) {
            $inv->seller_ia_certificate_id = $r['ivnr'];
        }

        if (isset($r['bankid']) && !empty($r['bankid'])) {
            $inv->seller_bank_id = $r['bankid'];
            $inv->seller_bank_account_number = UserBank::find($r['bankid'])->account_number;
        } else {
            $bank = new UserBank();
            $bank->user_id = Auth::id();
            $bank->bank_id = Bank::where('name', '=', $r['bank'])->first()->id;
            $bank->account_number = $r['bankacc'];
            $bank->save();

            $inv->seller_bank_id = $bank->id;
            $inv->seller_bank_account_number = $r['bankacc'];
        }

        if (isset($r['clientId']) && !empty($r['clientId'])) {
            $inv->client_id = $r['clientId'];
        } else {
            $client = new Client();
            $client->user_id = Auth::id();
            $client->name = $r['cname'];
            $client->address = $r['caddress'];
            $client->code = $r['code'];
            $client->vat_code = $r['vat_code'];
            $client->save();

            $inv->client_id = $client->id;
        }

        $inv->currency_id = $r['currency'];
        $inv->notes = $r['notes'];
        $inv->filename = date('YmdHi') . '_' . $request->post('type') . $request->post('seriesnr') . '.pdf';
        $inv->pay_date = $r['paytime'];
        $inv->save();

        foreach ($r['services'] as $key => $serv) {
            $s = new Service();
            $s->invoice_id = $inv->id;
            $s->name = $serv;
            $s->unit_id = Unit::where('sign', '=', $r['units'][$key])->first()->id;
            $s->quantity = $r['quantities'][$key];
            $s->price = $r['costs'][$key];
            $s->discount = $r['discounts'][$key];
            $s->discount_percent = $r['discountsp'][$key];
            $s->total_sum = (($r['quantities'][$key] * $r['costs'][$key]) * (1 - ($r['discountsp'][$key] / 100))) - $r['discounts'][$key];
            $s->save();
        }
        return redirect()->route('invoices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInvoiceRequest  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoices.index');
    }
}
