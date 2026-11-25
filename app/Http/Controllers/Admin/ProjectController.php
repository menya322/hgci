<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\StoresImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectRequest;
use App\Models\Program;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProjectController extends Controller
{
    use StoresImages;

    public function index(): View
    {
        return view('admin.projects.index', [
            'projects' => Project::query()->with('program')->ordered()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.projects.create', [
            'project' => new Project([
                'category' => 'livelihood',
                'is_published' => true,
                'sort_order' => 0,
            ]),
            'programs' => Program::query()->ordered()->pluck('title', 'id'),
        ]);
    }

    public function store(ProjectRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['category'] = ($data['category'] ?? null) ?: 'livelihood';
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['image'] = $this->storeImage($request, 'image', 'projects');

        $project = Project::create($data);

        return redirect()
            ->route('admin.projects.edit', $project)
            ->with('status', 'Project created.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.edit', [
            'project' => $project,
            'programs' => Program::query()->ordered()->pluck('title', 'id'),
        ]);
    }

    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $data = $request->validated();
        $data['category'] = ($data['category'] ?? null) ?: 'livelihood';
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['image'] = $this->storeImage($request, 'image', 'projects', $project->image);

        $project->update($data);

        return redirect()
            ->route('admin.projects.edit', $project)
            ->with('status', 'Project updated.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('status', 'Project moved to the trash.');
    }
}
