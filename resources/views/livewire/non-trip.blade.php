<div>
    <!-- Editing Modal -->
    <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#form">
      Add Trip
    </button>
    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
  
    <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#form1">
      Add NonTrip
    </button>
    <div class="modal fade" id="form1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
  
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <input type="search" class="form-control" wire:model.debounce="search" placeholder="Search" />
        </div>
      </div>
    </div>
    @if($nontrips->isNotEmpty())
    <table class="table table-sm">
      <thead>
        <tr>
          <th scope="col">Id</th>
          <th scope="col">Truck No</th>
          <th scope="col">Reason</th>
          <th scope="col">Total Fuel</th>
          <th scope="col">Date</th>
          <th scope="col">Actions</th> 
  
        </tr>
      </thead>
      <tbody>
        @foreach ( $nontrips as $nontrip )
        <tr>
          <th scope="row">{{ $loop->iteration }}</th>
          <td><a href="{{ route('add.lpo', $nontrip) }}">{{ $nontrip->truck->truck_no }}</a></td>
          <td>{{ $nontrip->reason->reason }}</td>
          <td>{{ $nontrip->lpos->sum('quantity') }}</td>
          <td>
            <button wire:click="selectItem({{ $nontrip->id }}, 'update')" type="button" class="btn btn-md btn-success">
              Update
            </button>
            <button wire:click="selectItem({{ $nontrip->id }}, 'delete')" type="button" class="btn btn-md btn-danger">
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
    {{ $nontrips->links() }}
  </div>