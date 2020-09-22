    @include('tamplate.header')
    
    @yield('header')
  <!-- Main Sidebar Container -->
    @include('tamplate.sidebar')
  <!-- Content Wrapper. Contains page content -->
    
    @yield('content')
    
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
    @include('tamplate.footer')
    @yield('footer')