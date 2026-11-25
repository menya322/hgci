<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\StoresImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeamMemberRequest;
use App\Models\TeamMember;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TeamMemberController extends Controller
{
    use StoresImages;

    public function index(): View
    {
        return view('admin.team.index', [
            'members' => TeamMember::query()->ordered()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.team.create', [
            'member' => new TeamMember(['is_published' => true, 'sort_order' => 0]),
        ]);
    }

    public function store(TeamMemberRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['photo'] = $this->storeImage($request, 'photo', 'team');

        $member = TeamMember::create($data);

        return redirect()
            ->route('admin.team.edit', $member)
            ->with('status', 'Team member created.');
    }

    public function edit(TeamMember $member): View
    {
        return view('admin.team.edit', [
            'member' => $member,
        ]);
    }

    public function update(TeamMemberRequest $request, TeamMember $member): RedirectResponse
    {
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['photo'] = $this->storeImage($request, 'photo', 'team', $member->photo);

        $member->update($data);

        return redirect()
            ->route('admin.team.edit', $member)
            ->with('status', 'Team member updated.');
    }

    public function destroy(TeamMember $member): RedirectResponse
    {
        $member->delete();

        return redirect()
            ->route('admin.team.index')
            ->with('status', 'Team member moved to the trash.');
    }
}
