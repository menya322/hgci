<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\DonationPledge;
use App\Models\Event;
use App\Models\Post;
use App\Models\Program;
use App\Models\SponsorshipEnquiry;
use App\Models\VolunteerApplication;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'posts' => Post::query()->count(),
                'publishedPosts' => Post::query()->published()->count(),
                'programs' => Program::query()->count(),
                'upcomingEvents' => Event::query()->upcoming()->count(),
                'newEnquiries' => SponsorshipEnquiry::query()->where('status', 'new')->count(),
                'pendingPledges' => DonationPledge::query()->where('status', 'pending')->count(),
                'newApplications' => VolunteerApplication::query()->where('status', 'new')->count(),
                'unreadMessages' => ContactMessage::query()->whereNull('read_at')->count(),
            ],
            'recentPosts' => Post::query()->latest('id')->limit(5)->get(),
        ]);
    }
}
