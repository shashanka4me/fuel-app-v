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
                        <div class="m-n2">
                            <?php $type = request()->get('type'); ?>
                            <a href="{{url('/admin-filling-station?type=all')}}" type="button" class="btn <?php echo ($type == 'all')? 'btn-primary': 'btn-outline-primary'; ?> m-2">All</a>
                            <a href="{{url('/admin-filling-station?type=95')}}" type="button" class="btn <?php echo ($type == '95')? 'btn-primary': 'btn-outline-primary'; ?> m-2">Octain 95</a>
                            <a href="{{url('/admin-filling-station?type=92')}}" type="button" class="btn <?php echo ($type == '92')? 'btn-primary': 'btn-outline-primary'; ?> m-2">Octain 92</a>
                            <a href="{{url('/admin-filling-station?type=super')}}" type="button" class="btn <?php echo ($type == 'super')? 'btn-primary': 'btn-outline-primary'; ?> m-2">Super Diesel</a>
                            <a href="{{url('/admin-filling-station?type=diesel')}}" type="button" class="btn <?php echo ($type == 'diesel')? 'btn-primary': 'btn-outline-primary'; ?> m-2">Diesel</a>
                            <a href="{{url('/admin-filling-station?type=kerosene')}}" type="button" class="btn <?php echo ($type == 'kerosene')? 'btn-primary': 'btn-outline-primary'; ?> m-2">Kerosene oil</a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4"></h6>

                            <div class="table-responsive">
                                <table class="table">

                                    <tbody>
                                        <?php foreach($all_orders as $orderval):?>
                                        <tr>
                                           
                                            <td><?php echo $orderval->station_name ?></td>
                                            <td><?php echo $orderval->suberbname ?></td>
                                            <td><?php echo $orderval->fuel_type ?></td>
                                            <td><?php echo $orderval->qty ?></td>
                                            <td><?php echo $orderval->date ?></td>
                                            <td>
                                                <button type="button" class="btn btn-success " onclick="statusChangeQT('<?php echo $orderval->id ?>',1)">Approve</button>
                                                <button type="button" class="btn btn-danger" onclick="statusChangeQT('<?php echo $orderval->id ?>',2)">Reject</button>
                                            </td>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                       
                                    </tbody>
                                </table>
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
        function statusChangeQT($id,$status) {
            
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
                        setTimeout(function(){
                            location.reload();
                        },1500);

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