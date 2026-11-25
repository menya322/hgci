<?php

namespace App\Http\Controllers\Admin\Inbox;

use App\Models\VolunteerApplication;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VolunteerApplicationController extends InboxController
{
    public function index(Request $request): View
    {
        return $this->listRecords($request);
    }

    public function show(VolunteerApplication $application): View
    {
        return $this->showRecord($application);
    }

    public function markAsRead(VolunteerApplication $application): RedirectResponse
    {
        return $this->markRecordAsRead($application);
    }

    public function destroy(VolunteerApplication $application): RedirectResponse
    {
        return $this->deleteRecord($application);
    }

    protected function query(): Builder
    {
        return VolunteerApplication::query();
    }

    protected function searchColumns(): array
    {
        return ['first_name', 'last_name', 'email', 'location', 'skills', 'availability', 'motivation'];
    }

    protected function routePrefix(): string
    {
        return 'admin.applications';
    }

    protected function heading(): string
    {
        return 'Volunteer applications';
    }

    protected function description(): string
    {
        return 'People offering their time and skills to HGCI.';
    }

    protected function emptyMessage(): string
    {
        return 'No volunteer applications have arrived yet.';
    }

    protected function recordName(Model $record): string
    {
        return $record->full_name;
    }

    protected function row(Model $record): array
    {
        return [
            'name' => $record->full_name,
            'email' => $record->email,
            'summary' => trim(($record->location ?: 'Location not given').' · '.($record->availability ?: 'Availability not given')),
            'received_at' => $record->created_at,
            'read_at' => $record->read_at,
            'show_url' => route('admin.applications.show', $record),
            'delete_url' => route('admin.applications.destroy', $record),
        ];
    }

    protected function detailFields(Model $record): array
    {
        return [
            ['label' => 'Email', 'value' => $record->email, 'href' => 'mailto:'.$record->email],
            ['label' => 'Phone', 'value' => $record->phone, 'href' => $record->phone ? 'tel:'.$record->phone : null],
            ['label' => 'Location', 'value' => $record->location],
            ['label' => 'Availability', 'value' => $record->availability],
            ['label' => 'Status', 'value' => Str::headline($record->status)],
            ['label' => 'Consent to contact', 'value' => $record->consent ? 'Yes' : 'No'],
            ['label' => 'Skills', 'value' => $record->skills, 'block' => true],
            ['label' => 'Motivation', 'value' => $record->motivation, 'block' => true],
        ];
    }
}
