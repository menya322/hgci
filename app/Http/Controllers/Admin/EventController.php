<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\StoresImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventRequest;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class EventController extends Controller
{
    use StoresImages;

    public function index(): View
    {
        return view('admin.events.index', [
            'events' => Event::query()->orderByDesc('starts_at')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.events.create', [
            'event' => new Event(['is_published' => true]),
        ]);
    }

    public function store(EventRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published');
        $data['image'] = $this->storeImage($request, 'image', 'events');

        $event = Event::create($data);

        return redirect()
            ->route('admin.events.edit', $event)
            ->with('status', 'Event created.');
    }

    public function edit(Event $event): View
    {
        return view('admin.events.edit', [
            'event' => $event,
        ]);
    }

    public function update(EventRequest $request, Event $event): RedirectResponse
    {
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published');
        $data['image'] = $this->storeImage($request, 'image', 'events', $event->image);

        $event->update($data);

        return redirect()
            ->route('admin.events.edit', $event)
            ->with('status', 'Event updated.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Event moved to the trash.');
    }
}
