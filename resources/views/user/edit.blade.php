@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Keisti duomenis</div>
                    <div class="card-body">
                        @if($details != null)
                            <form class="form" method="post" action="{{ route('userDetails.update', $details->user_id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <input type="text" name="phone" class="form-control" value="{{ $details->phone }}">
                                    <input type="text" name="address" class="form-control" value="{{ $details->address }}">
                                    <input type="text" name="pcode" class="form-control" value="{{ $details->personal_code }}">
                                    <input type="text" name="iacode" class="form-control" value="{{ $details->ia_certificate_id }}">
                                    <input type="submit" value="Išsaugoti" class="btn btn-primary">
                                </div>
                            </form>
                        @else
                            <form class="form" method="post" action="{{ route('userDetails.store') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="phone" class="form-control" placeholder="Tel. nr. (+370...)">
                                    <input type="text" name="address" class="form-control" placeholder="Adresas">
                                    <input type="text" name="pcode" class="form-control" placeholder="Asmens kodas">
                                    <input type="text" name="iacode" class="form-control" placeholder="I.V. pažymos nr.">
                                    <input type="submit" value="Išsaugoti" class="btn btn-primary">
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
