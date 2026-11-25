New sponsorship enquiry

Name: {{ $enquiry->full_name }}
Email: {{ $enquiry->email }}
Phone: {{ $enquiry->phone ?: 'Not provided' }}
Country: {{ $enquiry->country ?: 'Not provided' }}
Preferred child age: {{ $enquiry->preferred_child_age ?: 'No preference' }}
Received: {{ $enquiry->created_at?->format('j F Y, H:i') }}

Message:
{{ $enquiry->message ?: 'No message provided.' }}
