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
                    <th><a role="button" wire:click.prevent="sortBy('id')" href="#">Expense ID
                            @include('includes._sort-icon', ['field' => 'id'])
                        </a></th>
                    <th><a role="button" wire:click.prevent="sortBy('lpo.loadings.id')" href="#">Trip Id
                        @include('includes._sort-icon', ['field' => 'lpo.loadings.id'])
                    </a></th>
                    <th><a role="button" wire:click.prevent="sortBy('lpo.loadings.truck.truck_no')" href="#">Truck
                        @include('includes._sort-icon', ['field' => 'lpo.loadings.truck.truck_no'])
                    </a></th>
                    <th><a role="button" wire:click.prevent="sortBy('lpo_date')" href="#">Lpo Date
                        @include('includes._sort-icon', ['field' => 'lpo_date'])
                    </a></th>
                    <th><a role="button" wire:click.prevent="sortBy('station_name'')" href="#">Station
                        @include('includes._sort-icon', ['field' => 'station_name'])
                    </a></th>
                    <th>Route</th>
                    <th><a role="button" wire:click.prevent="sortBy('lpo_quantity')" href="#">Quantity
                        @include('includes._sort-icon', ['field' => 'lpo_quantity'])
                    </a></th>
                    <th><a role="button" wire:click.prevent="sortBy('lpo_rate')" href="#">Rate
                        @include('includes._sort-icon', ['field' => 'lpo_rate'])
                    </a></th>
                    <th><a role="button" wire:click.prevent="sortBy('cost')" href="#">Cost
                        @include('includes._sort-icon', ['field' => 'cost'])
                    <th>Comment</th>
                    <th><a role="button" wire:click.prevent="sortBy('doc_num')" href="#">Doc No.
                        @include('includes._sort-icon', ['field' => 'doc_num'])
                    </a></th>
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
                                <td>{{ $b->id }}</td>
                            @endforeach
                            @foreach ($expense->lpo->loadings as $b)
                                <td>{{ $b->truck->truck_no }}</td>
                            @endforeach
                           <td>{{ Carbon\Carbon::parse($expense->lpo_date)->format('d-m-Y')  }}</td>
                            <td>{{ $expense->lpo->station->name }}</td>
                            @foreach ($expense->lpo->loadings as $c)
                                <td>{{ $c->route->route_code }}</td>
                            @endforeach
                            <td>{{ $expense->lpo_quantity }}</td>
                            <td>{{ $expense->lpo_rate }}</td>
                            <td>{{ number_format($expense->cost, 2) }}</td>
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
