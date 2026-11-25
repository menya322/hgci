<?php

namespace App\Http\Controllers\Admin\Inbox;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

abstract class InboxController extends Controller
{
    /**
     * Columns matched by the search box.
     *
     * @return list<string>
     */
    abstract protected function searchColumns(): array;

    /**
     * Route name prefix, for example "admin.messages".
     */
    abstract protected function routePrefix(): string;

    abstract protected function query(): Builder;

    abstract protected function heading(): string;

    abstract protected function description(): string;

    abstract protected function emptyMessage(): string;

    abstract protected function recordName(Model $record): string;

    /**
     * @return array{
     *     name: string,
     *     email: string,
     *     summary: string,
     *     received_at: Carbon,
     *     read_at: Carbon|null,
     *     show_url: string,
     *     delete_url: string
     * }
     */
    abstract protected function row(Model $record): array;

    /**
     * @return list<array{label: string, value: mixed, href?: string|null, block?: bool}>
     */
    abstract protected function detailFields(Model $record): array;

    protected function listRecords(Request $request): View
    {
        $search = $this->searchTerm($request);
        $unreadOnly = $this->unreadOnly($request);

        $records = $this->filteredQuery($request)->paginate(20)->withQueryString();

        return view('admin.inbox.records', [
            'records' => $records,
            'rows' => $records->getCollection()->map(fn (Model $record): array => $this->row($record)),
            'heading' => $this->heading(),
            'description' => $this->description(),
            'emptyMessage' => $this->emptyMessage(),
            'indexRoute' => $this->routePrefix().'.index',
            'exportRoute' => $this->exportRoute(),
            'search' => $search,
            'unreadOnly' => $unreadOnly,
            'unreadCount' => $this->query()->whereNull('read_at')->count(),
            'totalCount' => $this->query()->count(),
        ]);
    }

    /**
     * Apply the current search and unread filters to an inbox query.
     */
    protected function filteredQuery(Request $request): Builder
    {
        $query = $this->query()->latest('id');
        $search = $this->searchTerm($request);

        if ($search !== '') {
            $query->where(function (Builder $query) use ($search): void {
                foreach ($this->searchColumns() as $column) {
                    $query->orWhere($column, 'like', '%'.$search.'%');
                }
            });
        }

        if ($this->unreadOnly($request)) {
            $query->whereNull('read_at');
        }

        return $query;
    }

    protected function searchTerm(Request $request): string
    {
        return trim((string) $request->query('q', ''));
    }

    protected function unreadOnly(Request $request): bool
    {
        return $request->boolean('unread');
    }

    /**
     * Route name for the CSV export action, when this inbox has one.
     */
    protected function exportRoute(): ?string
    {
        return null;
    }

    protected function showRecord(Model $record): View
    {
        return view('admin.inbox.show', [
            'record' => $record,
            'name' => $this->recordName($record),
            'fields' => $this->detailFields($record),
            'heading' => $this->heading(),
            'indexRoute' => $this->routePrefix().'.index',
            'readRoute' => $this->routePrefix().'.read',
            'destroyRoute' => $this->routePrefix().'.destroy',
        ]);
    }

    protected function markRecordAsRead(Model $record): RedirectResponse
    {
        if ($record->read_at === null) {
            $record->forceFill(['read_at' => now()])->save();
        }

        return redirect()
            ->route($this->routePrefix().'.show', $record)
            ->with('status', 'Marked as read.');
    }

    protected function deleteRecord(Model $record): RedirectResponse
    {
        $record->delete();

        return redirect()
            ->route($this->routePrefix().'.index')
            ->with('status', 'Record deleted.');
    }
}
