<div>
    <form>
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Date</label>
            <div class="col-sm-5">
                <input id="distance_date" type="date" wire:model="distance_date"
                    class="@error('distance_date') is-invalid @enderror form-control form-control-sm">
                @if ($errors->has('distance_date'))
                    <span class="invalid-feedback" role="alert">
                        {{ $errors->first('distance_date') }}
                    </span>
                @endif
            </div>
        </div>
 
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Odometer</label>
            <div class="col-sm-5">
                <input wire:model.defer="odometer" id="odometer" type="number"
                    class="@error('odometer') is-invalid @enderror form-control form-control-sm">
                @if ($errors->has('odometer'))
                    <span class="invalid-feedback" role="alert">
                        {{ $errors->first('odometer') }}
                    </span>
                @endif
            </div>
        </div>
 
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button wire:click.prevent="addDistance()" wire:loading.attr="disabled" type="button" class="btn btn-primary">
                <span>Save</span>
            </button>
        </div>
    </form>
</div>
