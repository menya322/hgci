<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Setting;
use Illuminate\Contracts\View\View;

class ImpactController extends Controller
{
    public function __invoke(): View
    {
        $settings = Setting::allKeyed();

        $projects = Project::query()
            ->published()
            ->ordered()
            ->with('program')
            ->get();

        return view('impact', [
            'settings' => $settings,
            'projects' => $projects,
        ]);
    }
}
