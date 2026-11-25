<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProgramRequest;
use App\Models\Program;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{
    public function index(): View
    {
        return view('admin.programs.index', [
            'programs' => Program::query()->ordered()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.programs.create', [
            'program' => new Program(['is_published' => true, 'sort_order' => 0]),
        ]);
    }

    public function store(ProgramRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['image'] = $this->storeImage($request);

        $program = Program::create($data);

        return redirect()
            ->route('admin.programs.edit', $program)
            ->with('status', 'Program created.');
    }

    public function edit(Program $program): View
    {
        return view('admin.programs.edit', [
            'program' => $program,
        ]);
    }

    public function update(ProgramRequest $request, Program $program): RedirectResponse
    {
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['image'] = $this->storeImage($request, $program->image);

        $program->update($data);

        return redirect()
            ->route('admin.programs.edit', $program)
            ->with('status', 'Program updated.');
    }

    public function destroy(Program $program): RedirectResponse
    {
        $program->delete();

        return redirect()
            ->route('admin.programs.index')
            ->with('status', 'Program moved to the trash.');
    }

    private function storeImage(ProgramRequest $request, ?string $existing = null): ?string
    {
        if (! $request->hasFile('image')) {
            return $existing;
        }

        $path = $request->file('image')->store('programs', 'public');

        if ($existing) {
            Storage::disk('public')->delete($existing);
        }

        return $path;
    }
}
