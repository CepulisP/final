@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h3 class="mt-5">Mano sąskaitos</h3>
            @if(!empty($invoices[0]))
                <table class="table table-light mt-5">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Pavadinimas</th>
                        <th scope="col">Data</th>
                        <th scope="col">Peržiūrėti</th>
                        <th scope="col">Atsisiųsti</th>
                        <th scope="col">Trinti</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoices as $key => $invoice)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $invoice->filename }}</td>
                            <td>{{ $invoice->created_at }}</td>
                            <td><a href="{{ route('load', $invoice->id) }}">Peržiūrėti</a></td>
                            <td><a href="{{ route('redownload', $invoice->id) }}">Atsisiųsti</a></td>
                            <form method="POST" action="{{ route('invoices.destroy', $invoice->id) }}">
                                @csrf
                                @method('DELETE')
                                <td><input type="submit" value="Trinti"></td>
                            </form>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="col-md-12">
                    <a href="{{ route('invoices.create') }}" class="btn btn-success pull-right">Kurti naują</a>
                </div>
            @else
                <div class="col-md-12 mt-5 text-start">
                    Dar neturite išsaugotų sąskaitų, kurkite naują
                    <a href="{{ route('invoices.create') }}">čia.</a>
                </div>
            @endif
        </div>
    </div>
@endsection
