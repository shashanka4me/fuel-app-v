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

                    @include('station.common')
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <?php if ($paid == 1) :
                            $paymsg = "The payment has been done";
                            $css_class = "text-success";

                        else :
                            $paymsg = "Due Payment";
                            $css_class = "text-warning";
                        endif; ?>

                        <h6 class="text-center">Verify the token</h6>
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <p>The provided token number is verified</p>
                                <h5 class="mb-1 {{$css_class}}"><?php echo $last_reservation_list->token_no ?></h5>
                                <p class="mt-3">{{$stationData->name}}</p>
                                <p class="mt-3">{{$customerData->vehicle_no}}</p>
                                <p class="mb-1"><?php echo $last_reservation_list->reserve_date ?> <?php echo $last_reservation_list->reserve_time ?> </p>
                                <h5 class="mb-1 {{$css_class}}"><?php echo $last_reservation_list->request_quata ?> L</h5>
                                <p>Rs.<?php echo $last_reservation_list->amount ?></p>
                                <h6 class="mb-1 {{$css_class}}"> {{$paymsg}} </h6>
                            </div>
                        </div>


                        <form id="payment_form">

                            <input type="hidden" name="id" value="<?php echo $last_reservation_list->id ?>">
                            <input type="hidden" name="amount" value="<?php echo $last_reservation_list->amount ?>">
                            <input type="hidden" name="station" value="<?php echo $last_reservation_list->station_id ?>">
                            <input type="hidden" name="payment_status" value="<?php echo $last_reservation_list->payment_status ?>">
                            <?php if (($paid == 0) && ($isvaliddate == 1) && ($released == 0)) : ?>
                                <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Payement Accepted</button>
                            <?php elseif (($paid == 1)  && ($released == 0)) : ?>
                                <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Release Fuel</button>
                            <?php endif; ?>
                        </form>


                        <?php if (($isvaliddate == 0) && ($released == 0) && ($paid == 0)) : ?>
                            <div class="text-center">
                                <h6 class="text-danger text-center">The provided token was expired</h6>
                            </div>
                            <div class="text-center">
                                <a href="{{url('/fuel-issue')}}" class="btn btn-primary ">Try Again</a>
                            </div>

                        <?php endif; ?>

                        <?php if (($released == 1)) : ?>
                            <div class="text-center">
                                <h6 class="text-danger text-center">The provided token is already used</h6>
                            </div>
                            <div class="text-center">
                                <a href="{{url('/fuel-issue')}}" class="btn btn-primary ">Try Again</a>
                            </div>
                        <?php endif; ?>




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
    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $('#payment_form').on('submit', function(e) {

            e.preventDefault();

            $.ajax({
                type: "POST",
                url: '/fuel-released',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $(this).serialize(),
                success: function(msg) {

                    if (msg[0].code == 200) {
                        swal({
                            title: 'Success!',
                            text: msg[0].text,
                            icon: 'success',
                            timer: 3000,
                            button: false
                        })
                        setTimeout(function() {
                            location.href = '/fuel-issue';
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