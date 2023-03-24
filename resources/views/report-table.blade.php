@foreach ($loadings as $loading)

    <table class="table">
        <thead>
            <tr>
                    <th>Trip ID</th>
                    <th>Loading Date</th>
                    <th>Truck No</th>
                    <th>Route</th>
                    <th>Total Quantity</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $loading->id }}</td>
                <td>{{ Carbon\Carbon::parse($loading->loading_date)->format('d-m-Y') }}</td>
                <td>{{ $loading->truck->truck_no }}</td>
                <td>{{ $loading->route->route_name }}</td>
                <td>{{ $loading->lpos->sum('quantity') }}</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>LPO Date</th>
                <th>Station</th>
                <th>Quantity</th>
                <th>Rate</th>
                <th>Cost</th>
                <th>Comment</th>
                <th>Doc No</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loading->lpos as $lpo)
                <tr>
                    <td>{{ Carbon\Carbon::parse($lpo->date)->format('d-m-Y') }}</td>
                    <td>{{ $lpo->station->name }}</td>
                    <td>{{ $lpo->quantity }}</td>
                    <td>{{ $lpo->rate }}</td>
                    <td>{{ number_format($lpo->quantity * $lpo->rate, 2) }}</td>
                    <td>{{ $lpo->comment->comment }}</td>
                    @foreach ($lpo->expenses as $a)
                        @if ($a->doc_path)
                            <td><a href="{{ $a->doc_path }}">{{ $a->doc_num }}</a></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach

        </tbody>
    </table>
@endforeach
