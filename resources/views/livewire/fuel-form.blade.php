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
                    <input wire:model="routeSearch" class="form-control relative" type="text"
                        placeholder="search..." />
                </div>
                <div style="position:absolute; z-index:100">
                    @if (strlen($routeSearch) > 2)
                        @if (count($searchRoutes) > 0)
                            <ul class="list-group">
                                @foreach ($searchRoutes as $searchRoute)
                                    <li class="list-group-item list-group-item-action"><span
                                            wire:click="selectRoute({{ $searchRoute->id }})">
                                            {{ $searchRoute->route_name }}</span></li>
                                @endforeach
                            </ul>
                        @else
                            <li class="list-group-item">Found nothing...</li>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        {{-- <div class="form-group row ">
            <label class="col-sm-5 col-form-label">Station</label>
            <div class="col-sm-5">
                <div>
                    <select wire:model="station_id" class="@error('station_id') is-invalid @enderror form-control"
                        name="station_id" required>
                        <option></option>
                        @foreach ($stations as $station)
                            <option value="{{ $station->id }}">{{ $station->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('station_id'))
                    <span class="invalid-feedback" role="alert">
                        {{ $errors->first('station_id') }}
                    </span>
                @endif
                </div>

                <div style="position:relative">
                    <input wire:model="stationSearch" class="form-control relative" type="text"
                        placeholder="search..." />
                </div>
                <div style="position:absolute; z-index:100">
                    @if (strlen($stationSearch) > 2)
                        @if (count($searchStations) > 0)
                            <ul class="list-group">
                                @foreach ($searchStations as $searchStation)
                                    <li class="list-group-item list-group-item-action"><span
                                            wire:click="selectStation({{ $searchStation->id }})">
                                            {{ $searchStation->name }}</span></li>
                                @endforeach
                            </ul>
                        @else
                            <li class="list-group-item">Found nothing...</li>
                        @endif
                    @endif
                </div>
            </div>
        </div> --}}

        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Loading Date</label>
            <div class="col-sm-5">
                <input wire:model.defer="loading_date" id="loading_date" type="date"
                    class="@error('loading_date') is-invalid @enderror form-control form-control-sm">
                @if ($errors->has('loading_date'))
                    <span class="invalid-feedback" role="alert">
                        {{ $errors->first('loading_date') }}
                    </span>
                @endif
            </div>
        </div>
        {{-- <div class="form-group row">
            <label class="col-sm-5 col-form-label">LPO Number</label>
            <div class="col-sm-5">
                <input wire:model.defer="lpo" id="lpo" type="text"
                    class="@error('lpo') is-invalid @enderror form-control form-control-sm">
                @if ($errors->has('lpo'))
                    <span class="invalid-feedback" role="alert">
                        {{ $errors->first('lpo') }}
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
        </div> --}}
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button wire:loading.attr="disabled" wire:click.prevent="addTrip()" type="button" class="btn btn-primary">
                <span>Save</span>
            </button>
        </div>
    </form>
</div>
