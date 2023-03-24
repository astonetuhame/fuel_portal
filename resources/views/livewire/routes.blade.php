<div>
    <!-- Editing Modal -->
    <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#form">
        Add Route
    </button>
    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <span>Save Route</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @livewire('routes-form')
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
                Per Page &nbsp;
                <select wire:model="perPage" class="form-select form-select-sm form-control">
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
    @if ($routes->isNotEmpty())
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col"><a role="button" wire:click.prevent="sortBy('route_code')" href="#"> Code
                            @include('includes._sort-icon', ['field' => 'route_code'])
                        </a></th>
                    <th scope="col"><a role="button" wire:click.prevent="sortBy('route_name')" href="#">Route
                            Name
                            @include('includes._sort-icon', ['field' => 'route_name'])
                        </a></th>
                    <th scope="col"><a role="button" wire:click.prevent="sortBy('destination_country')"
                            href="#">Destination Country
                            @include('includes._sort-icon', ['field' => 'destination_country'])
                        </a></th>
                    <th scope="col"><a role="button" wire:click.prevent="sortBy('single_diff')"
                            href="#">Single Diff
                            @include('includes._sort-icon', ['field' => 'single_diff'])
                        </a></th>
                    <th scope="col"><a role="button" wire:click.prevent="sortBy('double_diff')"
                            href="#">Double Diff
                            @include('includes._sort-icon', ['field' => 'double_diff'])
                        </a></th>
                    <th scope="col">Actions</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($routes as $route)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $route->route_code }}</td>
                        <td>{{ $route->route_name }}</td>
                        <td>{{ $route->destination_country }}</td>
                        <td>{{ $route->single_diff }}</td>
                        <td>{{ $route->double_diff }}</td>
                        <td>
                            <button wire:click="selectItem({{ $route->id }}, 'update')" type="button"
                                class="btn btn-md btn-success">
                                Update
                            </button>
                            {{-- <button wire:click="selectItem({{ $route->id }}, 'delete')" type="button"
                        class="btn btn-md btn-danger">
                        Delete
                    </button> --}}
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
    {{ $routes->links() }}
</div>
