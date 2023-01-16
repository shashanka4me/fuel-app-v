<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.common.head-style')
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


        <!-- Sidebar Start -->
        @include('admin.common.sidebar')
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            @include('admin.common.header')
            <!-- Navbar End -->


            <!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    
                    <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Registered Vehicle</h6>
                            <div class="col-sm-12 col-md-12 col-xl-12">
                                <div class="h-100 bg-light rounded p-4">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="col-6"> </div>
                                        <div class="form-floating mb-3 justify-content-end">
                                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                                <option selected="">Select</option>
                                                <option value="1">Sort By : Heavy Vehicle</option>
                                                <option value="2">Sort By : Light Vehicle</option>
                                            </select>
                                            <label for="floatingSelect">Sort By Type</label>
                                        </div>
                                    </div>
                                    <?php foreach ($all_customers as $val) : ?>
                                        <div class="d-flex align-items-center border-bottom py-3">
                                            <img class="rounded-circle flex-shrink-0" src="img/vehicle.png" alt="" style="width: 80px; height: 80px;">
                                            <div class="w-100 ms-3">
                                                <div class=" w-100 justify-content-between">
                                                    <h6 class="mb-3">Name : <?php echo $val->name ?></h6>
                                                    <h6 class="mb-3">vehicle No : <?php echo $val->vehicle_no ?> </h6>
                                                    <h6 class="mb-3">Chassis No : <?php echo $val->chassis_no ?> </h6>
                                                    <h6 class="mb-3">Vehicle Type : </h6>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            </div>



                        </div>
                    </div>
                </div>

            </div>
            <!-- Blank End -->


            <!-- Footer Start -->
            @include('admin.common.footer')
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    @include('admin.common.footer-script')

    <script>
        function statusChangeQT($id, $status) {

            $.ajax({
                type: "POST",
                url: '/update-order-request',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: 'id=' + $id + "&status=" + $status,
                success: function(msg) {

                    if (msg[0].code == 200) {
                        swal({
                            title: 'Success!',
                            text: msg[0].text,
                            icon: 'success',
                            timer: 1500,
                            button: false
                        })
                        setTimeout(function() {
                            location.reload();
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
        }
    </script>

</body>

</html>