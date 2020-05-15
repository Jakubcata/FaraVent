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
