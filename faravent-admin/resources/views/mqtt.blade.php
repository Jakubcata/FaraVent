@extends('layout')
@section('content')
<div class="row">
    <div class="col-md-6">
        @include('mqtt.messages_graph')

        @include('mqtt.topics')

        @include('mqtt.devices')

        @include('mqtt.binaries')
    </div>

    <div class="col-md-6">
        @include('mqtt.messages')
    </div>

</div>
@endsection
