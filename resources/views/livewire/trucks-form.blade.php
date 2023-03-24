<div>
    <form>
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Truck Number</label>
            <div class="col-sm-5">
                <input wire:model.defer="truck_no" id="truck_no" type="text"
                    class="@error('truck_no') is-invalid @enderror form-control form-control-sm">
                @if ($errors->has('truck_no'))
                <span class="invalid-feedback" role="alert">
                    {{ $errors->first('truck_no') }}
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Type</label>
            <div class="col-sm-5">
                <input wire:model.defer="type" id="type" type="text"
                    class="@error('type') is-invalid @enderror form-control form-control-sm">
                @if ($errors->has('type'))
                <span class="invalid-feedback" role="alert">
                    {{ $errors->first('type') }}
                </span>
                @endif
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button wire:click.prevent="addTruck()" type="button" class="btn btn-primary">
                <span>Save</span>
            </button>
        </div>
    </form>
</div>
