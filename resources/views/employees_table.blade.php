<!doctype html>

<html class="no-js" lang="en">

<head>
    <!--====== USEFULL META ======-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Transportation & Agency Template is a simple Smooth transportation and Agency Based Template" />
    <meta name="keywords" content="Portfolio, Agency, Onepage, Html, Business, Blog, Parallax" />

    <!--====== TITLE TAG ======-->
    <title>LogUcab | Employees</title>

    <!--====== FAVICON ICON =======-->
    <link rel="shortcut icon" type="image/ico" href="img/favicon.png" />

    <!--====== STYLESHEETS ======-->
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/stellarnav.min.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="js/DataTables-1.10.18/css/dataTables.bootstrap.min.css"/>
    <script type="text/javascript" src="js/DataTables-1.10.18/css/datatables.min.js"></script>
    <script src="js/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
    <script src="js/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="js/DataTables-1.10.18/js/dataTables.bootstrap.min.js"></script>

    <!--====== MAIN STYLESHEETS ======-->
    <link href="style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">

    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    
</head>

<body class="home-one">
    <!--- PRELOADER -->
    <!-- <div class="preeloader">
        <div class="preloader-spinner"></div>
    </div> -->

    <!--SCROLL TO TOP-->
    <a href="#home" class="scrolltotop"><i class="fa fa-long-arrow-up"></i></a>

    <!--START TOP AREA-->
    <header class="top-area" id="home">
        <div class="top-area-bg" data-stellar-background-ratio="0.6"></div>
        <div class="header-top-area">
            <!--MAINMENU AREA-->
            <div class="mainmenu-area" id="mainmenu-area">
                <div class="mainmenu-area-bg"></div>
                <nav class="navbar">
                    <div class="container">
                        <div class="navbar-header">
                            <a href="{{url('/')}}" class="navbar-brand"><img src="img/logo.png" alt="logo"></a>
                        </div>
                        <div class="search-and-language-bar pull-right">
                            <ul>
                                <li><a href="{{url('/login')}}"><i class="fa fa-user" @if ($permissions > 0) title="Login" @endif></i></a></li>
                                @if ($permissions > 0)
                                <li><a href="{{url('/logout')}}"><i class="fa" title="Logout"></i>X</a></li> 
                                <!-- falta linkear el logout aqui -->
                                @endif
                                <li class="search-box"><i class="fa fa-search"></i></li>
                                <li class="select-language">
                                    <select name="#" id="#">
                                    <option selected value="End">ENG</option>
                                    <option value="ARA">ARA</option>
                                    <option value="CHI">CHI</option>
                                </select>
                                </li>
                            </ul>
                            <form action="#" class="search-form">
                                <input type="search" name="search" id="search">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <div id="main-nav" class="stellarnav">
                            <ul id="nav" class="nav navbar-nav">
                                <li><a href="{{url('/')}}">home</a></li>
                                @if(isset($permissions) && $permissions > 3)
                                    <li><a href="#">Clients</a>
                                        <ul>
                                            <li><a href="{{url('/clients')}}">Clients Table</a></li>
                                        </ul>
                                    </li>
                                @endif
                                @if(isset($permissions) && $permissions > 3)
                                    <li><a href="#">Employees</a>
                                        <ul>
                                            <li><a href="{{url('/employees')}}">Employees Table</a></li>
                                        </ul>
                                    </li>
                                @endif
                                @if(isset($permissions) && $permissions > 3)
                                    <li><a href="#">Franchises</a>
                                        <ul>
                                            <li><a href="{{url('/franchises')}}">Franchises Table</a></li>
                                        </ul>
                                    </li>
                                @endif
                                @if(isset($permissions) && $permissions > 3)
                                    <li><a href="#">Users & Rol</a>
                                        <ul>
                                            <li><a href="{{url('/users')}}">Users Table</a></li>
                                        </ul>
                                    </li>
                                @endif
                                @if(isset($permissions) && $permissions > 3)
                                    <li><a href="#">Routes & Transportation</a>
                                        <ul>
                                            <li><a href="{{url('/routes')}}">Routes Table</a></li>
                                        </ul>
                                    </li>
                                @endif
                                @if(isset($permissions) && $permissions > 3)
                                    <li><a href="#">Shipping</a>
                                        <ul>
                                            <li><a href="{{url('/ship')}}">Ship Package</a></li>
                                        </ul>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <!--END MAINMENU AREA END-->
        </div>

        <div class="datatables-area">
                <div class="table-responsive container">
                    <table class="table table-bordered table-hover dt-responsive custom-table" id="employees-table">
                        <thead>
                            <tr>
                                <th>Cedula</th>
                                <th>Nombre y Apellido</th>
                                <th>Email personal</th>
                                <th>Email corporativo</th>
                                <th>Fecha de Ingreso</th>
                                <th>Sucursal de Trabajo</th>
                                <th>Salario por Dia (Bs)</th>
                                <th>Dias Trabajados</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td>{{$employee->emp_cedula}}</td>
                                    <td>{{$employee->emp_nombre}}</td>
                                    <td>{{$employee->emp_ep}}</td>
                                    <td>{{$employee->emp_ec}}</td>
                                    <td>{{$employee->emp_fi}}</td>
                                    <td>{{$employee->suc_n}}</td>
                                    <td>{{$employee->emp_b}}</td>
                                    <td>30</td>
                                </tr>
                            @endforeach   
                        </tbody>
                    </table>
                </div>
        </div>

        <!--====== SCRIPTS JS ======-->
    <!-- <script src="js/vendor/jquery-1.12.4.min.js"></script> -->
    <script src="js/vendor/bootstrap.min.js"></script>

    <!--====== PLUGINS JS ======-->
    <script src="js/vendor/jquery.easing.1.3.js"></script>
    <script src="js/vendor/jquery-migrate-1.2.1.min.js"></script>
    <script src="js/vendor/jquery.appear.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/stellar.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/stellarnav.min.js"></script>
    <script src="js/contact-form.js"></script>
    <script src="js/jquery.sticky.js"></script>

    <!--===== ACTIVE JS =====-->
    <script src="js/main.js"></script>
    
</body>

</html>

<!--=====  DATA TABLE =====-->
<script>  
    $(document).ready(function(){  
            $('#employees-table').DataTable();  
    });  
</script> 