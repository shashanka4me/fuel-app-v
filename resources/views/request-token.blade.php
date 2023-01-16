<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PowerFuel</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <style>
        .navbar-dark .navbar-toggler-icon {
            background-image: url(img/menu.png);
        }

        .navbar.custom-white {
            background-color: #fff;
            justify-content: end;
        }
    </style>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sign In Start -->
        <div class="container-fluid">

            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">

                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                @include('common')
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <h5>Request Fuel</h5>
                        <form id="request_form">
                            <div class="form-floating mb-3">
                                <select class="form-select form-select-sm mb-3" aria-label=".form-select-sm example" onchange="loadSuberb(this.value)" name="dis_id">
                                    <option selected="">Select your district</option>
                                    @foreach($district_set as $dis)
                                    <option value="{{$dis->id}}">{{$dis->name}}</option>
                                    @endforeach
                                   
                                </select>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select form-select-sm mb-3" aria-label=".form-select-sm example" id="suberbList" onchange="loadStation(this.value)" name="sub_id">
                                    <option selected="">Select your suberb</option>
                                   
                                </select>

                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select form-select-sm mb-3" aria-label=".form-select-sm example" id="stationList" name="station_id">
                                    <option selected="">Select the fuel station</option>
                                    
                                </select>

                            </div>
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="floatingText" placeholder="jhondoe" name="date">
                                <label for="floatingText">Request date</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="time" class="form-control" id="floatingText" placeholder="jhondoe" name="time">
                                <label for="floatingText">Request time</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="quata" placeholder="jhondoe" readonly name="quata" value="{{$oilQuata}}L">
                                <label for="floatingText"></label>
                            </div>

                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Request Token</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <!-- JavaScript Libraries -->
    <!-- JavaScript Bundle with Popper -->

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0/js/bootstrap.min.js" integrity="sha512-Pv/SmxhkTB6tWGQWDa6gHgJpfBdIpyUy59QkbshS1948GRmj6WgZz18PaDMOqaEyKLRAvgil7sx/WACNGE4Txw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script>
        function loadSuberb($id){
            $.ajax({
                type: "POST",
                url: '/get-suberb',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: 'dis_id='+$id,
                success: function(msg) {
                    $('#suberbList').html(msg);
                }
            });
        }
        function loadStation($subid){
            $.ajax({
                type: "POST",
                url: '/get-station',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: 'subid='+$subid,
                success: function(msg) {
                    $('#stationList').html(msg);
                }
            });
        }
    </script>
    <script>
        $('#request_form').on('submit', function(e) {

            e.preventDefault();

            $.ajax({
                type: "POST",
                url: '/make-reservation',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $(this).serialize(),
                success: function(msg) {

                    if (msg[0].code == 200) {
                        setTimeout(function() {
                            location.href="/make-payment";
                        }, 1500);
                    } else {
                        swal({
                            title: 'Error!',
                            text: msg[0].text,
                            icon: 'error',
                            timer: 3000,
                            button: false
                        }).then(
                            function() {},
                            function(dismiss) {
                                if (dismiss === 'timer') {}
                            }
                        )
                    }

                }
            });

        });
    </script>
</body>

</html>