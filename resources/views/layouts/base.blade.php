<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('meta')

    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/css/font-awesome.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,300,400,500,700,900" rel="stylesheet">

    <link rel="stylesheet" href="{{ url('/') }}/assets/css/templatemo-softy-pinko.css">
    <style>
        .cust-bg {
            /* background-image: url('{{ url('/') }}/assets/images/bg.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background-size: cover; */
            background-color: #faf05f;
            /* background-image: linear-gradient(127deg, #fcfaa1 0%, #f0ec1c  91%); */
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            position: relatife;
            color: #fff;
        }
    </style>
    <style>
        .card-body {
            padding: 0px;
        }
    </style>

    @stack('css')
</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader" style="background-image: linear-gradient(
        127deg, #fcfaa1 0%, #f0ec1c  91%);">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    @include('components.client.header')


    @yield('contents')
    <!-- ***** Features Big Item End ***** -->

    <!-- ***** Footer Start ***** -->
    <footer style="background-image: linear-gradient(
        127deg, #faf4a9 0%, #f0ec1c 91%);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p class="copyright" style="color:black">Copyright &copy; 2021 Team Develops - Kokobi.id</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="{{ url('/') }}/assets/js/jquery-2.1.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="{{ url('/') }}/assets/js/popper.js"></script>
    <script src="{{ url('/') }}/assets/js/bootstrap.min.js"></script>

    <!-- Plugins -->
    <script src="{{ url('/') }}/assets/js/scrollreveal.min.js"></script>
    <script src="{{ url('/') }}/assets/js/waypoints.min.js"></script>
    <script src="{{ url('/') }}/assets/js/jquery.counterup.min.js"></script>
    <script src="{{ url('/') }}/assets/js/imgfix.min.js"></script>

    <!-- Global Init -->
    <script src="{{ url('/') }}/assets/js/custom.js?v=1"></script>

    @stack('js')
</body>

</html>
