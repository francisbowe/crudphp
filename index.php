<?php
session_start();

// Conexão com a primeira base de dados
$mysqli1 = new mysqli("localhost", "root", "", "sistema");
if ($mysqli1->connect_error) {
    die("Conexão falhou: " . $mysqli1->connect_error);
}

if ($_POST) {
    $usuario = $mysqli1->real_escape_string($_POST['usuario']);
    $password = $mysqli1->real_escape_string($_POST['password']);

    $sql = "SELECT id, password, nombre, tipo_usuario FROM usuarios WHERE usuario='$usuario'";
    $resultado = $mysqli1->query($sql);
    $num = $resultado->num_rows;

    if ($num > 0) {
        $row = $resultado->fetch_assoc();
        $password_bd = $row['password'];
        $pass_c = sha1($password);

        if ($password_bd == $pass_c) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['tipo_usuario'] = $row['tipo_usuario'];

            header("Location: principal.php");
            exit();
        } else {
            $_SESSION['status'] = "Credenciais Erradas!";
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['status'] = "Não existe o usuário.";
        header("Location: index.php");
        exit();
    }
}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">

                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <div class="form-group"><label class="small mb-1" for="inputEmailAddress">Usuario</label><input class="form-control py-4" id="inputEmailAddress" name="usuario" type="text" placeholder="Enter email address" /></div>
                                        <div class="form-group"><label class="small mb-1" for="inputPassword">Password</label><input class="form-control py-4" id="inputPassword" name="password" type="password" placeholder="Enter password" /></div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox"><input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" /><label class="custom-control-label" for="rememberPasswordCheck">Remember password</label></div>
                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0"><a class="small" href="password.html">Forgot Password?</a>
                                            <button type="submit" class="btn btn-primary">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="small"><a href="register.html">Need an account? Sign up!</a></div>
                                </div>

                                <?php
                                session_start();
                                if (isset($_SESSION['status'])) {
                                    echo '<div class="alert alert-info">' . $_SESSION['status'] . '</div>';
                                    unset($_SESSION['status']);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2019</div>
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
</body>

</html>