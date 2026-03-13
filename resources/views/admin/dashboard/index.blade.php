@extends('admin.dashboard')

@section('admin')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 col-md-7 align-self-center">

                    @php
                        $hour = now()->format('H');

                        $greeting = match (true) {
                            $hour >= 5 && $hour < 11 => 'Selamat Pagi',
                            $hour >= 11 && $hour < 15 => 'Selamat Siang',
                            $hour >= 15 && $hour < 18 => 'Selamat Sore',
                            default => 'Selamat Malam',
                        };
                    @endphp

                    <h3 class="page-title text-dark font-weight-medium mb-1" style="word-break: break-word;">
                        {{ $greeting }}, {{ Auth::guard('admin')->user()->name }} 👋
                    </h3>

                </div>
            </div>
        </div>

        <!-- End Bread crumb and right sidebar toggle -->

        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- *************************************************************** -->
            <!-- Start First Cards -->
            <!-- *************************************************************** -->
            <div class="row">

                <!-- USERS -->
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">

                            <div class="d-flex align-items-center">

                                <div class="flex-grow-1">
                                    <h6 class="text-muted mb-1">Users</h6>
                                    <h2 class="fw-bold text-dark mb-0">
                                        {{ $totalUsers }}
                                    </h2>
                                </div>

                                <div class="bg-primary text-white rounded-circle p-3">
                                    <i data-feather="users"></i>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>


                <!-- TTE -->
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">

                            <div class="d-flex align-items-center">

                                <div class="flex-grow-1">
                                    <h6 class="text-muted mb-1">TTE</h6>
                                    <h2 class="fw-bold text-dark mb-0">
                                        {{ $totalTte }}
                                    </h2>
                                </div>

                                <div class="bg-success text-white rounded-circle p-3">
                                   <i data-feather="file-text"></i>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>


                <!-- IKASANDI -->
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">

                            <div class="d-flex align-items-center">

                                <div class="flex-grow-1">
                                    <h6 class="text-muted mb-1">IKASANDI</h6>
                                    <h2 class="fw-bold text-dark mb-0">
                                        {{ $totalIkasandi }}
                                    </h2>
                                </div>

                                <div class="bg-warning text-white rounded-circle p-3">
                                    <i data-feather="shield"></i>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>


                <!-- BERITA -->
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">

                            <div class="d-flex align-items-center">

                                <div class="flex-grow-1">
                                    <h6 class="text-muted mb-1">Berita</h6>
                                    <h2 class="fw-bold text-dark mb-0">
                                        {{ $totalBerita }}
                                    </h2>
                                </div>

                                <div class="bg-danger text-white rounded-circle p-3">
                                    <i data-feather="file-text"></i>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <!-- *************************************************************** -->
            <!-- End First Cards -->
            <!-- *************************************************************** -->
            <!-- *************************************************************** -->
            <!-- Start Sales Charts Section -->
            <!-- *************************************************************** -->
            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Total Sales</h4>
                            <div id="campaign-v2" class="mt-2" style="height:283px; width:100%;"></div>
                            <ul class="list-style-none mb-0">
                                <li>
                                    <i class="fas fa-circle text-primary font-10 mr-2"></i>
                                    <span class="text-muted">Direct Sales</span>
                                    <span class="text-dark float-right font-weight-medium">$2346</span>
                                </li>
                                <li class="mt-3">
                                    <i class="fas fa-circle text-danger font-10 mr-2"></i>
                                    <span class="text-muted">Referral Sales</span>
                                    <span class="text-dark float-right font-weight-medium">$2108</span>
                                </li>
                                <li class="mt-3">
                                    <i class="fas fa-circle text-cyan font-10 mr-2"></i>
                                    <span class="text-muted">Affiliate Sales</span>
                                    <span class="text-dark float-right font-weight-medium">$1204</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Net Income</h4>
                            <div class="net-income mt-4 position-relative" style="height:294px;"></div>
                            <ul class="list-inline text-center mt-5 mb-2">
                                <li class="list-inline-item text-muted font-italic">Sales for this month</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Earning by Location</h4>
                            <div class="" style="height:180px">
                                <div id="visitbylocate" style="height:100%"></div>
                            </div>
                            <div class="row mb-3 align-items-center mt-1 mt-5">
                                <div class="col-4 text-right">
                                    <span class="text-muted font-14">India</span>
                                </div>
                                <div class="col-5">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-3 text-right">
                                    <span class="mb-0 font-14 text-dark font-weight-medium">28%</span>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-4 text-right">
                                    <span class="text-muted font-14">UK</span>
                                </div>
                                <div class="col-5">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 74%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-3 text-right">
                                    <span class="mb-0 font-14 text-dark font-weight-medium">21%</span>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-4 text-right">
                                    <span class="text-muted font-14">USA</span>
                                </div>
                                <div class="col-5">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-cyan" role="progressbar" style="width: 60%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-3 text-right">
                                    <span class="mb-0 font-14 text-dark font-weight-medium">18%</span>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-4 text-right">
                                    <span class="text-muted font-14">China</span>
                                </div>
                                <div class="col-5">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 50%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-3 text-right">
                                    <span class="mb-0 font-14 text-dark font-weight-medium">12%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- *************************************************************** -->
            <!-- End Sales Charts Section -->
            <!-- *************************************************************** -->
            <!-- *************************************************************** -->
            <!-- Start Location and Earnings Charts Section -->
            <!-- *************************************************************** -->
            <div class="row">
                <div class="col-md-6 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <h4 class="card-title mb-0">Earning Statistics</h4>
                                <div class="ml-auto">
                                    <div class="dropdown sub-dropdown">
                                        <button class="btn btn-link text-muted dropdown-toggle" type="button"
                                            id="dd1" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i data-feather="more-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1">
                                            <a class="dropdown-item" href="#">Insert</a>
                                            <a class="dropdown-item" href="#">Update</a>
                                            <a class="dropdown-item" href="#">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pl-4 mb-5">
                                <div class="stats ct-charts position-relative" style="height: 315px;"></div>
                            </div>
                            <ul class="list-inline text-center mt-4 mb-0">
                                <li class="list-inline-item text-muted font-italic">Earnings for this month</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Recent Activity</h4>
                            <div class="mt-4 activity">
                                <div class="d-flex align-items-start border-left-line pb-3">
                                    <div>
                                        <a href="javascript:void(0)" class="btn btn-info btn-circle mb-2 btn-item">
                                            <i data-feather="shopping-cart"></i>
                                        </a>
                                    </div>
                                    <div class="ml-3 mt-2">
                                        <h5 class="text-dark font-weight-medium mb-2">New Product Sold!</h5>
                                        <p class="font-14 mb-2 text-muted">John Musa just purchased <br> Cannon 5M
                                            Camera.
                                        </p>
                                        <span class="font-weight-light font-14 text-muted">10 Minutes Ago</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start border-left-line pb-3">
                                    <div>
                                        <a href="javascript:void(0)" class="btn btn-danger btn-circle mb-2 btn-item">
                                            <i data-feather="message-square"></i>
                                        </a>
                                    </div>
                                    <div class="ml-3 mt-2">
                                        <h5 class="text-dark font-weight-medium mb-2">New Support Ticket</h5>
                                        <p class="font-14 mb-2 text-muted">Richardson just create support <br>
                                            ticket</p>
                                        <span class="font-weight-light font-14 text-muted">25 Minutes Ago</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start border-left-line">
                                    <div>
                                        <a href="javascript:void(0)" class="btn btn-cyan btn-circle mb-2 btn-item">
                                            <i data-feather="bell"></i>
                                        </a>
                                    </div>
                                    <div class="ml-3 mt-2">
                                        <h5 class="text-dark font-weight-medium mb-2">Notification Pending Order!
                                        </h5>
                                        <p class="font-14 mb-2 text-muted">One Pending order from Ryne <br> Doe</p>
                                        <span class="font-weight-light font-14 mb-1 d-block text-muted">2 Hours
                                            Ago</span>
                                        <a href="javascript:void(0)" class="font-14 border-bottom pb-1 border-info">Load
                                            More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- *************************************************************** -->
            <!-- End Location and Earnings Charts Section -->
            <!-- *************************************************************** -->
            <!-- *************************************************************** -->
            <!-- Start Top Leader Table -->
            <!-- *************************************************************** -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <h4 class="card-title">Top Leaders</h4>
                                <div class="ml-auto">
                                    <div class="dropdown sub-dropdown">
                                        <button class="btn btn-link text-muted dropdown-toggle" type="button"
                                            id="dd1" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i data-feather="more-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1">
                                            <a class="dropdown-item" href="#">Insert</a>
                                            <a class="dropdown-item" href="#">Update</a>
                                            <a class="dropdown-item" href="#">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table no-wrap v-middle mb-0">
                                    <thead>
                                        <tr class="border-0">
                                            <th class="border-0 font-14 font-weight-medium text-muted">Team Lead
                                            </th>
                                            <th class="border-0 font-14 font-weight-medium text-muted px-2">Project
                                            </th>
                                            <th class="border-0 font-14 font-weight-medium text-muted">Team</th>
                                            <th class="border-0 font-14 font-weight-medium text-muted text-center">
                                                Status
                                            </th>
                                            <th class="border-0 font-14 font-weight-medium text-muted text-center">
                                                Weeks
                                            </th>
                                            <th class="border-0 font-14 font-weight-medium text-muted">Budget</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border-top-0 px-2 py-4">
                                                <div class="d-flex no-block align-items-center">
                                                    <div class="mr-3"><img
                                                            src="assets/images/users/widget-table-pic1.jpg" alt="user"
                                                            class="rounded-circle" width="45" height="45" /></div>
                                                    <div class="">
                                                        <h5 class="text-dark mb-0 font-16 font-weight-medium">Hanna
                                                            Gover</h5>
                                                        <span class="text-muted font-14">hgover@gmail.com</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="border-top-0 text-muted px-2 py-4 font-14">Elite Admin</td>
                                            <td class="border-top-0 px-2 py-4">
                                                <div class="popover-icon">
                                                    <a class="btn btn-primary rounded-circle btn-circle font-12"
                                                        href="javascript:void(0)">DS</a>
                                                    <a class="btn btn-danger rounded-circle btn-circle font-12 popover-item"
                                                        href="javascript:void(0)">SS</a>
                                                    <a class="btn btn-cyan rounded-circle btn-circle font-12 popover-item"
                                                        href="javascript:void(0)">RP</a>
                                                    <a class="btn btn-success text-white rounded-circle btn-circle font-20"
                                                        href="javascript:void(0)">+</a>
                                                </div>
                                            </td>
                                            <td class="border-top-0 text-center px-2 py-4"><i
                                                    class="fa fa-circle text-primary font-12" data-toggle="tooltip"
                                                    data-placement="top" title="In Testing"></i></td>
                                            <td class="border-top-0 text-center font-weight-medium text-muted px-2 py-4">
                                                35
                                            </td>
                                            <td class="font-weight-medium text-dark border-top-0 px-2 py-4">$96K
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-4">
                                                <div class="d-flex no-block align-items-center">
                                                    <div class="mr-3"><img
                                                            src="assets/images/users/widget-table-pic2.jpg" alt="user"
                                                            class="rounded-circle" width="45" height="45" /></div>
                                                    <div class="">
                                                        <h5 class="text-dark mb-0 font-16 font-weight-medium">Daniel
                                                            Kristeen
                                                        </h5>
                                                        <span class="text-muted font-14">Kristeen@gmail.com</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-muted px-2 py-4 font-14">Real Homes WP Theme</td>
                                            <td class="px-2 py-4">
                                                <div class="popover-icon">
                                                    <a class="btn btn-primary rounded-circle btn-circle font-12"
                                                        href="javascript:void(0)">DS</a>
                                                    <a class="btn btn-danger rounded-circle btn-circle font-12 popover-item"
                                                        href="javascript:void(0)">SS</a>
                                                    <a class="btn btn-success text-white rounded-circle btn-circle font-20"
                                                        href="javascript:void(0)">+</a>
                                                </div>
                                            </td>
                                            <td class="text-center px-2 py-4"><i class="fa fa-circle text-success font-12"
                                                    data-toggle="tooltip" data-placement="top" title="Done"></i>
                                            </td>
                                            <td class="text-center text-muted font-weight-medium px-2 py-4">32</td>
                                            <td class="font-weight-medium text-dark px-2 py-4">$85K</td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-4">
                                                <div class="d-flex no-block align-items-center">
                                                    <div class="mr-3"><img
                                                            src="assets/images/users/widget-table-pic3.jpg" alt="user"
                                                            class="rounded-circle" width="45" height="45" /></div>
                                                    <div class="">
                                                        <h5 class="text-dark mb-0 font-16 font-weight-medium">Julian
                                                            Josephs
                                                        </h5>
                                                        <span class="text-muted font-14">Josephs@gmail.com</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-muted px-2 py-4 font-14">MedicalPro WP Theme</td>
                                            <td class="px-2 py-4">
                                                <div class="popover-icon">
                                                    <a class="btn btn-primary rounded-circle btn-circle font-12"
                                                        href="javascript:void(0)">DS</a>
                                                    <a class="btn btn-danger rounded-circle btn-circle font-12 popover-item"
                                                        href="javascript:void(0)">SS</a>
                                                    <a class="btn btn-cyan rounded-circle btn-circle font-12 popover-item"
                                                        href="javascript:void(0)">RP</a>
                                                    <a class="btn btn-success text-white rounded-circle btn-circle font-20"
                                                        href="javascript:void(0)">+</a>
                                                </div>
                                            </td>
                                            <td class="text-center px-2 py-4"><i class="fa fa-circle text-primary font-12"
                                                    data-toggle="tooltip" data-placement="top" title="Done"></i>
                                            </td>
                                            <td class="text-center text-muted font-weight-medium px-2 py-4">29</td>
                                            <td class="font-weight-medium text-dark px-2 py-4">$81K</td>
                                        </tr>
                                        <tr>
                                            <td class="px-2 py-4">
                                                <div class="d-flex no-block align-items-center">
                                                    <div class="mr-3"><img
                                                            src="assets/images/users/widget-table-pic4.jpg" alt="user"
                                                            class="rounded-circle" width="45" height="45" /></div>
                                                    <div class="">
                                                        <h5 class="text-dark mb-0 font-16 font-weight-medium">Jan
                                                            Petrovic
                                                        </h5>
                                                        <span class="text-muted font-14">hgover@gmail.com</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-muted px-2 py-4 font-14">Hosting Press HTML</td>
                                            <td class="px-2 py-4">
                                                <div class="popover-icon">
                                                    <a class="btn btn-primary rounded-circle btn-circle font-12"
                                                        href="javascript:void(0)">DS</a>
                                                    <a class="btn btn-success text-white font-20 rounded-circle btn-circle"
                                                        href="javascript:void(0)">+</a>
                                                </div>
                                            </td>
                                            <td class="text-center px-2 py-4"><i class="fa fa-circle text-danger font-12"
                                                    data-toggle="tooltip" data-placement="top" title="In Progress"></i>
                                            </td>
                                            <td class="text-center text-muted font-weight-medium px-2 py-4">23</td>
                                            <td class="font-weight-medium text-dark px-2 py-4">$80K</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- *************************************************************** -->
            <!-- End Top Leader Table -->
            <!-- *************************************************************** -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer text-center text-muted">
            All Rights Reserved by Adminmart. Designed and Developed by <a href="https://wrappixel.com">WrapPixel</a>.
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
@endsection
