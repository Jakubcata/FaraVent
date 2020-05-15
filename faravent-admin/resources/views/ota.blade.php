@extends('layout')
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="main-card mb-3 card">
            <div class="card-body">
                @include('ota.binaries')
            </div>
        </div>
    </div>
    <div class="col-md-6">

    </div>
</div>
@endsection
