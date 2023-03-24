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
        <div class="form-group row ">
            <label class="col-sm-5 col-form-label">Route</label>
            <div class="col-sm-5">
                <div>
                    <select wire:model="route_id" class="@error('route_id') is-invalid @enderror form-control"
                        name="route_id" required>
                        <option></option>
                        @foreach ($routes as $route)
                            <option value="{{ $route->id }}">{{ $route->route_name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('route_id'))
                        <span class="invalid-feedback" role="alert">
                            {{ $errors->first('route_id') }}
                        </span>
                    @endif
                </div>

                <div style="position:relative">
                    <input wire:model="reasonSearch" class="form-control relative" type="text"
                        placeholder="search..." />
                </div>
                <div style="position:absolute; z-index:100">
                    @if (strlen($reasonSearch) > 2)
                        @if (count($searchReasons) > 0)
                            <ul class="list-group">
                                @foreach ($searchReasons as $searchReason)
                                    <li class="list-group-item list-group-item-action"><span
                                            wire:click="selectReason({{ $searchReason->id }})">
                                            {{ $searchReason->reason }}</span></li>
                                @endforeach
                            </ul>
                        @else
                            <li class="list-group-item">Found nothing...</li>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Date</label>
            <div class="col-sm-5">
                <input wire:model.defer="date" id="date" type="date"
                    class="@error('date') is-invalid @enderror form-control form-control-sm">
                @if ($errors->has('date'))
                    <span class="invalid-feedback" role="alert">
                        {{ $errors->first('date') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button wire:click.prevent="addTrip()" type="button" class="btn btn-primary">
                <span>Save</span>
            </button>
        </div>
    </form>
</div>
