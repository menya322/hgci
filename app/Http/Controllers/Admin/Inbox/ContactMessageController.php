<?php

namespace App\Http\Controllers\Admin\Inbox;

use App\Models\ContactMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactMessageController extends InboxController
{
    public function index(Request $request): View
    {
        return $this->listRecords($request);
    }

    public function show(ContactMessage $message): View
    {
        return $this->showRecord($message);
    }

    public function markAsRead(ContactMessage $message): RedirectResponse
    {
        return $this->markRecordAsRead($message);
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        return $this->deleteRecord($message);
    }

    protected function query(): Builder
    {
        return ContactMessage::query();
    }

    protected function searchColumns(): array
    {
        return ['name', 'email', 'subject', 'message'];
    }

    protected function routePrefix(): string
    {
        return 'admin.messages';
    }

    protected function heading(): string
    {
        return 'Contact messages';
    }

    protected function description(): string
    {
        return 'Questions and notes sent through the contact form.';
    }

    protected function emptyMessage(): string
    {
        return 'No contact messages have arrived yet.';
    }

    protected function recordName(Model $record): string
    {
        return $record->name;
    }

    protected function row(Model $record): array
    {
        return [
            'name' => $record->name,
            'email' => $record->email,
            'summary' => $record->subject ?: Str::limit($record->message, 80),
            'received_at' => $record->created_at,
            'read_at' => $record->read_at,
            'show_url' => route('admin.messages.show', $record),
            'delete_url' => route('admin.messages.destroy', $record),
        ];
    }

    protected function detailFields(Model $record): array
    {
        return [
            ['label' => 'Email', 'value' => $record->email, 'href' => 'mailto:'.$record->email],
            ['label' => 'Phone', 'value' => $record->phone, 'href' => $record->phone ? 'tel:'.$record->phone : null],
            ['label' => 'Subject', 'value' => $record->subject],
            ['label' => 'Status', 'value' => Str::headline($record->status)],
            ['label' => 'Message', 'value' => $record->message, 'block' => true],
        ];
    }
}
