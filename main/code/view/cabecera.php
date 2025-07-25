<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Examen Final DW2</title>
  <link rel="stylesheet" href="../model/src/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="card text-center">
    <ul class="nav nav-tabs nav-underline row justify-content-center align-items">
      <li class="col nav-item">
        <a class="nav-link text-success" href="?accion=agregar">Agregar datos</a>
      </li>
      <li class="col nav-item">
        <a class="nav-link text-danger" href="?accion=eliminarTodo" onclick="return confirm('¿Estás seguro de que quieres eliminar TODOS los registros? Esta acción no se puede deshacer.');">Eliminar Todo</a>
      </li>
      <li class="col nav-item">
        <a class="nav-link text-warning" onclick="descargarTodo()">Descargar Todos Los Datos a JSON</a>
      </li>
    </ul>
    <br>
    <?php if (isset($_SESSION['alerta'])): ?>
        <div class="alert alert-<?=$_SESSION['alerta']['status']?> alert-dismissible fade show m-3" role="alert">
        <?php if ($_SESSION['alerta']['status'] === 'danger' || $_SESSION['alerta']['status'] === 'warning'): ?>
          <h4><strong class="text-<?=$_SESSION['alerta']['status']?>"> <?=$_SESSION['alerta']['msg']?></strong></h4>
        <?php else:?>
          <h2><strong class="text-<?=$_SESSION['alerta']['status']?>"> <?=$_SESSION['alerta']['msg']?></strong></h2>
        <?php endif;?>

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
        <?php unset($_SESSION['alerta']);?>
    <?php endif;?>
    <br>