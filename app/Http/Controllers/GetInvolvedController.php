<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVolunteerApplicationRequest;
use App\Mail\NewVolunteerApplication;
use App\Models\Setting;
use App\Models\VolunteerApplication;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class GetInvolvedController extends Controller
{
    public function __invoke(): View
    {
        return view('get-involved', [
            'settings' => Setting::allKeyed(),
        ]);
    }

    public function store(StoreVolunteerApplicationRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('website');
        $data['status'] = 'new';

        $application = VolunteerApplication::create($data);

        Mail::to(Setting::adminEmail())->send(new NewVolunteerApplication($application));

        return back()->with(
            'status',
            'Thank you for offering your time. Our team will review your application and get in touch.',
        );
    }
}
