<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

$nombre = $_SESSION['nombre'];
$tipo_usuario = $_SESSION['tipo_usuario'];

require 'conexion.php';

$lista = [];

try {
    // Utilizar a conexão com a base de dados
    $sql = "SELECT * FROM propinas";
    $resultado = $mysqli2->query($sql);

    // Verifica se há resultados na consulta
    if ($resultado->num_rows > 0) {
        while ($propinas = $resultado->fetch_assoc()) {
            $lista[] = $propinas;
        }
    }
} catch (Exception $e) {
    echo "Erro ao executar a consulta: " . $e->getMessage();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="principal.php">Assistente ISPLB</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>

        <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo htmlspecialchars($nombre); ?>
                    <i class="fas fa-user fa-fw"></i>
                </a>
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
                        <a class="nav-link" href="index.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Assistente ISPLB
                        </a>

                        <?php if ($tipo_usuario == 1) : ?>
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a id="cursos" class="nav-link" href="cursos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Cursos
                            </a>
                            <a id="contactos" class="nav-link" href="contactos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Contactos
                            </a>
                            <a id="contas" class="nav-link" href="contas.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Contas
                            </a>
                            <a id="propinas" class="nav-link" href="propina.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Propinas
                            </a>
                        <?php endif; ?>

                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="tabla.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tables
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Menu Propinas</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Assistente ISPLB</li>
                    </ol>

                    <?php
                    session_start();
                    if (isset($_SESSION['status'])) {
                        echo '<div class="alert alert-info">' . $_SESSION['status'] . '</div>';
                        unset($_SESSION['status']);
                    }
                    ?>


                    <div class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPropina">
                                Adicionar Propina
                            </button>
                            <hr>
                            <h4>Lista de Propinas</h4>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($lista)) : ?>
                                <div class="table-container">
                                    <table class="table table-hover table-striped table-bordered table-responsive">
                                        <thead>
                                            <tr>

                                                <th>Ano</th>
                                                <th>Valor da Propina</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($lista as $propinas) : ?>
                                                <tr>

                                                    <td><?= htmlspecialchars($propinas['ano']); ?></td>
                                                    <td><?= htmlspecialchars($propinas['preco']); ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-success edita_propina" data-id="<?= $propinas['id']; ?>">Editar</a>
                                                        <button type="button" class="btn btn-danger excluir_propina" data-id="<?= $propinas['id']; ?>" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">Excluir</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else : ?>
                                <p>Não há propinas cadastradas.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Modal Adicionar Propina -->
                    <div class="modal fade" id="addPropina" tabindex="-1" aria-labelledby="addCursoLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addCursoLabel">Adicionar Propina</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="code_propina.php" method="POST">
                                        <div class="mb-3">
                                            <label for="duracao" class="form-label">Usuário(Adicona o seu valor de Usuário)</label>
                                            <input type="number" class="form-control" id="usuario_id" name="usuario_id" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nome" class="form-label">
                                                Ano</label>
                                            <input type="text" class="form-control" id="ano" name="ano" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="duracao" class="form-label">Valor da Propina</label>
                                            <input type="text" class="form-control" id="preco" name="preco" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                            <button type="submit" name="salvar_propina" class="btn btn-primary">Salvar Propina</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Editar Propina -->
                    <div class="modal fade" id="editPropina" tabindex="-1" aria-labelledby="editPropinaLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editPropinaLabel">Editar Propina</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="editar_propina.php" method="POST">
                                        <input type="hidden" name="id" id="edit_id">
                                        <div class="mb-3">
                                            <label for="edit_usuario_id" class="form-label">Usuário ID</label>
                                            <input type="number" class="form-control" id="edit_usuario_id" name="usuario_id" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_ano" class="form-label">Ano</label>
                                            <input type="text" class="form-control" id="edit_ano" name="ano" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_preco" class="form-label">Preço</label>
                                            <input type="text" class="form-control" id="edit_preco" name="preco" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                            <button type="submit" name="atualiza_propina" class="btn btn-primary">Atualizar Propina</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Modal de Sucesso de Exclusão -->
                    <div class="modal fade" id="deleteSuccessModal" tabindex="-1" aria-labelledby="deleteSuccessLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteSuccessLabel">Sucesso</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Propina excluído com sucesso!
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.reload();">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal de Confirmação de Exclusão -->
                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmDeleteLabel">Confirmação de Exclusão</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Tem certeza de que deseja excluir esta Propina?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" id="confirmDeleteButton" class="btn btn-danger">Excluir</button>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Desenvolvido Por Francisco Domingos</div>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var propinaId;

        $('.excluir_propina').click(function() {
            propinaId = $(this).data('id');
        });

        $('#confirmDeleteButton').click(function() {
            $.ajax({
                url: 'excluir_propina.php',
                type: 'POST',
                data: {
                    excluir_propina: true,
                    id: propinaId
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        location.reload(); // Recarrega a página após a exclusão
                    } else {
                        alert('Erro ao excluir a propina: ' + data.message);
                    }
                },
                error: function() {
                    alert('Erro ao excluir a propina.');
                }
            });
        });
    });


    $('.edita_propina').click(function(e) {
    e.preventDefault();
    var id = $(this).data('id');

    $.ajax({
        url: 'get_propina.php',
        type: 'GET',
        data: {
            id: id
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#edit_id').val(response.data.id);
                $('#edit_ano').val(response.data.ano);
                $('#edit_preco').val(response.data.preco);
                $('#edit_usuario_id').val(response.data.usuario_id);
                $('#editPropina').modal('show');
            } else {
                alert('Erro ao buscar dados do curso: ' + response.message);
            }
        },
        error: function() {
            alert('Erro na requisição AJAX');
        }
    });
    });
    
</script>
