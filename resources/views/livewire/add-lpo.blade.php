<div>
    <!-- Editing Modal -->
    <a class="btn btn-secondary" href="{{ route('fuel.modify') }}" wire:loading.attr="disabled"> Back</a>
    @can('lpo-create')
        <button type="button" wire:loading.attr="disabled" class="btn btn-md btn-primary" data-toggle="modal"
            data-target="#form">
            Add
        </button>
    @endcan
    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                    @livewire('add-lpo-form', compact('loading'))
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

    </div>
    @if ($lpos->isNotEmpty())
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">
                        <a role="button" wire:click.prevent="sortBy('date')" href="#">
                            Date
                            @include('includes._sort-icon', ['field' => 'date'])
                        </a>
                    </th>
                    <th scope="col">
                        <a role="button" wire:click.prevent="sortBy('station_id')" href="#">
                            Station
                            @include('includes._sort-icon', ['field' => 'station_id'])
                        </a>
                    </th>
                    <th scope="col">
                        <a role="button" wire:click.prevent="sortBy('quantity')" href="#">
                            Quantity
                            @include('includes._sort-icon', ['field' => 'quantity'])
                        </a>
                    </th>
                    <th scope="col">
                        <a role="button" wire:click.prevent="sortBy('rate')" href="#">
                        Rate
                        @include('includes._sort-icon', ['field' => 'rate'])
                        </a>
                    </th>
                    <th scope="col">
                        <a role="button" wire:click.prevent="sortBy('comment_id')" href="#">
                        Comment
                        @include('includes._sort-icon', ['field' => 'comment_id'])
                        </a>
                    </th>
                    <th scope="col">Doc No.</th>
                    <th scope="col">Actions</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($lpos as $lpo)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ Carbon\Carbon::parse($lpo->date)->format('d-m-Y') }}</td>
                        <td>{{ $lpo->station->name }}</td>
                        <td>{{ $lpo->quantity }}</td>
                        <td>{{ $lpo->rate }}</td>
                        <td>{{ $lpo->comment->comment }}</td>
                        <td>
                            @php
                                $doc = DB::table('expenses')
                                    ->where('lpo_id', $lpo->id)
                                    ->select('doc_path', 'doc_num')
                                    ->get();
                            @endphp
                            @if ($doc->isNotEmpty())
                                @foreach ($doc as $a)
                                    @if ($lpo->generated)
                                        <a href="{{ $a->doc_path }}">{{ $a->doc_num }}</a>
                                    @endif
                                @endforeach
                            @endif
                        </td>

                        <td>
                            @if (!$lpo->expense)
                                @can('lpo-expense')
                                    <button wire:click="addExpense({{ $lpo->id }})" wire:loading.attr="disabled"
                                        type="button" class="btn btn-md btn-info">
                                        Send to Expenses
                                    </button>
                                @endcan
                            @endif
                            @if ($lpo->generated)
                                @role(['Super Admin'])
                                    <button wire:click="selectItem({{ $lpo->id }}, 'update')" type="button"
                                        wire:loading.attr="disabled" class="btn btn-md btn-success">
                                        Update
                                    </button>
                                @endrole
                            @else
                                @can('lpo-expense')
                                    <button wire:click="selectItem({{ $lpo->id }}, 'update')" type="button"
                                        wire:loading.attr="disabled" class="btn btn-md btn-success">
                                        Update
                                    </button>
                                @endcan
                            @endif

                            @if (!$lpo->generated)
                                @can('lpo-delete')
                                    <button wire:click="selectItem({{ $lpo->id }}, 'delete')" type="button"
                                        wire:loading.attr="disabled" class="btn btn-md btn-danger">
                                        Delete
                                    </button>
                                @endcan
                            @endif



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
    {{ $lpos->links() }}
</div>
