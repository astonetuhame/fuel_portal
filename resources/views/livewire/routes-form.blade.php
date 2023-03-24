<div>
    <form>
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Route Code</label>
            <div class="col-sm-5">
                <input wire:model.defer="route_code" id="route_code" type="text"
                    class="@error('route_code') is-invalid @enderror form-control form-control-sm">
                @if ($errors->has('route_code'))
                <span class="invalid-feedback" role="alert">
                    {{ $errors->first('route_code') }}
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Route Name</label>
            <div class="col-sm-5">
                <input wire:model.defer="route_name" id="route_name" type="text"
                    class="@error('route_name') is-invalid @enderror form-control form-control-sm">
                @if ($errors->has('route_name'))
                <span class="invalid-feedback" role="alert">
                    {{ $errors->first('route_name') }}
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Destination Country</label>
            <div class="col-sm-5">
                <input wire:model.defer="destination_country" id="destination_country" type="text"
                    class="@error('destination_country') is-invalid @enderror form-control form-control-sm">
                @if ($errors->has('destination_country'))
                <span class="invalid-feedback" role="alert">
                    {{ $errors->first('destination_country') }}
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Single Diff</label>
            <div class="col-sm-5">
                <input wire:model.defer="single_diff" id="single_diff" type="text"
                    class="@error('single_diff') is-invalid @enderror form-control form-control-sm">
                @if ($errors->has('single_diff'))
                <span class="invalid-feedback" role="alert">
                    {{ $errors->first('single_diff') }}
                </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Double Diff</label>
            <div class="col-sm-5">
                <input wire:model.defer="double_diff" id="double_diff" type="text"
                    class="@error('double_diff') is-invalid @enderror form-control form-control-sm">
                @if ($errors->has('double_diff'))
                <span class="invalid-feedback" role="alert">
                    {{ $errors->first('double_diff') }}
                </span>
                @endif
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button wire:click.prevent="addRoute()" type="button" class="btn btn-primary">
                <span>Save</span>
            </button>
        </div>
    </form>
</div>