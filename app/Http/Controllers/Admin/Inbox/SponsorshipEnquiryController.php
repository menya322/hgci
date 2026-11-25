<?php

namespace App\Http\Controllers\Admin\Inbox;

use App\Models\SponsorshipEnquiry;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SponsorshipEnquiryController extends InboxController
{
    public function index(Request $request): View
    {
        return $this->listRecords($request);
    }

    public function export(Request $request): StreamedResponse
    {
        $records = $this->filteredQuery($request)->get();

        return response()->streamDownload(function () use ($records): void {
            $handle = fopen('php://output', 'w');

            if ($handle === false) {
                return;
            }

            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'ID',
                'First name',
                'Last name',
                'Email',
                'Phone',
                'Country',
                'Preferred child age',
                'Message',
                'Consent to contact',
                'Status',
                'Received at',
                'Read at',
            ], ',', '"', '');

            foreach ($records as $record) {
                fputcsv($handle, [
                    $record->id,
                    $record->first_name,
                    $record->last_name,
                    $record->email,
                    $record->phone,
                    $record->country,
                    $record->preferred_child_age,
                    $record->message,
                    $record->consent ? 'Yes' : 'No',
                    Str::headline($record->status),
                    $record->created_at?->format('Y-m-d H:i:s'),
                    $record->read_at?->format('Y-m-d H:i:s'),
                ], ',', '"', '');
            }

            fclose($handle);
        }, 'sponsorship-enquiries-'.now()->format('Y-m-d').'.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function show(SponsorshipEnquiry $enquiry): View
    {
        return $this->showRecord($enquiry);
    }

    public function markAsRead(SponsorshipEnquiry $enquiry): RedirectResponse
    {
        return $this->markRecordAsRead($enquiry);
    }

    public function destroy(SponsorshipEnquiry $enquiry): RedirectResponse
    {
        return $this->deleteRecord($enquiry);
    }

    protected function query(): Builder
    {
        return SponsorshipEnquiry::query();
    }

    protected function searchColumns(): array
    {
        return ['first_name', 'last_name', 'email', 'country', 'message'];
    }

    protected function routePrefix(): string
    {
        return 'admin.enquiries';
    }

    protected function exportRoute(): ?string
    {
        return 'admin.enquiries.export';
    }

    protected function heading(): string
    {
        return 'Sponsorship enquiries';
    }

    protected function description(): string
    {
        return 'People asking about sponsoring a child through HGCI.';
    }

    protected function emptyMessage(): string
    {
        return 'No sponsorship enquiries have arrived yet.';
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
            'summary' => trim(($record->country ?: 'Country not given').' · Age preference: '.($record->preferred_child_age ?: 'Not given')),
            'received_at' => $record->created_at,
            'read_at' => $record->read_at,
            'show_url' => route('admin.enquiries.show', $record),
            'delete_url' => route('admin.enquiries.destroy', $record),
        ];
    }

    protected function detailFields(Model $record): array
    {
        return [
            ['label' => 'Email', 'value' => $record->email, 'href' => 'mailto:'.$record->email],
            ['label' => 'Phone', 'value' => $record->phone, 'href' => $record->phone ? 'tel:'.$record->phone : null],
            ['label' => 'Country', 'value' => $record->country],
            ['label' => 'Preferred child age', 'value' => $record->preferred_child_age],
            ['label' => 'Status', 'value' => Str::headline($record->status)],
            ['label' => 'Consent to contact', 'value' => $record->consent ? 'Yes' : 'No'],
            ['label' => 'Message', 'value' => $record->message, 'block' => true],
        ];
    }
}
