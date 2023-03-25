<x-layouts.base>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header"><img src="/logo.png" alt="..." height="36"> &nbsp <b><h2>Fuel Portal</h2></b></div>
                    <div class="card-body">
                            <a class="btn btn-lg btn-primary" href="{{ route('login') }}" role="button">Please Login to continue</a>
                            <a class="btn btn-lg btn-primary" href="{{ route('register') }}" role="button">No Account? Register here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-layouts.base>
