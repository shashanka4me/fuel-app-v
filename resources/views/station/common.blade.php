<div class="d-flex align-items-center justify-content-between mb-3">
    <div class="col-lg-6">
        <a href="{{url('/station-login')}}"><img src="img/logo-station.png" class="img-fluid mx-auto mb-4 rounded-circle" width="50%"></a>
    </div>
    <div class="col-lg-6">
        <div class="pos-f-t">
           
            <nav class="navbar navbar-dark custom-white">
                <small><?php echo  session()->get('station_data')['name'] ?></small>
                
                <a href="{{url('/fuel-issue')}}">Fuel Issue</a><span> | </span>
                <a href="{{url('/fuel-order')}}">Fuel Order</a><span> | </span>
                <a href="{{url('/logout-station')}}">Logout</a>
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>
        </div>
    </div>

</div>