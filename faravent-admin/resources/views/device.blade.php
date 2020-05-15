@extends('layout')
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="main-card mb-3 card">
            <div class="card-body">
                @include('devices.basic_info')
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="main-card mb-3 card">
            <div class="card-body">
                @include('mqtt.messages',['messagesUrl'=>route('deviceLastMessagesSnippet',['id'=>$device->id]), 'lastMessages'=>$device->lastMessages()])
            </div>
        </div>
    </div>
</div>
@endsection
