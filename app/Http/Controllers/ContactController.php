<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Mail\NewContactMessage;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function __invoke(): View
    {
        return view('contact', [
            'settings' => Setting::allKeyed(),
        ]);
    }

    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('website');
        $data['status'] = 'new';

        $contactMessage = ContactMessage::create($data);

        Mail::to(Setting::adminEmail())->send(new NewContactMessage($contactMessage));

        return back()->with(
            'status',
            'Thank you for contacting HGCI. Our team will respond as soon as possible.',
        );
    }
}
