{{-- @php
    $arr = [];
    foreach ($test as $a) {
        array_push($arr, (int) $a->odometer);
    }
    
    $result = [0];
    for ($i = 1; $i < count($arr); $i++) {
        $result[] = abs($arr[$i - 1] - $arr[$i]);
    }
    $kms = $result[count($result) - 1];
@endphp --}}


<div>
    <!-- Editing Modal -->
    <a class="btn btn-secondary" href="{{ route('local') }}" wire:loading.attr="disabled"> Back</a>
    <button type="button" wire:loading.attr="disabled" class="btn btn-md btn-primary" data-toggle="modal"
        data-target="#form">
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
                    @livewire('add-distance-form', compact('local'))
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

    </div>

    {{-- <div class="badge bg-info text-wrap text-center">
        {{ $kms }} kms
    </div> --}}
    @if ($distances->isNotEmpty())
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Odometer</th>
                    <th scope="col">Actions</th>

                </tr>
            </thead>
            <tbody>

                @foreach ($distances as $distance)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ Carbon\Carbon::parse($distance->date)->format('d-m-Y') }}</td>
                        <td>{{ $distance->odometer }}</td>
                        <td>

                            <button wire:click="selectItem({{ $distance->id }}, 'update')" type="button"
                                wire:loading.attr="disabled" class="btn btn-md btn-success">
                                Update
                            </button>
                            <button wire:click="selectItem({{ $distance->id }}, 'delete')" type="button"
                                wire:loading.attr="disabled" class="btn btn-md btn-danger">
                                Delete
                            </button>

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
    {{ $distances->links() }}
</div>
