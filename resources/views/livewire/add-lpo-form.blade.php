<div>
    <form>
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Date</label>
            <div class="col-sm-5">
                <input id="lpo_date" type="date" wire:model="lpo_date"
                    class="@error('lpo_date') is-invalid @enderror form-control form-control-sm">
                @if ($errors->has('lpo_date'))
                    <span class="invalid-feedback" role="alert">
                        {{ $errors->first('lpo_date') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row ">
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
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Comment</label>
            <div class="col-sm-6">
                <div>
                    <select wire:model="comment_id" class="@error('comment_id') is-invalid @enderror form-control" name="comment_id" required>
                        <option></option>
                        @foreach ($comments as $comment)
                            <option value="{{ $comment->id }}">{{ $comment->comment }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('comment_id'))
                        <span class="invalid-feedback" role="alert">
                            {{ $errors->first('comment_id') }}
                        </span>
                    @endif
                </div>
            </div>
            {{-- <textarea class="form-control form-control-sm" wire:model.defer="comment" name="comment" id="comment" cols="30" rows="3"></textarea> --}}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button wire:click.prevent="addLpo()" wire:loading.attr="disabled" type="button" class="btn btn-primary">
                <span>Save</span>
            </button>
        </div>
    </form>
</div>
