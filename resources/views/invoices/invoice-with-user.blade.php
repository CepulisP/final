@extends('layouts.app')

@section('content')
    <div class="container">
        <form id="invoice" method="POST" action="">
            @csrf
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <select name="type" class="form-control">
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        <div class="pull-right">
                            <label for="series">Serija </label>
                            <input type="text" id="series" name="series" placeholder="AAA">
                            <label for="seriesnr"> Nr. </label>
                            <input type="text" id="seriesnr" name="seriesnr" placeholder="00001">
                            <label for="date">Data </label>
                            <input type="date" id="date" name="date">
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <h3>Pardavėjas</h3>
                        @if(!empty($details))
                            <input type="text" name="name" id="name" class="form-control" required value="{{ auth()->user()->name }}">
                            <input type="text" name="address" id="address" class="form-control" required value="{{ $details->address }}">
                            <input type="text" name="phone" id="phone" class="form-control" required value="{{ $details->phone }}">
                            <input type="text" name="ak" id="ak" class="form-control" value="{{ $details->personal_code }}">
                            <input type="text" name="ivnr" id="ivnr" class="form-control" value="{{ $details->ia_certificate_id }}">
                        @else
                            <label for="name">Pavadinimas / Vardas, Pavardė: </label>
                            <input type="text" name="name" id="name" class="form-control" required>
                            <label for="address">Adresas: </label>
                            <input type="text" name="address" id="address" class="form-control" required>
                            <label for="phone">Telefono numeris: </label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                            <label for="ak">Asmens kodas: </label>
                            <input type="text" name="ak" id="ak" class="form-control">
                            <label for="ivnr">Individualios veiklos pažymos nr.:  </label>
                            <input type="text" name="ivnr" id="ivnr" class="form-control">
                        @endif
                        @if(!empty($userBanks[0]))
                            <label for="bank">Banko sąskaita: </label>
                            <select id="bank" name="bankid" class="form-control">
                                @foreach($userBanks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->account_number }}</option>
                                @endforeach
                            </select>
                        @else
                            <label for="bank">Bankas: </label>
                            <select id="bank" name="bank" class="form-control">
                                @foreach($banks as $bank)
                                    <option value="{{ $bank->name }}">{{ $bank->name }}</option>
                                @endforeach
                            </select>
                            <label for="bankacc">Sąskaitos numeris: </label>
                            <input type="text" name="bankacc" id="bankacc" class="form-control" required>
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <h3>Pirkėjas</h3>
                        @if(!empty($clients[0]))
                            <label for="client">Klientas: </label>
                            <select id="client" name="clientId" class="form-control">
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        @else
                            <label for="cname">Pavadinimas / Vardas, Pavardė: </label>
                            <input type="text" name="cname" id="cname" class="form-control" required>
                            <label for="caddress">Adresas: </label>
                            <input type="text" name="caddress" id="caddress" class="form-control" required>
                            <label for="code">Kodas: </label>
                            <input type="text" name="code" id="code" class="form-control" required>
                            <label for="vcode">PVM kodas: </label>
                            <input type="text" name="vcode" id="vcode" class="form-control" required>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <h3 class="card-title">Paslaugos</h3>
                        <label for="currency">Valiuta: </label>
                        <select id="currency" name="currency">
                            @foreach($currencies as $currency)
                                <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                            @endforeach
                        </select>
                        <table class="table table-bordered table-hover" id="tab_logic">
                            <col width="5%">
                            <col width="45%">
                            <col width="10%">
                            <col width="10%">
                            <col width="10%">
                            <col width="10%">
                            <thead>
                            <tr>
                                <th class="text-center"> # </th>
                                <th class="text-center"> Paslauga </th>
                                <th class="text-center"> Matas </th>
                                <th class="text-center"> Kiekis </th>
                                <th class="text-center"> Kaina </th>
                                <th class="text-center"> Nuolaida </th>
                                <th class="text-center"> Nuolaida (%) </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="addr0">
                                <td>1</td>
                                <td><input type="text" name='services[]' class="form-control"></td>
                                <td>
                                    <select name="units[]" class="form-control">
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->sign }}">{{ $unit->sign }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" name="quantities[]" class="form-control" step="0.01"></td>
                                <td><input type="number" name="costs[]" class="form-control" step="0.01"></td>
                                <td><input type="number" name='discounts[]' placeholder="0,00" class="form-control" step="0.01"></td>
                                <td><input type="number" name='discountsp[]' placeholder="0,0%" class="form-control" step="0.01"></td>
                            </tr>
                            <tr id="addr1"></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-12">
                    <button type="button" id='delete_row' class="pull-right btn btn-danger">-</button>
                    <button type="button" id="add_row" class="btn btn-success pull-right">+</button>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <label for="paytime">Sumokėti iki: </label>
                    <input type="date" id="paytime" name="paytime" class="form-control">
                </div>
                <div class="col-md-12">
                    <label for="notes" class="card-title">Pastabos: </label>
                    <textarea id="notes" name="notes" class="form-control"></textarea>
                </div>
            </div>
            <div class="col-md-12 text-center">
                <input type="button" value="Peržiūrėti" name="saved" onclick="view()" class="btn btn-primary">
                <input type="button" value="Atsisiųsti PDF" name="finished" onclick="download()" class="btn btn-danger">
                <input type="button" value="Išsaugoti" name="done" onclick="save()" class="btn btn-success">
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function(){
            var i=1;
            $("#add_row").click(function(){b=i-1;
                $('#addr'+i).html($('#addr'+b).html()).find('td:first-child').html(i+1);
                $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
                i++;
            });
            $("#delete_row").click(function(){
                if(i>1){
                    $("#addr"+(i-1)).html('');
                    i--;
                }
            });
        });

        form=document.getElementById("invoice");
        function view() {
            form.action="{{ route('generate') }}";
            form.submit();
        }
        function download() {
            form.action="{{ route('download') }}";
            form.submit();
        }
        function save() {
            form.action="{{ route('invoices.store') }}";
            form.submit();
        }
    </script>
@endsection
