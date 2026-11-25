<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonationPledgeRequest;
use App\Mail\NewDonationPledge;
use App\Models\DonationPledge;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class DonateController extends Controller
{
    public function __invoke(): View
    {
        $settings = Setting::allKeyed();

        return view('donate', [
            'settings' => $settings,
        ]);
    }

    public function store(StoreDonationPledgeRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('website');
        $data['currency'] = 'UGX';
        $data['status'] = 'pending';

        $pledge = DonationPledge::create($data);

        Mail::to(Setting::adminEmail())->send(new NewDonationPledge($pledge));

        return back()->with(
            'status',
            'Thank you for your pledge. Our team will contact you with the payment details and next steps.',
        );
    }
}
