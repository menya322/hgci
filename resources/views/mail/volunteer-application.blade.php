New volunteer application

Name: {{ $application->full_name }}
Email: {{ $application->email }}
Phone: {{ $application->phone ?: 'Not provided' }}
Location: {{ $application->location ?: 'Not provided' }}
Availability: {{ $application->availability ?: 'Not provided' }}
Received: {{ $application->created_at?->format('j F Y, H:i') }}

Skills:
{{ $application->skills ?: 'Not provided.' }}

Motivation:
{{ $application->motivation }}
