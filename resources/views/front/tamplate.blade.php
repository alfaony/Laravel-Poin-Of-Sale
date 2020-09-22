<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Bootstrap-ecommerce by Vosidiy">
  <title>IBARAKI KOFFIE</title>
  <link rel="shortcut icon" type="image/x-icon" href="assets/images/logos/squanchy.jpg" >
  <link rel="apple-touch-icon" sizes="180x180" href="assets/images/logos/squanchy.jpg">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/images/logos/squanchy.jpg">
  <!-- jQuery -->
  <!-- Bootstrap4 files-->
  <link href="{{asset('transaksi/css/bootstrap.css')}}" rel="stylesheet" type="text/css"/> 
  <link href="{{asset('transaksi/css/ui.css')}}" rel="stylesheet" type="text/css"/>
  <link href="{{asset('transaksi/fonts/fontawesome/css/fontawesome-all.min.css')}}" type="text/css" rel="stylesheet">
  <link href="{{asset('transaksi/css/OverlayScrollbars.css')}}" type="text/css" rel="stylesheet"/>
  <!-- Font awesome 5 -->
  <style>
    .avatar {
    vertical-align: middle;
    width: 35px;
    height: 35px;
    border-radius: 50%;
  }
  .bg-default, .btn-default{
    background-color: #f2f3f8;
  }
  .btn-error{
    color: #ef5f5f;
  }
  .anyClass {
    height:150px;
    overflow-y: scroll;
  }
  .bar {
    max-width: 300px;
  }
  * {
  box-sizing: border-box;
}

#cardTimeline {
  background-color: #474e5d;
  font-family: Helvetica, sans-serif;
}

/* The actual timeline (the vertical ruler) */
.timeline {
  position: relative;
  max-width: 1200px;
  margin: 0 auto;
}

/* The actual timeline (the vertical ruler) */
.timeline::after {
  content: '';
  position: absolute;
  width: 6px;
  background-color: white;
  top: 0;
  bottom: 0;
  left: 50%;
  margin-left: -3px;
}

/* Container around content */
.container {
  padding: 3px 20px;
  position: relative;
  background-color: inherit;
  width: 50%;
}

/* The circles on the timeline */
.container::after {
  content: '';
  position: absolute;
  width: 25px;
  height: 25px;
  right: -17px;
  background-color: white;
  border: 4px solid #FF9F55;
  top: 15px;
  border-radius: 50%;
  z-index: 1;
}

/* Place the container to the left */
.left {
  left: -25%;
}

/* Place the container to the right */
.right {
  left: 25%;
}

/* Add arrows to the left container (pointing right) */
.left::before {
  content: " ";
  height: 0;
  position: absolute;
  top: 22px;
  width: 0;
  z-index: 1;
  right: 30px;
  border: medium solid white;
  border-width: 10px 0 10px 10px;
  border-color: transparent transparent transparent white;
}

/* Add arrows to the right container (pointing left) */
.right::before {
  content: " ";
  height: 0;
  position: absolute;
  top: 22px;
  width: 0;
  z-index: 1;
  left: 30px;
  border: medium solid white;
  border-width: 5px 5px 5px 0;
  border-color: transparent white transparent transparent;
}

/* Fix the circle for containers on the right side */
.right::after {
  left: -16px;
}

/* The actual content */
.content {
  padding: 10px 10px;
  background-color: white;
  position: relative;
  border-radius: 6px;
}

/* Media queries - Responsive timeline on screens less than 600px wide */
@media screen and (max-width: 600px) {
  /* Place the timelime to the left */
  .timeline::after {
  left: 31px;
  }
  
  /* Full-width containers */
  .container {
  width: 100%;
  padding-left: 70px;
  padding-right: 25px;
  }
  
  /* Make sure that all arrows are pointing leftwards */
  .container::before {
  left: 60px;
  border: medium solid white;
  border-width: 10px 10px 10px 0;
  border-color: transparent white transparent transparent;
  }

  /* Make sure all circles are at the same spot */
  .left::after, .right::after {
  left: 15px;
  }
  
  /* Make all right containers behave like the left ones */
  .right {
  left: 0%;
  }
}
  </style>
  @yield('header')
<!-- custom style -->
</head>
<body>

  @yield('content')
</body>
  <!-- REQUIRED SCRIPTS -->
  <script src="{{asset('tamplate/plugins/jquery/jquery.min.js')}}"></script>
  <!-- Bootstrap -->
  <script src="{{asset('tamplate/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- overlayScrollbars -->
  <script src="{{asset('tamplate/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('tamplate/dist/js/adminlte.js')}}"></script>

  @yield('footer')
</html>