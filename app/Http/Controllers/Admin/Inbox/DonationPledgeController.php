<?php

namespace App\Http\Controllers\Admin\Inbox;

use App\Models\DonationPledge;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DonationPledgeController extends InboxController
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
                'Name',
                'Email',
                'Phone',
                'Amount',
                'Currency',
                'Frequency',
                'Payment method',
                'Message',
                'Consent to contact',
                'Status',
                'Received at',
                'Read at',
            ], ',', '"', '');

            foreach ($records as $record) {
                fputcsv($handle, [
                    $record->id,
                    $record->name,
                    $record->email,
                    $record->phone,
                    $record->amount,
                    $record->currency,
                    Str::headline((string) $record->frequency),
                    Str::headline((string) $record->method),
                    $record->message,
                    $record->consent ? 'Yes' : 'No',
                    Str::headline($record->status),
                    $record->created_at?->format('Y-m-d H:i:s'),
                    $record->read_at?->format('Y-m-d H:i:s'),
                ], ',', '"', '');
            }

            fclose($handle);
        }, 'donation-pledges-'.now()->format('Y-m-d').'.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function show(DonationPledge $pledge): View
    {
        return $this->showRecord($pledge);
    }

    public function markAsRead(DonationPledge $pledge): RedirectResponse
    {
        return $this->markRecordAsRead($pledge);
    }

    public function destroy(DonationPledge $pledge): RedirectResponse
    {
        return $this->deleteRecord($pledge);
    }

    protected function query(): Builder
    {
        return DonationPledge::query();
    }

    protected function searchColumns(): array
    {
        return ['name', 'email', 'currency', 'frequency', 'method', 'message'];
    }

    protected function routePrefix(): string
    {
        return 'admin.pledges';
    }

    protected function exportRoute(): ?string
    {
        return 'admin.pledges.export';
    }

    protected function heading(): string
    {
        return 'Donation pledges';
    }

    protected function description(): string
    {
        return 'Giving pledges recorded from the donate page. No payment has been taken.';
    }

    protected function emptyMessage(): string
    {
        return 'No donation pledges have been recorded yet.';
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
            'summary' => number_format((float) $record->amount, 2).' '.$record->currency.' · '.Str::headline((string) $record->frequency).' · '.Str::headline((string) $record->method),
            'received_at' => $record->created_at,
            'read_at' => $record->read_at,
            'show_url' => route('admin.pledges.show', $record),
            'delete_url' => route('admin.pledges.destroy', $record),
        ];
    }

    protected function detailFields(Model $record): array
    {
        return [
            ['label' => 'Email', 'value' => $record->email, 'href' => 'mailto:'.$record->email],
            ['label' => 'Phone', 'value' => $record->phone, 'href' => $record->phone ? 'tel:'.$record->phone : null],
            ['label' => 'Amount', 'value' => number_format((float) $record->amount, 2).' '.$record->currency],
            ['label' => 'Frequency', 'value' => Str::headline((string) $record->frequency)],
            ['label' => 'Payment method', 'value' => Str::headline((string) $record->method)],
            ['label' => 'Status', 'value' => Str::headline($record->status)],
            ['label' => 'Consent to contact', 'value' => $record->consent ? 'Yes' : 'No'],
            ['label' => 'Message', 'value' => $record->message, 'block' => true],
        ];
    }
}
