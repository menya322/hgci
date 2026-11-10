<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\TeamMember;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    public function __invoke(): View
    {
        $settings = Setting::allKeyed();

        $teamMembers = TeamMember::query()
            ->published()
            ->ordered()
            ->get();

        return view('about', [
            'settings' => $settings,
            'teamMembers' => $teamMembers,
        ]);
    }
}
