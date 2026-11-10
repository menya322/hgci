<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProgramController extends Controller
{
    public function index(): View
    {
        $programs = Program::query()
            ->published()
            ->ordered()
            ->get();

        $projects = Project::query()
            ->published()
            ->ordered()
            ->get();

        return view('programs.index', [
            'programs' => $programs,
            'projects' => $projects,
        ]);
    }

    public function show(Program $program): View
    {
        if (! $program->is_published) {
            throw new NotFoundHttpException;
        }

        $projects = $program->projects()
            ->published()
            ->ordered()
            ->get();

        $otherPrograms = Program::query()
            ->published()
            ->ordered()
            ->whereKeyNot($program->getKey())
            ->limit(3)
            ->get();

        return view('programs.show', [
            'program' => $program,
            'projects' => $projects,
            'otherPrograms' => $otherPrograms,
        ]);
    }
}
