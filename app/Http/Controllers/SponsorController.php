<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSponsorshipEnquiryRequest;
use App\Mail\NewSponsorshipEnquiry;
use App\Models\Faq;
use App\Models\Setting;
use App\Models\SponsorshipEnquiry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class SponsorController extends Controller
{
    public function __invoke(): View
    {
        $settings = Setting::allKeyed();

        $faqs = Faq::query()
            ->published()
            ->ordered()
            ->where('category', 'sponsorship')
            ->get();

        return view('sponsor', [
            'settings' => $settings,
            'faqs' => $faqs,
        ]);
    }

    public function store(StoreSponsorshipEnquiryRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('website');
        $data['status'] = 'new';

        $enquiry = SponsorshipEnquiry::create($data);

        Mail::to(Setting::adminEmail())->send(new NewSponsorshipEnquiry($enquiry));

        return back()->with(
            'status',
            'Thank you for your sponsorship enquiry. Our team will contact you with the next steps.',
        );
    }
}
