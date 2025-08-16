<nav class="navbar navbar-expand-lg bg-light shadow-sm">
  <div class="container-fluid">
    <!-- Logo y Nombre -->
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="../../img/olimpia.png" alt="Logo" style="max-width: 80px;" class="me-2 rounded-circle">
      <span class="fw-bold">"Tu nombre"</span>
    </a>

    <!-- Botón responsive -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarOpciones" aria-controls="navbarOpciones" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menú a la derecha -->
    <div class="collapse navbar-collapse ms-auto justify-content-end">
      <ul class="nav nav-tabs" style="background-color: #f8f9fa;">
        <li class="nav-item mx-3">
          <a class="nav-link fw-bold" style="color: #28a745; background-color: #e6ffe6;" href="?accion=listar">
            Ver Lista
          </a>
        </li>
        <li class="nav-item mx-3">
          <a class="nav-link fw-bold" style="color: #dc3545; background-color: #ffe6e6;" href="?accion=eliminarTodo" 
             onclick="return confirm('¿Estás seguro de que quieres eliminar TODOS los registros? Esta acción no se puede deshacer.');">
            Eliminar Todo
          </a>
        </li>
        <li class="nav-item mx-3">
          <a class="nav-link fw-bold" style="color: #ffc107; background-color: #fff7e6; cursor: pointer;" onclick="descargarTodo()">
            Descargar JSON
          </a>
        </li>
        <li class="nav-item mx-3">
          <a class="nav-link fw-bold" style="color: #6c757d; background-color: #f2f2f2;" href="?accion=conseguirTodo">
            Ver JSON
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<?php if (!empty($_SESSION['alerta']['status']) && !empty($_SESSION['alerta']['msg'])): ?>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
    <div id="liveToast" class="toast align-items-center text-bg-<?= $_SESSION['alerta']['status'] ?> border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <strong><?= $_SESSION['alerta']['msg'] ?></strong>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
        </div>
    </div>
</div>
<?php unset($_SESSION['alerta']); ?>
<?php endif; ?>