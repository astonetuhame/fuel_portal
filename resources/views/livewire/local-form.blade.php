<div>
    <form>
        <div class="form-group row ">
            <label class="col-sm-5 col-form-label">Truck Number</label>
            <div class="col-sm-5">
                <div>
                    <select wire:model="truck_id" class="@error('truck_id') is-invalid @enderror form-control"
                        name="truck_id" required>
                        <option></option>
                        @foreach ($trucks as $truck)
                            <option value="{{ $truck->id }}">{{ $truck->truck_no }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('truck_id'))
                        <span class="invalid-feedback" role="alert">
                            {{ $errors->first('truck_id') }}
                        </span>
                    @endif
                </div>

                <div style="position:relative">
                    <input wire:model="truckSearch" class="form-control relative" type="text"
                        placeholder="search..." />
                </div>
                <div style="position:absolute; z-index:100">
                    @if (strlen($truckSearch) > 2)
                        @if (count($searchTrucks) > 0)
                            <ul class="list-group">
                                @foreach ($searchTrucks as $searchTruck)
                                    <li class="list-group-item list-group-item-action"><span
                                            wire:click="selectTruck({{ $searchTruck->id }})">
                                            {{ $searchTruck->truck_no }}</span></li>
                                @endforeach
                            </ul>
                        @else
                            <li class="list-group-item">Found nothing...</li>
                        @endif
                    @endif
                </div>

            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button wire:loading.attr="disabled" wire:click.prevent="addLocal()" type="button" class="btn btn-primary">
                <span>Save</span>
            </button>
        </div>
    </form>
</div>
