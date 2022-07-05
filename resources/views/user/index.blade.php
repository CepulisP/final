@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">Jūsų duomenys</div>
                    @if(!empty($details))

                            <div class="card-body">
                                <ul>
                                    <li>Varda, Pavardė: {{ $user->name }}</li>
                                    <li>El. paštas: {{ $user->email }}</li>
                                    <li>Tel. Nr.: {{ $details->phone }}</li>
                                    <li>Adresas: {{ $details->address }}</li>
                                    <li>Asmens kodas: {{ $details->personal_code }}</li>
                                    <li>I.V. pažymos nr.: {{ $details->ia_certificate_id }}</li>
                                </ul>
                                <a href="{{ route('userDetails.edit', auth()->id()) }}">Keisti duomenis</a>
                    @else
                        <div class="col-md-12 mt-5 text-start">
                            Dar neužpildėte savo duomenų, tai galite padaryti
                            <a href="{{ route('userDetails.edit', auth()->id()) }}">čia.</a>
                        </div>
                    @endif
                </div>
            </div>
            <h3 class="mt-5">Bankai</h3>
            @if(!empty($banks[0]))
                <table class="table table-light mt-5">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Bankas</th>
                        <th scope="col">Sąskaitos nr.</th>
                        <th scope="col">Trinti</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($banks as $key => $bank)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $bank->bank->name }}</td>
                            <td>{{ $bank->account_number }}</td>
                            <form method="POST" action="{{ route('userBanks.destroy', $bank->id) }}">
                                @csrf
                                @method('DELETE')
                                <td><input type="submit" value="Trinti"></td>
                            </form>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="col-md-12">
                    <a href="{{ route('userBanks.create') }}" class="btn btn-success pull-right">Pridėti naują</a>
                </div>
            @else
                <div class="col-md-12 mt-5 mb-5 text-start">
                    Dar neužpildėte savo duomenų, tai galite padaryti
                    <a href="{{ route('userBanks.create') }}">čia.</a>
                </div>
            @endif
            <h3 class="mt-5">Klientai</h3>
            @if(!empty($clients[0]))
                <table class="table table-light mt-5">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Pavadinimas/Vardas,pavardė</th>
                        <th scope="col">Adresas</th>
                        <th scope="col">Kodas</th>
                        <th scope="col">PVM kodas</th>
                        <th scope="col">Trinti</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $key => $client)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->address }}</td>
                                <td>{{ $client->code }}</td>
                                <td>{{ $client->vat_code }}</td>
                                <form method="POST" action="{{ route('clients.destroy', $client->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <td><input type="submit" value="Trinti"></td>
                                </form>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-md-12">
                    <a href="{{ route('clients.create') }}" class="btn btn-success pull-right">Pridėti naują</a>
                </div>
            @else
                <div class="col-md-12 mt-5 text-start">
                    Dar neužpildėte savo duomenų, tai galite padaryti
                    <a href="{{ route('clients.create') }}">čia.</a>
                </div>
            @endif
        </div>
    </div>
@endsection
