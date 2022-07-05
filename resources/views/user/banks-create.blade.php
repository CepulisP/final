@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Pridėti banką</div>
                    <div class="card-body">
                        <form class="form" method="post" action="{{ route('userBanks.store') }}">
                            @csrf
                            <div class="form-group">
                                <select name="bank_id">
                                    @foreach($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                    @endforeach
                                </select>
                                <input type="text" name="account_number" class="form-control" placeholder="Sąskaitos numeris">
                                <input type="submit" value="Pridėti" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
