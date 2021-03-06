<?php
require_once('session.php');
$session = new Session();
if ($session->getActivo()) {
    require_once('../../includes/head-dashboard.php');
    require_once('../../includes/menu-dashboard.php');
    //Importamos el model y PublicacionesControllerr
    require_once('../../model/database.php');
    require_once('../../controllers/ListasController.php');
    $view = new ListasController();
    $data = $view->getListas();
    if (isset($_REQUEST['eliminar'])) {

            $view->eliminarLista($_REQUEST['id']);
       
    }
?>

    <div class="container">
        <?php if (isset($_REQUEST['err'])) { ?>
            <span class="text-danger">No se puede eliminar debido a que esta en la vista de inicio.</span>
        <?php  }?>
        <a href="add-lista.php"><button style="float: right;" class="btn btn-primary"> +</button></a>
        <h1 class="mt-2">Listas (<?php echo $data->rowCount(); ?>)</h2>
            <div class="table-responsive">
                <table class="table table-hover" id="publicaciones">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Playlist</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Editar</th>
                            <th scope="col">Eliminar</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $d) { ?>
                            <tr>
                                <td><?php echo $d['id_lista']; ?></td>
                                <td><?php echo $d['nombre']; ?></td>
                                <td><?php echo $d['playlist'];
                                    ".."; ?></td>
                                <td> <?php echo  $d['fecha']; ?>
                                </td>
                                <td><a href="edit-lista.php?lista=<?php echo $d['id_lista']; ?>"><button class="btn btn-warning">Editar</button></a></td>
                                <td>
                                    <form action="conf-listas.php" method="post">
                                        <input type="hidden" value="<?php echo $d['id_lista']; ?>" name="id">
                                        <input type="submit" class="btn btn-danger" value="Eliminar" name="eliminar">
                                    </form>
                                </td>
                            </tr>
                        <?php  } ?>
                    </tbody>
                </table>
            </div>
    </div>
    <!-- Se manda a llamar a la tabla publicaciones para utilizar las datatables-->

    <!-- Modal -->
    <?php // Se requiere los assets (archivos de JavaScript)
    require_once('../../includes/assets-dashboard.php'); ?>
    <script>
        $(document).ready(function() {
            $('#publicaciones').DataTable();
        });
    </script>
    </body>

    </html>
<?php
} else {
    header("Location: ../entrar.php");
}
?>