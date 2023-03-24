<div>
    {{-- @foreach ($fin as $a)
    {{ $a->local_id }}
    {{ $a->odometer }}
        
    @endforeach --}}


    @foreach ($distances as $distance)
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Truck</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $distance->truck->truck_no }}</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-sm table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Odometer</th>
                            <th>Diff</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($distance->distances as $info)
                            <tr>
                                <td>{{ Carbon\Carbon::parse($info->date)->format('d-m-Y') }}</td>
                                <td>{{ $info->odometer }}</td>
                                @php
                                    $arr = [];
                                    $res = collect((int)$info->odometer);
                                    $mine = $res->map(function($a){
                                        return $a;
                                    });

                                @endphp
                                {{ var_dump($mine) }}
                                {{-- @foreach ($arr as $key=>$a )
                                    {{ $key }}{{ $a }}
                                @endforeach --}}
                                
                                {{-- @php
                                // $arr = [];
                                // array_push($arr, (int) $info->odometer);
                                // $result = [0];
                                // for ($i = 1; $i < count($arr); $i++) {
                                //     $result[] = abs($arr[$i - 1] - $arr[$i]);
                                // }
                                $arr = [];
                                foreach ($fin as $a) {
                                    if ($a->local_id == $distance->id) {
                                        array_push($arr, (int)$a->odometer);
                                    }
                                }
                                @endphp
                                {{ var_dump($arr) }} --}}
                                {{-- @foreach ($res as $b )
                                {{ $b }}
                                
                                @endforeach --}}
                                {{-- @foreach ($fin as $a)
                                    {{ $a->local_id }}
                                    {{ $a->odometer }}
                                        
                                    @endforeach --}}
                                {{-- @php
                                    $arr = [];
                                    array_push($arr, $info->odometer);
                                    $kms = array_map('intval', $arr);
                                @endphp --}}
                                {{-- @for ($i = 0; $i < count($kms); $i++)
                                    <td>{{ $i }} {{ $kms[$i] }}</td>
                                @endfor --}}
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
    {{ $distances->links() }}
</div>
