<div>
    <form>
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Station Name</label>
            <div class="col-sm-5">
                <input wire:model.defer="name" id="name" type="text"
                    class="@error('name') is-invalid @enderror form-control form-control-sm">
                @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    {{ $errors->first('name') }}
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Rate</label>
            <div class="col-sm-5">
                <input wire:model.defer="rate" id="rate" type="number"
                    class="@error('rate') is-invalid @enderror form-control form-control-sm">
                @if ($errors->has('rate'))
                <span class="invalid-feedback" role="alert">
                    {{ $errors->first('rate') }}
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Currency</label>
            <div class="col-sm-5">
                <input wire:model.defer="currency" id="currency" type="text"
                    class="@error('currency') is-invalid @enderror form-control form-control-sm">
                @if ($errors->has('currency'))
                <span class="invalid-feedback" role="alert">
                    {{ $errors->first('currency') }}
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Quantity</label>
            <div class="col-sm-5">
                <input wire:model.defer="quantity" id="quantity" type="number"
                    class="@error('quantity') is-invalid @enderror form-control form-control-sm">
                @if ($errors->has('quantity'))
                <span class="invalid-feedback" role="alert">
                    {{ $errors->first('quantity') }}
                </span>
                @endif
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button wire:click.prevent="addStation()" wire:loading.attr="disabled" type="button" class="btn btn-primary">
                <span>Save</span>
            </button>
        </div>
    </form>
</div>