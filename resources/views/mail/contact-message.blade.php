New contact message

Name: {{ $contactMessage->name }}
Email: {{ $contactMessage->email }}
Phone: {{ $contactMessage->phone ?: 'Not provided' }}
Subject: {{ ucfirst(str_replace('_', ' ', $contactMessage->subject)) }}
Received: {{ $contactMessage->created_at?->format('j F Y, H:i') }}

Message:
{{ $contactMessage->message }}
