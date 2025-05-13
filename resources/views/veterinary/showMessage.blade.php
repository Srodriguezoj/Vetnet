@extends('layouts.app-admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4>{{ $message->title }}</h4>
            <small class="subtitleText">
                {{ $message->client->name }} 
                <br/>
                 {{ $message->date }} | {{ $message->time }}
            </small>
        </div>
        <div class="card-body">
            <p>{{ $message->subject }}</p>
        </div>
    </div>
</div>
@endsection
