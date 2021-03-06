<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>JPV | Herramienta YTT</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">

    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>

    </ul>

    <!-- SEARCH FORM -->
      

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ URL::to('/') }}/home" class="brand-link">
      <img src="{{ URL::to('/') }}/img/server.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">YTT</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img src="{{ URL::to('/') }}/img/profile/{{ Auth::user()->photo }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <router-link to="/profile" class="d-block" style="background-color: transparent; color:#C2C7D0;">
              {{Auth::user()->name}}
          </router-link>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
            <router-link to="/home" class="nav-link">
              <i class="nav-icon fas fa-home blue"></i>
              <p>
                Inicio
              </p>
            </router-link>
          </li>

          {{-- <li class="nav-item">
            <router-link to="/data" class="nav-link">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Datos
              </p>
            </router-link>
          </li> --}}
          @if(!Gate::check('isAdmin'))
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-bar green"></i>
              <p>
                Reportes
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/global_report" class="nav-link">
                  <i class="fas fa-bookmark nav-icon"></i>
                  <p>Reporte global</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/comparative_report" class="nav-link">
                  <i class="fas fa-bookmark nav-icon"></i>
                  <p>Reporte comparativo</p>
                </router-link>
              </li>
              {{-- <li class="nav-item">
                <router-link to="/progress_report" class="nav-link">
                  <i class="fas fa-bookmark nav-icon"></i>
                  <p>Reporte de progreso</p>
                </router-link>
              </li> --}}
            </ul>
          </li>
          @endif

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book grey"></i>
              <p>
                Recursos
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/resources-yttv1" class="nav-link">
                  <i class="fas fa-bookmark nav-icon"></i>
                  <p>YTT v1</p>
                </router-link>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/resources-yttv2" class="nav-link">
                  <i class="fas fa-bookmark nav-icon"></i>
                  <p>YTT v2</p>
                </router-link>
              </li>
            </ul>
          </li>

        @if(Gate::check('isAdmin') || Gate::check('isAuthor'))
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-cog green"></i>
              <p>
                Administración
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/app" class="nav-link">
                  <i class="fas fa-toolbox nav-icon"></i>
                  @if(Gate::check('isAdmin'))
                    Organizaciones
                  @else
                    Personas usuarias
                  @endif
                </router-link>
              </li>
            </ul>
          </li>
        @endif
        {{-- @if(Gate::check('isAdmin') )
        <li class="nav-item">
          <router-link to="/developer" class="nav-link">
            <i class="nav-icon fas fa-cogs"></i>
            <p>

              Desarrollador
            </p>
          </router-link>
       </li>
       @endif --}}
          <li class="nav-item">
            <a class="nav-link pointer" @click="openHelpDesk">
              <i class="nav-icon fas fa-question-circle blue"></i>
              <p class="text-white">
                Ayuda
              </p>
            </a>
          </li>
          <li class="nav-item">
            <router-link to="/profile" class="nav-link">
              <i class="nav-icon fas fa-user orange"></i>
              <p>
                Perfil
              </p>
            </router-link>
         </li>

          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="nav-icon fa fa-power-off red"></i>
              <p>
                {{ __('Cerrar sesión') }}
              </p>
            </a>

           <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
           </form>
        </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <router-view></router-view>

        <!-- Modal -->
        <div class="modal fade" id="helpdesk" tabindex="-1" role="dialog" aria-labelledby="helpdeskLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
              <h3 id="helpdeskLabel" class="font-weight-bold text-uppercase">Solicitud de ayuda</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
              </div>
              
              <div class="modal-body">
                  <help-desk />
              </div>       
          </div>
          </div>
        </div>

        <vue-progress-bar></vue-progress-bar>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <img src="{{ URL::to('/') }}/img/usaid_logo.png" style="width:120px;" alt="usaid-logo">
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2019 USAID.</strong> Todos los derechos reservados.
  </footer>
</div>
<!-- ./wrapper -->

@auth
<script>
    window.user = @json(auth()->user())
</script>
@endauth

<script src="/js/app.js"></script>
</body>
</html>
