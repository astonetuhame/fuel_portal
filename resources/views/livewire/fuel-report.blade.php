<div>

    <div class="row m-2">
        <div class="col-md-8">

        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input type="search" class="form-control" wire:model.debounce="search" placeholder="Search" />
            </div>
        </div>
    </div>
    @if ($sum->isNotEmpty())


        @foreach ($sum as $total)
            <div class="jumbotron jumbotron-fluid" style=>
                <div class="container">
                    <h3>{{ $total->truck_no }}</h3>
                    <p><b>Date: </b> {{ $total->date }}</p>
                    <p><b>Route: </b>{{ $total->route }}</p>
                    <div class="table-responsive">
                        <table class="table table-striped table-dark table-bordered table-md table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Station</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">LPO No.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $report)
                                    @if ($total->truck_no === $report->truck_no && $total->date === $report->date && $total->route === $report->route)
                                        <tr>
                                            <td>{{ $report->station }}</td>
                                            <td>{{ $report->quantity }}</td>
                                            <td>{{ $report->lpo }}</td>
                                        </tr>
                                    @endif
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <p><b>Total: </b>{{ $total->sum }}</p>
                </div>
            </div>
        @endforeach
    @else
        <div class="row justify-content-center mt-2">
            <p>No matching records found</p>
        </div>
    @endif


    {{ $sum->links() }}
</div>
