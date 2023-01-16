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
                
                <div class="row  bg-light rounded align-items-center justify-content-center mx-0">
                    <div class="col-md-12 text-center">
                        <div class="col-sm-12 col-md-12 col-xl-12">
                            <div class="h-100 bg-light rounded p-4">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <h6 class="mb-0">Fuel Stock</h6>
                                </div>
                                <?php foreach ($stock_data as $val) : ?>
                                    <div class="d-flex mb-2">
                                        <input class="form-control bg-transparent" type="text" value="<?php echo $val->name ?> (L)" readonly>
                                        <input class="form-control bg-transparent" type="number" placeholder="" value="<?php echo $val->weekly_quota ?>" id="quota_<?php echo $val->id ?>">
                                        <button type="button" class="btn btn-primary ms-2" onclick="updateQuota(<?php echo $val->id ?>)">update</button>
                                    </div>
                                <?php endforeach; ?>

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
        function updateQuota($id) {
            var idname = 'quota_' + $id;
            console.log(idname);
            var value = $("#" + idname).val();
            $.ajax({
                type: "POST",
                url: '/update-weekly-quota',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: 'id=' + $id + "&value=" + value,
                success: function(msg) {

                    if (msg[0].code == 200) {
                        swal({
                            title: 'Success!',
                            text: msg[0].text,
                            icon: 'success',
                            timer: 3000,
                            button: false
                        })

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