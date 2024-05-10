<?php
  if(strlen(session_id()) < 1) //Si la variable de session no esta iniciada
  {
    session_start();
  } 
  if(isset($_COOKIE['sistema']))
  if($_COOKIE['sistema'] != '3'){
    session_unset(); //Limpiamos las variables de sesion
    session_destroy(); //Destriumos la sesion
    //   if (isset($_SERVER['HTTP_SESSION'])) {
    //     $SESSIONs = explode(';', $_SERVER['HTTP_SESSION']);
    //     foreach($SESSIONs as $SESSION) {
    //         $parts = explode('=', $SESSION);
    //         $name = trim($parts[0]);
    //         setSESSION($name, '', time()-1000);
    //         setSESSION($name, '', time()-1000, '/');
    //     }
    // }
    header("Location: login.html");
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SRI | Incidentes</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
    <link rel="shortcut icon" href="../public/img/avedis_favicon.ico">

    <!--DATATABLES-->
    <link rel="stylesheet" href="../public/datatables/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../public/datatables/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../public/datatables/responsive.dataTables.min.css">
    
    <link rel="stylesheet" href="../public/css/bootstrap-select.min.css">
    

  </head>
  <body class="hold-transition skin-black sidebar-mini">
    <div class="wrapper">

      <header class="main-header">

        <!-- Logo -->
        <a href="escritorio.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>SRI</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Incidentes</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo $_SESSION['nombre']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                    <p>
                      Sistemas
                      <small>Avedis</small>
                    </p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    
                    <div class="pull-right">
                      <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Cerrar</a>
                    </div>
                  </li>
                </ul>
              </li>
              
            </ul>
          </div>

        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">       
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"></li>
            <?php
              if($_SESSION['escritorio'] == 1)
              {
                echo 
                '<li>
                  <a href="escritorio.php">
                    <i class="fa fa-tasks"></i> <span>Escritorio</span>
                  </a>
                </li>';
              }

            //   if($_SESSION['ABM'] == 1)
            //   {
            //     echo 
            //     '<li class="treeview">
            //         <a href="#">
            //           <i class="fa fa-file"></i>
            //           <span>Gestionar Documentos</span>
            //           <i class="fa fa-angle-left pull-right"></i>
            //         </a>
            //         <ul class="treeview-menu">
					  // <li><a href="tipodocumento.php"><i class="fa fa-circle-o"></i> Tipos de Documento</a></li>
					  // <li><a href="documento.php"><i class="fa fa-circle-o"></i> Documentos</a></li>
					  // <li><a href="relacionproins.php"><i class="fa fa-circle-o"></i> Relación Proc Inst</a></li>
					  
            //         </ul>
            //       </li>'
            //      ;
            //   }
            
            if($_SESSION['acceso'] == 1)
              {
                echo 
                '<li class="treeview">
                <a href="#">
                <i class="fa fa-users"></i> <span>Acceso</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                <li><a href="usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                <li><a href="permiso.php"><i class="fa fa-circle-o"></i> Permisos</a></li>
                
                </ul>
                    </li>
                  '
                 ;
                }
               if($_SESSION['administracion'] == 1)
               {
                 echo 
                 '<li class="treeview">
                 <a href="#">
                 <i class="fa fa-users"></i> <span>Datos de Avedis</span>
                 <i class="fa fa-angle-left pull-right"></i>
                 </a>
                 <ul class="treeview-menu">
                 <li><a href="sector.php"><i class="fa fa-circle-o"></i>Sectores</a></li>
                 <li><a href="cliente.php"><i class="fa fa-circle-o"></i>Personas</a></li>
                 </ul>
                 </li>';}
                 if($_SESSION['ABM'] == 1)
                 {echo
                 '<li class="treeview">
                 <a href="reporteIncidentes.php"><i class="fa fa-book"></i> <span>Reporte de Incidentes</span>
                 </a>
                 
                 </li>'
                  ;
               }
               
            ?>                                
          
            <li>
              <a href="#">
                <i class="fa fa-plus-square"></i> <span>Ayuda</span>
                <small class="label pull-right bg-red">PDF</small>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
                <small class="label pull-right bg-yellow">IT</small>
              </a>
            </li>
                        
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

    