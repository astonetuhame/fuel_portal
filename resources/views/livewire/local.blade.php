<div>
    <!-- Editing Modal -->
    <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#form">
        Add
    </button>
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
                    @livewire('local-form')
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

        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input type="search" class="form-control" wire:model.debounce="search" placeholder="Search" />
            </div>
        </div>
    </div>
    @if ($locals->isNotEmpty())
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Truck No</th>
                    <th scope="col">Actions</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($locals as $local)
                    <tr>
                        <th scope="row">{{ $local->id }}</th>
                        <td><a href="{{ route('add.distance', $local) }}">{{ $local->truck->truck_no }}</a></td>
                        <td>
                            <button wire:click="selectItem({{ $local->id }}, 'update')" type="button"
                                class="btn btn-md btn-success">
                                Update
                            </button>
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
    {{ $locals->links() }}
</div>
