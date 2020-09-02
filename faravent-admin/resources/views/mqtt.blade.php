@extends('layout')
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="main-card mb-3 card">
            <div class="card-body">
                @include('mqtt.server_info')
            </div>
        </div>
        <div class="main-card mb-3 card">
            <div class="card-body">
                @include('mqtt.last_messages_chart')
            </div>
        </div>
        <div class="main-card mb-3 card">
            <div class="card-body">
                @include('mqtt.sensor_values_chart',["chartName"=>"Temperature","chart"=>$temperatureChart])
            </div>
        </div>
        <div class="main-card mb-3 card">
            <div class="card-body">
                @include('mqtt.sensor_values_chart',["chartName"=>"Movement","chart"=>$movementChart])
            </div>
        </div>
        <div class="main-card mb-3 card">
            <div class="card-body">
                @include('mqtt.sensor_values_chart',["chartName"=>"Humidity","chart"=>$humidityChart])
            </div>
        </div>
        <div class="main-card mb-3 card">
            <div class="card-body">
                @include('mqtt.sensor_values_chart',["chartName"=>"Signal","chart"=>$signalChart])
            </div>
        </div>
        <div class="main-card mb-3 card">
            <div class="card-body">
                @include('mqtt.topics')
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="main-card mb-3 card">
            <div class="card-body">
                @include('mqtt.send_message')
            </div>
        </div>
        <div class="main-card mb-3 card">
            <div class="card-body">
                @include('mqtt.messages',['messagesUrl'=>route('lastMessagesSnippet')])
            </div>
        </div>
    </div>
</div>
@endsection
