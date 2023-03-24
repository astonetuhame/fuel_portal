<div>
    <div class="row m-2">
        <div class="col-md-8">
            @if ($selectedRows)
                <div class="btn-group ml-2">
                    <button type="button" class="btn btn-secondary">Bulk Actions</button>
                    <button type="button" class="btn btn-secondary dropdown-toggle dropdown-icon" data-toggle="dropdown">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                        <a wire:click.prevent="export" class="dropdown-item" href="#">Export</a>
                    </div>
                </div>

                <span class="ml-2">Selected {{ count($selectedRows) }}
                    {{ Str::plural('item', count($selectedRows)) }}</span>
            @endif
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input type="search" class="form-control" wire:model.debounce="search" placeholder="Search" />
            </div>
        </div>
    </div>
    <hr>
    <input wire:model="selectPageRows" wire:loading.attr="disabled" type="checkbox" value="" class="mx-4">
    @foreach ($loadings as $loading)
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <table class="table">
                    <thead>
                        <tr>
                            <th><input wire:model="selectedRows" wire:loading.attr="disabled" type="checkbox"
                                value="{{ $loading->id }}" id="{{ $loading->id }}"></th>
                            <th>Trip ID</th>
                            <th>Loading Date</th>
                            <th>Truck No</th>
                            <th>Route</th>
                            <th>Total Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>  </td>
                            <td>{{ $loading->id }}</td>
                            <td>{{ Carbon\Carbon::parse($loading->loading_date)->format('d-m-Y') }}</td>
                            <td>{{ $loading->truck->truck_no }}</td>
                            <td>{{ $loading->route->route_name }}</td>
                            <td>{{ $loading->lpos->sum('quantity') }}</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-sm table-striped table-hover">
                    <thead>
                        <tr>
                            <th>LPO Date</th>
                            <th>Station</th>
                            <th>Quantity</th>
                            <th>Rate</th>
                            <th>Cost</th>
                            <th>Comment</th>
                            <th>Doc No</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loading->lpos as $lpo)
                            <tr>
                                <td>{{ Carbon\Carbon::parse($lpo->date)->format('d-m-Y') }}</td>
                                <td>{{ $lpo->station->name }}</td>
                                <td>{{ $lpo->quantity }}</td>
                                <td>{{ $lpo->rate }}</td>
                                <td>{{ number_format($lpo->quantity * $lpo->rate, 2) }}</td>
                                <td>{{ $lpo->comment->comment }}</td>
                                @foreach ($lpo->expenses as $a)
                                    @if ($a->doc_path)
                                        <td><a href="{{ $a->doc_path }}">{{ $a->doc_num }}</a></td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
    {{ $loadings->links() }}
</div>
