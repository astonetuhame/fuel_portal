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
    @if ($expenses->isNotEmpty())
        <table class="table table-md">
            <thead>
                <tr>
                    <th></th>
                    <th>
                        <input wire:model="selectPageRows" wire:loading.attr="disabled" type="checkbox" value="">
                    </th>
                    <th>Expense Id</th>
                    <th>Trip Id</th>
                    <th>Truck</th>
                    <th>Lpo Date</th>
                    <th>Station</th>
                    <th>Route</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Cost</th>
                    <th>Comment</th>
                    <th>Doc No.</th>
                </tr>

            </thead>
            <tbody>
                @foreach ($expenses as $expense)
                    @if ($expense->generated)
                        <tr>
                            <td></td>
                            <td> <input wire:model="selectedRows" wire:loading.attr="disabled" type="checkbox"
                                    value="{{ $expense->id }}" id="{{ $expense->id }}"> </td>
                            <th scope="row">{{ $expense->id }}</th>

                            @foreach ($expense->lpo->loadings as $b)
                                <td>{{ $b->id  }}</td>
                            @endforeach
                            @foreach ($expense->lpo->loadings as $b)
                                <td>{{ $b->truck->truck_no }}</td>
                            @endforeach
                            <td>{{ Carbon\Carbon::parse($expense->lpo->date)->format('d-m-Y') }}</td>
                            <td>{{ $expense->lpo->station->name }}</td>
                            @foreach ($expense->lpo->loadings as $c)
                                <td>{{ $c->route->route_code }}</td>
                            @endforeach
                            <td>{{ $expense->lpo->quantity }}</td>
                            <td>{{ $expense->lpo->rate }}</td>
                            <td>{{ number_format($expense->lpo->quantity * $expense->lpo->rate, 2) }}</td>
                            <td>{{ $expense->lpo->comment->comment }}</td>
                            <td><a href="{{ $expense->doc_path }}">{{ $expense->doc_num }}</a></td>

                        </tr>
                    @endif
                @endforeach
            @else
                <div class="row justify-content-center mt-2">
                    <p>No matching records found</p>
                </div>
    @endif
    </tbody>
    </table>
    {{ $expenses->links() }}

</div> 