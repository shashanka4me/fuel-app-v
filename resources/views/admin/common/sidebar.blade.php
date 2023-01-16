<div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="{{url('/admin-console')}}" class="navbar-brand mx-4 mb-3">
                <img src="img/homepage.png" class="img-fluid mx-auto mb-4" width="50%">
                </a>
                
                <div class="navbar-nav w-100">
                    <a href="{{url('/admin-console')}}" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    
                    <a href="{{url('/admin-manage-fuel')}}" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Manage Fuel Stock</a>
                    <a href="{{url('/admin-filling-station?type=all')}}" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Manage Filling Station</a>
                    <a href="{{url('/admin-fuel-distribution?type=all')}}" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Fuel Distribution</a>
                    <a href="{{url('/admin-vehicle-registration')}}" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Vehicle Registration</a>
                    
                </div>
            </nav>
        </div>