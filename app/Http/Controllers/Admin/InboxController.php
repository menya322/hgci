<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\DonationPledge;
use App\Models\SponsorshipEnquiry;
use App\Models\VolunteerApplication;
use Illuminate\Contracts\View\View;

class InboxController extends Controller
{
    public function __invoke(): View
    {
        $items = [
            [
                'label' => 'Contact messages',
                'description' => 'Questions and notes sent through the contact form.',
                'route' => 'admin.messages.index',
                'total' => ContactMessage::query()->count(),
                'unread' => ContactMessage::query()->whereNull('read_at')->count(),
                'icon' => 'envelope',
            ],
            [
                'label' => 'Sponsorship enquiries',
                'description' => 'People asking about sponsoring a child.',
                'route' => 'admin.enquiries.index',
                'total' => SponsorshipEnquiry::query()->count(),
                'unread' => SponsorshipEnquiry::query()->whereNull('read_at')->count(),
                'icon' => 'heart',
            ],
            [
                'label' => 'Donation pledges',
                'description' => 'Giving pledges recorded from the donate page.',
                'route' => 'admin.pledges.index',
                'total' => DonationPledge::query()->count(),
                'unread' => DonationPledge::query()->whereNull('read_at')->count(),
                'icon' => 'gift',
            ],
            [
                'label' => 'Volunteer applications',
                'description' => 'People offering their time and skills.',
                'route' => 'admin.applications.index',
                'total' => VolunteerApplication::query()->count(),
                'unread' => VolunteerApplication::query()->whereNull('read_at')->count(),
                'icon' => 'users',
            ],
        ];

        return view('admin.inbox.index', [
            'items' => $items,
            'unreadTotal' => array_sum(array_column($items, 'unread')),
        ]);
    }
}
