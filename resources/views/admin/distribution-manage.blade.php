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
                    <div class="bg-light rounded h-100 p-4">
                        <h6 class="mb-4">Filing Stations- Qt Request</h6>
                        <div class="m-n2 d-flex">
                            <?php $type = request()->get('type'); ?>
                            <a href="{{url('/admin-filling-station?type=all')}}" type="button" class="btn <?php echo ($type == 'all') ? 'btn-primary' : 'btn-outline-primary'; ?> m-2">All</a>
                            <a href="{{url('/admin-fuel-distribution?type=95')}}" type="button" class="btn <?php echo ($type == '95') ? 'btn-primary' : 'btn-outline-primary'; ?> m-2">Octain 95</a>
                            <a href="{{url('/admin-fuel-distribution?type=92')}}" type="button" class="btn <?php echo ($type == '92') ? 'btn-primary' : 'btn-outline-primary'; ?> m-2">Octain 92</a>
                            <a href="{{url('/admin-fuel-distribution?type=super')}}" type="button" class="btn <?php echo ($type == 'super') ? 'btn-primary' : 'btn-outline-primary'; ?> m-2">Super Diesel</a>
                            <a href="{{url('/admin-fuel-distribution?type=diesel')}}" type="button" class="btn <?php echo ($type == 'diesel') ? 'btn-primary' : 'btn-outline-primary'; ?> m-2">Diesel</a>
                            <a href="{{url('/admin-fuel-distribution?type=kerosene')}}" type="button" class="btn <?php echo ($type == 'kerosene') ? 'btn-primary' : 'btn-outline-primary'; ?> m-2">Kerosene oil</a>

                        </div>

                    </div>
                    <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4"></h6>



                            <div class="col-sm-12 col-md-12 col-xl-12">
                                <div class="h-100 bg-light rounded p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="col-6"> </div>
                                        <div class="form-floating mb-3 justify-content-end">
                                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                                <option selected="">Select</option>
                                                <option value="1">Sort By : Low Stock</option>
                                                <option value="2">Sort By : High Stock</option>
                                            </select>
                                            <label for="floatingSelect">Sort By</label>
                                        </div>
                                    </div>
                                    <?php foreach ($all_station as $val) : ?>
                                        <div class="d-flex align-items-center border-bottom py-3">
                                            <img class="rounded-circle flex-shrink-0" src="img/oil-station.png" alt="" style="width: 80px; height: 80px;">
                                            <div class="w-100 ms-3">
                                                <div class=" w-100 justify-content-between">
                                                    <h6 class="mb-3">Name : <?php echo $val->name ?></h6>
                                                    <h6 class="mb-3">Max Capacity : <?php echo $val->max_volume ?> L</h6>
                                                    <h6 class="mb-3">Avalable Stock : <?php echo $val->available_volume ?> L</h6>
                                                    <h6 class="mb-3">Location : <?php echo $val->suberdata->name ?> / <?php echo $val->districtdatat->name ?></h6>
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