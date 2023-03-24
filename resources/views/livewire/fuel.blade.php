<div>
    <!-- Editing Modal -->
    @can('trip-create')
        <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#form">
            Add Trip
        </button>
    @endcan
    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <span>Save</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @livewire('fuel-form')
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Dialog Modal  -->
    <div wire:ignore.self class="modal fade" id="modalFormDelete" tabindex="-1" role="dialog"
        aria-labelledby="modalFormDeletePost" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormDeletePost">
                        <span>Delete Item</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3>Do you wish to continue?</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button wire:click="delete" type="button" class="btn btn-primary">
                        <span>Yes</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row m-2">
        <div class="col-md-8">
            {{-- <div class="col form-inline">
                Per Page: &nbsp;
                <select wire:model="perPage" class="form-control">
                    <option class="form-control">10</option>
                    <option class="form-control">25</option>
                    <option class="form-control">50</option>
                    <option class="form-control">100</option>
                </select>
            </div> --}}
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input type="search" class="form-control" wire:model.debounce="search" placeholder="Search" />
            </div>
        </div>
    </div>
    @if ($fuel->isNotEmpty())
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col"><a role="button" wire:click.prevent="sortBy('id')" href="#">Id
                            @include('includes._sort-icon', ['field' => 'id'])
                        </a>
                    </th>
                    <th scope="col"><a role="button" wire:click.prevent="sortBy('truck_id')" href="#">Truck
                            No
                            @include('includes._sort-icon', ['field' => 'truck_id'])
                        </a></th>
                    <th scope="col"><a role="button" wire:click.prevent="sortBy('route_id')" href="#">Route
                            @include('includes._sort-icon', ['field' => 'route_id'])
                        </a>
                    </th>
                    <th scope="col">
                        <a role="button" wire:click.prevent="sortBy('lpos_sum_quantity')" href="#">Total Fuel
                            @include('includes._sort-icon', ['field' => 'lpos_sum_quantity'])
                        </a>

                    </th>
                    <th scope="col"><a role="button" wire:click.prevent="sortBy('loading_date')"
                            href="#">Loading
                            Date
                            @include('includes._sort-icon', ['field' => 'loading_date'])
                        </a></th>
                    <th scope="col">Actions</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($fuel as $info)
                    <tr>
                        <th scope="row">{{ $info->id }}</th>
                        <td><a href="{{ route('add.lpo', $info) }}">{{ $info->truck->truck_no }}</a></td>
                        <td>{{ $info->route->route_name }}</td>
                        <td>{{ $info->lpos_sum_quantity }}</td>
                        <td>{{ Carbon\Carbon::parse($info->loading_date)->format('d-m-Y') }}</td>
                        <td>
                            @can('trip-create')
                                <button wire:click="selectItem({{ $info->id }}, 'update')" type="button"
                                    class="btn btn-md btn-success">
                                    Update
                                </button>
                            @endcan
                            {{-- @can('trip-delete')
            <button wire:click="selectItem({{ $info->id }}, 'delete')" type="button" class="btn btn-md btn-danger">
              Delete
            </button>
            @endcan --}}
                        </td>
                    </tr>
                @endforeach
            @else
                <div class="row justify-content-center mt-2">
                    <p>No matching records found</p>
                </div>
    @endif
    </tbody>
    </table>
    {{ $fuel->links() }}
</div>
