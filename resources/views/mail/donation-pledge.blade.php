New donation pledge

Name: {{ $pledge->name }}
Email: {{ $pledge->email }}
Phone: {{ $pledge->phone ?: 'Not provided' }}
Amount: {{ number_format((float) $pledge->amount, 0) }} {{ $pledge->currency }}
Frequency: {{ ucfirst(str_replace('_', ' ', $pledge->frequency)) }}
Preferred method: {{ $pledge->method ? ucfirst(str_replace('_', ' ', $pledge->method)) : 'Not specified' }}
Received: {{ $pledge->created_at?->format('j F Y, H:i') }}

Message:
{{ $pledge->message ?: 'No message provided.' }}
