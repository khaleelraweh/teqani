<?php $rtl = config('locales.languages')[app()->getLocale()]['rtl_support'] == 'rtl' ? '-rtl' : ''; ?>
{{-- if there is no cookie yet then make it dark else check the cookie value --}}
<?php $dark = Cookie::get('theme') !== null ? (Cookie::get('theme') == 'dark' ? '-dark' : '') : '-dark'; ?>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir=<?php echo $rtl ? 'rtl' : ''; ?>>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Premium Multipurpose Admin & Dashboard Template" />
    <meta name="robots" content="all,follow">
    <meta name="author" content="Themesdesign" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/images/favicon.ico') }}">

    <title> Dashboard | {{ config('app.name', 'Laravel') }} - Admin & Dashboard Template </title>

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Google fonts-->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@300;400;700&amp;display=swap">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Martel+Sans:wght@300;400;800&amp;display=swap">

    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- jquery.vectormap css -->
    <link href="{{ asset('backend/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{ asset('backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('backend/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    {{-- Responsive fileInput --}}
    <link rel="stylesheet" href="{{ asset('backend/vendor/bootstrap-fileinput/css/fileinput.min.css') }}">

    {{-- select2 libs --}}
    <link rel="stylesheet" href="{{ asset('backend/vendor/select2/css/select2.min.css') }}">

    {{-- pickadate calling css --}}
    <link rel="stylesheet" href="{{ asset('backend/vendor/datepicker/themes/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendor/datepicker/themes/classic.date.css') }}">
    <!-- fontawesome icon  picker  -->
    <link href="{{ asset('backend/vendor/fontawesomepicker/css/fontawesome-iconpicker.css') }}" rel="stylesheet">



    <!-- Bootstrap Css -->
    {{-- <link href="{{asset('backend/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" /> --}}
    {{-- <link href="{{ asset('backend/css/bootstrap-rtl.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" /> --}}

    <link href="<?php echo asset('backend/css/bootstrap' . $dark . $rtl . '.min.css'); ?>" id="bootstrap-style" rel="stylesheet" type="text/css">


    <!-- Icons Css -->
    <link href="{{ asset('backend/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App Css-->
    {{-- <link href="{{asset('backend/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />  --}}
    {{-- <link href="{{ asset('backend/css/app-rtl.min.css') }}" id="app-style" rel="stylesheet" type="text/css" /> --}}

    <link href="<?php echo asset('backend/css/app' . $dark . $rtl . '.min.css'); ?>" id="app-style" rel="stylesheet" type="text/css">


    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>

    @yield('style')
</head>

<body data-topbar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <div id="app">

        <!-- Begin page -->
        <div id="layout-wrapper">

            <!-- start  page-topbar -->
            @include('partial.backend.topbar')
            <!-- end  page-topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            @include('partial.backend.vertical-menu')
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">

                    <div class="container-fluid">
                        @yield('content')
                    </div>

                </div>
                <!-- End Page-content -->
                @include('partial.backend.footer')

            </div>
            <!-- end main content-->


        </div>
        <!-- END layout-wrapper -->

        <!-- Right Sidebar -->
        @include('partial.backend.rightbar')
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

    </div>



    <!-- JAVASCRIPT -->
    <script src="{{ asset('backend/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/libs/node-waves/waves.min.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ asset('backend/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- jquery.vectormap map -->
    <script src="{{ asset('backend/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('backend/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}">
    </script>

    <!-- Required datatable js -->
    <script src="{{ asset('backend/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('backend/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('backend/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('backend/js/pages/dashboard.init.js') }}"></script>


    <!-- Responsive fileInput js start -->
    <script src="{{ asset('backend/vendor/bootstrap-fileinput/js/plugins/piexif.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap-fileinput/js/plugins/sortable.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap-fileinput/themes/fa5/theme.min.js') }}"></script>

    {{-- Call select2 plugin --}}
    <script src="{{ asset('backend/vendor/select2/js/select2.full.min.js') }}"></script>

    {{-- pickadate calling js --}}
    <script src="{{ asset('backend/vendor/datepicker/picker.js') }}"></script>
    <script src="{{ asset('backend/vendor/datepicker/picker.date.js') }}"></script>
    <script src="{{ asset('backend/vendor/datepicker/picker.time.js') }}"></script>
    {{-- Calling fontawesome icon picker   --}}
    <script src="{{ asset('backend/vendor/fontawesomepicker/js/fontawesome-iconpicker.js') }}"></script>

    <!--tinymce js for editor -->
    <script src="{{ asset('backend/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('backend/js/pages/form-editor.js') }}"></script>


    <!-- App js -->
    <script src="{{ asset('backend/js/app.js') }}"></script>



    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        $(function() {
            $('.icon-picker').iconpicker();
        });
    </script>

    <script>
        //select2: code to search in data 
        function matchStart(params, data) {
            // If there are no search terms, return all of the data
            if ($.trim(params.term) === '') {
                return data;
            }

            // Skip if there is no 'children' property
            if (typeof data.children === 'undefined') {
                return null;
            }

            // `data.children` contains the actual options that we are matching against
            var filteredChildren = [];
            $.each(data.children, function(idx, child) {
                if (child.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
                    filteredChildren.push(child);
                }
            });

            // If we matched any of the timezone group's children, then set the matched children on the group
            // and return the group object
            if (filteredChildren.length) {
                var modifiedData = $.extend({}, data, true);
                modifiedData.children = filteredChildren;

                // You can return modified objects from here
                // This includes matching the `children` how you want in nested data sets
                return modifiedData;
            }

            // Return `null` if the term should not be displayed
            return null;
        }

        // select2 : .select2 : is  identifier used with element to be effected
        $(".select2").select2({
            tags: true,
            colseOnSelect: false,
            minimumResultsForSearch: Infinity,
            matcher: matchStart
        });
    </script>


    @yield('script')


</body>

</html>
