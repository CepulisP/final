<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Invoice;
use App\Models\InvoiceType;
use App\Models\Service;
use App\Models\UserBank;
use Illuminate\Http\Request;
use TCPDF;

class InvoiceGeneratorController
{
    private $pdf;

    public function __construct()
    {
        $this->pdf = new TCPDF();
    }

    private function prepare(Request $request)
    {
        $r = $request->post();
        $html = '';

//        if (isset($r['icon']) && !empty($r['icon'])) {
//            $html .= '<img src="' . storage_path('app\public\icons\\') . $r['icon'] . '" width="50" height="auto"/>';
//        }

        $r['type'] = InvoiceType::find($r['type'])->name;

        $html .= '
            <h1 style="text-align: center">' . $r['type'] . '</h1>
            <p style="text-align: center">Serija ' . $r['series'] . ' Nr. ' . $r['seriesnr'] . '</p>
            <p style="text-align: center">' . $r['date'] . '</p>
            <table>
                <tr>
                    <td>
                        <h2>Pardavėjas</h2>
                        <p>' . $r['name'] . '</p>
                        <p>' . $r['address'] . '</p>
                        <p>' . $r['phone'] . '</p>
        ';

        if (isset($r['ak']) && !empty($r['ak'])) {
            $html .= '<p>A.K.: ' . $r['ak'] . '</p>';
        }

        if (isset($r['ivnr']) && !empty($r['ivnr'])) {
            $html .= '<p>Individualios veiklos pažymos nr.: ' . $r['ivnr'] . '</p>';
        }

        if (isset($r['bankid']) && !empty($r['bankid'])) {
            $bank = UserBank::find($r['bankid']);
            $html .= '<p>A.S.: ' . $bank->bank->name . ' ' . $bank->account_number . '</p>';
        } else {
            $html .= '<p>A.S.: ' . $r['bank'] . ' ' . $r['bankacc'] . '</p>';
        }

        if (isset($r['clientId']) && !empty($r['clientId'])) {
            $client = Client::find($r['clientId']);
            $r['cname'] = $client->name;
            $r['caddress'] = $client->address;
            $r['code'] = $client->code;
            $r['vcode'] = $client->vat_code;
        }

        $html .= '
                    </td>
                    <td>
                        <h2>Pirkėjas</h2>
                        <p>' . $r['cname'] . '</p>
                        <p>' . $r['caddress'] . '</p>
                        <p>Kodas: ' . $r['code'] . '</p>
                        <p>PVM kodas: ' . $r['vcode'] . '</p>
                    </td>
                </tr>
            </table>
            <h2 style="text-align: start">Paslaugos</h2>
            <table style="border: 1px solid black">
            <tr style="font-weight: bold;">
                <th style="width: 5%">#</th>
                <th style="width: 35%">Paslauga</th>
                <th style="width: 8%">Matas</th>
                <th style="width: 10%">Kiekis</th>
                <th style="width: 10%">Kaina</th>
                <th style="width: 11%">Nuolaida</th>
                <th style="width: 13%">Nuolaida (%)</th>
                <th style="width: 8%">Suma</th>
            </tr>
        ';

        $r['currency'] = Currency::find($r['currency'])->sign;

        foreach ($r['services'] as $key => $service) {
            $html .= "
                <tr>
                    <td>" . $key + 1 . ".</td>
                    <td>$service</td>
                    <td>{$r['units'][$key]}</td>
                    <td>{$r['quantities'][$key]}</td>
                    <td>{$r['costs'][$key]}{$r['currency']}</td>
                    <td>{$r['discounts'][$key]}{$r['currency']}</td>
                    <td>{$r['discountsp'][$key]}%</td>
                    <td>" . $total[$key] = (($r['quantities'][$key] * $r['costs'][$key])
                        * (1 - ($r['discountsp'][$key] / 100)))
                        - $r['discounts'][$key] . $r['currency'] .
                        "</td>
                </tr>
            ";
        }

