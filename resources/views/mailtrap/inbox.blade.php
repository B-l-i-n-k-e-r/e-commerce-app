@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mailtrap Inbox</h2>

    <div class="mb-3">
        <a href="{{ route('mailtrap.inbox') }}" class="btn btn-primary">View Inbox (HTML)</a>
        <a href="{{ route('mailtrap.api.inbox') }}" class="btn btn-secondary" target="_blank">View Inbox (JSON)</a>
    </div>

    @if(!empty($messages) && count($messages) > 0)
        <ul class="list-group">
            @foreach($messages as $message)
                <li class="list-group-item">
                    <strong>Subject:</strong> {{ $message['subject'] ?? 'No subject' }}<br>
                    <strong>From:</strong> {{ $message['from_email'] ?? 'Unknown sender' }}<br>
                    <strong>Date:</strong> {{ $message['created_at'] ?? 'Unknown date' }}
                </li>
            @endforeach
        </ul>
    @else
        <p>No messages found.</p>
    @endif
</div>
@endsection
