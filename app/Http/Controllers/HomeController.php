<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Post;
use App\Models\Program;
use App\Models\Project;
use App\Models\Setting;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $settings = Setting::allKeyed();

        $programs = Program::query()
            ->published()
            ->ordered()
            ->limit(5)
            ->get();

        $projects = Project::query()
            ->published()
            ->ordered()
            ->limit(4)
            ->get();

        $featuredPost = Post::query()
            ->published()
            ->featured()
            ->latest('published_at')
            ->first()
            ?? Post::query()->published()->latest('published_at')->first();

        $latestPosts = Post::query()
            ->published()
            ->latest('published_at')
            ->limit(3)
            ->get();

        $upcomingEvents = Event::query()
            ->published()
            ->upcoming()
            ->orderBy('starts_at')
            ->limit(2)
            ->get();

        return view('home', [
            'settings' => $settings,
            'programs' => $programs,
            'projects' => $projects,
            'featuredPost' => $featuredPost,
            'latestPosts' => $latestPosts,
            'upcomingEvents' => $upcomingEvents,
        ]);
    }
}
