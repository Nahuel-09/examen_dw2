<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"> <!-- Define la codificación de caracteres del documento como UTF-8 -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Hace que la página sea responsiva para dispositivos móviles -->
  <title>Examen Final DW2</title> <!-- Título que aparece en la pestaña del navegador -->
  <link rel="stylesheet" href="../model/src/bootstrap-5.3.7-dist/css/bootstrap.min.css"> <!-- Incluye los estilos CSS de Bootstrap para el diseño -->
</head>
<body>
  <section class="card text-center"> <!-- Sección que actúa como una tarjeta con contenido centrado -->
    <ul class="nav nav-tabs nav-underline row justify-content-center align-items"> <!-- Lista de navegación con pestañas y diseño responsivo con Bootstrap -->
      <li class="col nav-item"> <!-- Elemento de la lista que ocupa una columna -->
        <a class="nav-link text-success" href="?accion=agregar">Agregar datos</a> <!-- Enlace para agregar datos con estilo de texto verde -->
      </li>
      <li class="col nav-item"> <!-- Otro elemento de la lista -->
        <a class="nav-link text-danger" href="?accion=eliminarTodo" onclick="return confirm('¿Estás seguro de que quieres eliminar TODOS los registros? Esta acción no se puede deshacer.');">Eliminar Todo</a> 
        <!-- Enlace para eliminar todos los registros con texto en rojo y una confirmación antes de ejecutar la acción -->
      </li>
      <li class="col nav-item"> <!-- Otro elemento de la lista -->
        <a class="nav-link text-warning" onclick="descargarTodo()">Descargar Todos Los Datos a JSON</a> 
        <!-- Enlace con texto amarillo que ejecuta la función JavaScript descargarTodo() al hacer clic -->
      </li>
    </ul>
    <br> <!-- Salto de línea para separación -->

    <!-- Se implementó sección de alerta para mostrar mensajes al usuario -->
    <?php if (isset($_SESSION['alerta'])): ?> <!-- Verifica si existe un mensaje de alerta en la sesión -->
        <section class="alert alert-<?=$_SESSION['alerta']['status']?> alert-dismissible fade show m-3" role="alert">
        <!-- Contenedor para la alerta con clases dinámicas según el tipo de alerta (success, danger, warning, etc.) -->
        <?php if ($_SESSION['alerta']['status'] === 'danger' || $_SESSION['alerta']['status'] === 'warning'): ?>
          <p><strong class="text-<?=$_SESSION['alerta']['status']?>"> <?=$_SESSION['alerta']['msg']?></strong></p> 
          <!-- Si la alerta es de tipo peligro o advertencia, muestra el mensaje dentro de un párrafo con texto en color correspondiente -->
        <?php else:?>
          <h2><strong class="text-<?=$_SESSION['alerta']['status']?>"> <?=$_SESSION['alerta']['msg']?></strong></h2> 
          <!-- Para otro tipo de alertas, muestra el mensaje con un título h2 con texto en color correspondiente -->
        <?php endif;?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button> 
          <!-- Botón para cerrar la alerta, con atributos para accesibilidad y funcionalidad Bootstrap -->
        </section>
        <?php unset($_SESSION['alerta']);?> <!-- Elimina la alerta de la sesión para que no se muestre nuevamente -->
    <?php endif;?>
    <br> <!-- Salto de línea para separación -->
