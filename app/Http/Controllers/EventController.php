<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EventController extends Controller
{
    public function index(): View
    {
        $upcoming = Event::query()
            ->published()
            ->upcoming()
            ->orderBy('starts_at')
            ->paginate(8);

        $past = Event::query()
            ->published()
            ->past()
            ->latest('starts_at')
            ->limit(6)
            ->get();

        return view('events.index', [
            'upcoming' => $upcoming,
            'past' => $past,
        ]);
    }

    public function show(Event $event): View
    {
        if (! $event->is_published) {
            throw new NotFoundHttpException;
        }

        $otherEvents = Event::query()
            ->published()
            ->upcoming()
            ->whereKeyNot($event->getKey())
            ->orderBy('starts_at')
            ->limit(2)
            ->get();

        return view('events.show', [
            'event' => $event,
            'otherEvents' => $otherEvents,
        ]);
    }
}
