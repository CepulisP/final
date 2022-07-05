@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card ctnr bggreen">
                <p class="bigtext">EasyInvoice - tai nemokamas sąskaitų faktūrų kūrimų portalas</p>
            </div>
        </div>
        <div class="col-md-5 xfg szsz">
            <div class="card ctnr szsz">
                <p>Kurkite naują sąskaitą jau dabar</p>
                <a href="{{ route('invoices.create') }}" class="btn btn-success zzz">Nauja sąskaita</a>
            </div>
        </div>
        <div class="col-md-5 xfg szsz">
            <div class="card ctnr szsz">
                <p>Prisijunkite ir gaukite galimybę išsisaugoti duomenis, klientus ir sąskaitas</p>
                <div class="cust">
                    <a href="{{ route('login') }}" class="btn btn-success zzz">Prisijungti</a>
                    <a href="{{ route('register') }}" class="btn btn-primary zzz">Registruotis</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
