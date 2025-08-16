
<section class="card text-center"> <!-- Sección que actúa como una tarjeta con contenido centrado -->
<ul class="nav nav-tabs nav-underline row justify-content-center align-items"> <!-- Lista de navegación con pestañas y diseño responsivo con Bootstrap -->
    <li class="col nav-item"> <!-- Otro elemento de la lista -->
        <a class="nav-link text-success" href="?accion=listar">
            Ver Lista
        </a>
        <!-- Enlace para eliminar todos los registros con texto en rojo y una confirmación antes de ejecutar la acción -->
    </li>
    <li class="col nav-item"> <!-- Otro elemento de la lista -->
        <a class="nav-link text-danger" href="?accion=eliminarTodo" onclick="return confirm('¿Estás seguro de que quieres eliminar TODOS los registros? Esta acción no se puede deshacer.');">
            Eliminar Todo
        </a>
        <!-- Enlace para eliminar todos los registros con texto en rojo y una confirmación antes de ejecutar la acción -->
    </li>
    <li class="col nav-item"> <!-- Otro elemento de la lista -->
        <a class="nav-link text-warning" href="guardar=1" onclick="descargarTodo(); return false;">
            Descargar Todos Los Datos a JSON
        </a>
        <!-- Enlace con texto amarillo que ejecuta la función JavaScript descargarTodo() al hacer clic -->
    </li>
    <li class="col nav-item"> <!-- Otro elemento de la lista -->
        <a class="nav-link text-secondary" href="?accion=conseguirTodo&guardar=0">
            Ver JSON
        </a>
        <!-- Enlace con texto gris para ver los datos en contenido JSON -->
    </li>
</ul>
<br> <!-- Salto de línea para separación -->

<!-- Se implementó sección de alerta para mostrar mensajes al usuario -->
<?php if (isset($_SESSION['alerta']) && isset($_SESSION['alerta']['status']) && isset($_SESSION['alerta']['msg'])): ?> <!-- Verifica si existe un mensaje de alerta en la sesión -->
    <section class="alert alert-<?= $_SESSION['alerta']['status'] ?> alert-dismissible fade show m-3" role="alert">
        <!-- Contenedor para la alerta con clases dinámicas según el especie de alerta (success, danger, warning, etc.) -->
        <?php if ($_SESSION['alerta']['status'] === 'danger' || $_SESSION['alerta']['status'] === 'warning'): ?>
            <p><strong class="text-<?= $_SESSION['alerta']['status'] ?>"> <?= $_SESSION['alerta']['msg'] ?></strong></p>
            <!-- Si la alerta es de especie peligro o advertencia, muestra el mensaje dentro de un párrafo con texto en color correspondiente -->
        <?php else: ?>
            <h2><strong class="text-<?= $_SESSION['alerta']['status'] ?>"> <?= $_SESSION['alerta']['msg'] ?></strong></h2>
            <!-- Para otro especie de alertas, muestra el mensaje con un título h2 con texto en color correspondiente -->
        <?php endif; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        <!-- Botón para cerrar la alerta, con atributos para accesibilidad y funcionalidad Bootstrap -->
    </section>
    <?php unset($_SESSION['alerta']); ?> <!-- Elimina la alerta de la sesión para que no se muestre nuevamente -->
<?php endif; ?>
<br> <!-- Salto de línea para separación -->