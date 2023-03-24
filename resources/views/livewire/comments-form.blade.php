<div>
    <form>
        <div class="form-group row">
            <label class="col-sm-5 col-form-label">Comment</label>
            <div class="col-sm-5">

                <textarea class="@error('comment') is-invalid @enderror form-control form-control-sm" wire:model.defer="comment" name="comment" id="comment" cols="30"
                    rows="3"></textarea>
                @if ($errors->has('comment'))
                    <span class="invalid-feedback" role="alert">
                        {{ $errors->first('comment') }}
                    </span>
                @endif
            </div>
            {{-- <div class="col-sm-5">
                <input wire:model.defer="comment" id="comment" type="text"
                    class="@error('comment') is-invalid @enderror form-control form-control-sm">
                @if ($errors->has('comment'))
                <span class="invalid-feedback" role="alert">
                    {{ $errors->first('comment') }}
                </span>
                @endif
            </div> --}}
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button wire:click.prevent="addComment()" type="button" class="btn btn-primary">
                <span>Save</span>
            </button>
        </div>
    </form>
</div>