        $html .= '
            </table>
            <p style="text-align: right"><b>Bendra suma: </b>' . array_sum($total) . $r['currency'] . '</p>
            <p>Sąskaitą apmokėti iki: ' . $r['paytime'] . '</p>
            <h3>Pastabos</h3>
            <p>' . $r['notes'] . '</p>
        ';

        $this->pdf->SetPrintHeader(false);
        $this->pdf->SetMargins(10, 20);
        $this->pdf->SetFont("dejavusans", "", 10, "", false);
        $this->pdf->AddPage();
        $this->pdf->writeHTML($html);
    }

    public function prepareById($id)
    {
        $inv = Invoice::find($id);
        $serv = Service::where('invoice_id', '=', $id)->get();
        $html = '';

        $html .= '
            <h1 style="text-align: center">' . $inv->type->name . '</h1>
            <p style="text-align: center">Serija ' . $inv->series . ' Nr. ' . $inv->serial_number . '</p>
            <p style="text-align: center">' . $inv->date . '</p>
            <table>
                <tr>
                    <td>
                        <h2>Pardavėjas</h2>
                        <p>' . $inv->seller_name . '</p>
                        <p>' . $inv->seller_address . '</p>
                        <p>' . $inv->seller_phone . '</p>
                    </td>
                    <td>
                        <h2>Pirkėjas</h2>
                        <p>' . $inv->client->name . '</p>
                        <p>' . $inv->client->address . '</p>
                        <p>Kodas: ' . $inv->client->code . '</p>
                        <p>PVM kodas: ' . $inv->client->vat_code . '</p>
                    </td>
                </tr>
            </table>
            <h2 style="text-align: start">Paslaugos</h2>
            <table style="border: 1px solid black">
            <tr style="font-weight: bold;">
                <th style="width: 5%">#</th>
                <th style="width: 35%">Paslauga</th>
                <th style="width: 8%">Matas</th>
                <th style="width: 10%">Kiekis</th>
                <th style="width: 10%">Kaina</th>
                <th style="width: 11%">Nuolaida</th>
                <th style="width: 13%">Nuolaida (%)</th>
                <th style="width: 8%">Suma</th>
            </tr>
        ';

        foreach ($serv as $key => $service) {
            $html .= "
                <tr>
                    <td>" . $key + 1 . ".</td>
                    <td>$service->name</td>
                    <td>{$service->unit->sign}</td>
                    <td>$service->quantity</td>
                    <td>" . $service->price . $inv->currency->sign . "</td>
                    <td>" . $service->discount . $inv->currency->sign . "</td>
                    <td>{$service->discount_percent}%</td>
                    <td>" . $total[$key] = $service->total_sum . "</td>
                </tr>
            ";
        }

        $html .= '
            </table>
            <p style="text-align: right"><b>Bendra suma: </b>' . array_sum($total) . $inv->currency->sign . '</p>
            <p>Sąskaitą apmokėti iki: ' . $inv->paydate . '</p>
            <h3>Pastabos</h3>
            <p>' . $inv->notes . '</p>
        ';

        $this->pdf->SetPrintHeader(false);
        $this->pdf->SetMargins(10, 20);
        $this->pdf->SetFont("dejavusans", "", 10, "", false);
        $this->pdf->AddPage();
        $this->pdf->writeHTML($html);

        return $inv->filename;
    }

    public function generate(Request $request)
    {
        $this->prepare($request);

        $this->pdf->Output(
            date('YmdHi') . '_' . $request->post('series') . $request->post('seriesnr') . '.pdf'
        );
    }

    public function download(Request $request)
    {
        $this->prepare($request);

        $this->pdf->Output(
            date('YmdHi') . '_' . $request->post('type') . $request->post('seriesnr') . '.pdf',
            'D'
        );
    }

    public function load($id)
    {
        $filename = $this->prepareById($id);

        $this->pdf->Output($filename);
    }

    public function redownload($id)
    {
        $filename = $this->prepareById($id);

        $this->pdf->Output($filename,'D');
    }
}
