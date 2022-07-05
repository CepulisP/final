@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Pridėti klientą</div>
                    <div class="card-body">
                        <form class="form" method="post" action="{{ route('clients.store') }}">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Pavadinimas/Vardas,pavardė">
                                <input type="text" name="address" class="form-control" placeholder="Adresas">
                                <input type="text" name="code" class="form-control" placeholder="Kodas">
                                <input type="text" name="vat_code" class="form-control" placeholder="PVM kodas">
                                <input type="submit" value="Pridėti" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
