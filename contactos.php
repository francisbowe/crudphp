<?php

	session_start();
	
	if(!isset($_SESSION['id'])){
		header("Location: index.php");
	}
	
	$nombre = $_SESSION['nombre'];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	
	
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Assistente ISPLB</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
	</head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="principal.php">Assistente ISPLB</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="principal.php"><i class="fas fa-bars"></i></button>

            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $nombre; ?><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                       
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Sair</a>
					</div>
				</li>
			</ul>
		</nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="index.html"
							><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Assistente ISPLB</a
							>
							
							<?php if($tipo_usuario == 1) { ?>
								
								<div class="sb-sidenav-menu-heading">Menu</div>
								<a id="cursos" class="nav-link" href="cursos.php" 
								><div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
									Cursos
									</a>
								
									<a id="contactos" class="nav-link" href="contactos.php" 
								><div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
									Contactos
									</a>
								
									<a id="contas" class="nav-link" href="contas.php" 
								><div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
									Contas
									</a>
								
									<a id="propinas" class="nav-link" href="propina.php" 
								><div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
									Propinas
									</a>

                                   

									<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages"
									><div class="sb-nav-link-icon"></div>
										
										<div class="sb-sidenav-collapse-arrow"></div
										></a>
										<div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
											<nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
												<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth"
												>Authentication
													<div class="sb-sidenav-collapse-arrow"></i></div
													></a>
													<div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
														<nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="login.html">Login</a><a class="nav-link" href="register.html">Register</a><a class="nav-link" href="password.html">Forgot Password</a></nav>
													</div>
													<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError"
													>Error
														<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
														></a>
														<div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
															<nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="401.html">401 Page</a><a class="nav-link" href="404.html">404 Page</a><a class="nav-link" href="500.html">500 Page</a></nav>
														</div>
											</nav>
										</div>
										
							<?php } ?>
							
							<div class="sb-sidenav-menu-heading">Addons</div>
							
								<a class="nav-link" href="tabla.php"
								><div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
									Tables</a
								>
							</div>
					</div>

				</nav>
			</div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Menu Contactos</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Assistente ISPLB</li>
						</ol>



					</div>
				</main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Densenvolvido Por Francisco Domingos</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
							</div>
						</div>
					</div>
				</footer>
			</div>
		</div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
	</body>
</html>
