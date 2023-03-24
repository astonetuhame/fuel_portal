<div>

    <button class="btn btn-dark" wire:loading.attr="disabled" wire:click.prevent="invoice()">Gen</button>
    <x-loading-indicator />
    <div class="row m-2">
        <div class="col-md-8">

        </div>
    </div>
    @if ($expenses->isNotEmpty())

        <table class="table">

            <thead>
                <tr>
                    <th></th>
                    <th>
                        <input wire:model="selectPageRows" wire:loading.attr="disabled" type="checkbox" value="">
                    </th>
                    <th scope="col">Id</th>
                    <th scope="col">Truck No</th>
                    <th scope="col">Route</th>
                    <th scope="col">Station</th>
                    <th scope="col">Quantity</th>

                </tr>
            </thead>
            <tr>
                <tbody>
                    @foreach ($expenses as $expense)
                        <td></td>
                        <td> <input wire:model="selectedRows" wire:loading.attr="disabled" type="checkbox"
                                value="{{ $expense->id }}" id="{{ $expense->id }}"> </td>
                        <th scope="row">{{ $loop->iteration }}</th>
                        {{-- <td>{{ $expense->lpo->loadings }}</td> --}}
                        @foreach ($expense->lpo->loadings as $asset)
                            <td>{{ $asset->truck['truck_no'] }}</td>
                        @endforeach
                        @foreach ($expense->lpo->loadings as $a)
                            <td>{{ $a->route['route_code'] }}</td>
                        @endforeach
                        <td>{{ $expense->lpo->station->name }}</td>
                        <td>{{ $expense->lpo->quantity }}</td>
            </tr>
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
