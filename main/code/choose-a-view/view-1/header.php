    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <!-- Logo y Nombre -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../../img/olimpia.png" style="max-width: 80px;" alt="Logo" class="me-2 rounded-circle">
                <span class="fw-bold">"Tu nombre"</span>
            </a>

            <!-- Botón responsive -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarOpciones" aria-controls="navbarOpciones" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menú a la derecha con dropdown -->
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-bold" href="#" id="accionesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Acciones
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accionesDropdown">
                            <li>
                                <a class="dropdown-item text-success" href="?accion=listar">Ver Lista</a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="?accion=eliminarTodo" onclick="return confirm('¿Estás seguro de que quieres eliminar TODOS los registros? Esta acción no se puede deshacer.');">Eliminar Todo</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-warning" href="#" onclick="descargarTodo()">Descargar JSON</a>
                            </li>
                            <li>
                                <a class="dropdown-item text-secondary" href="?accion=conseguirTodo">Ver JSON</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <br>

    <?php if (!empty($_SESSION['alerta']['status']) && !empty($_SESSION['alerta']['msg'])): ?>
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055; min-width: 300px;">
            <div class="toast show align-items-center border-0 rounded-4 shadow-lg text-bg-<?= $_SESSION['alerta']['status'] ?>" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
                <div class="d-flex">
                    <!-- Icono según especie de alerta -->
                    <div class="toast-body d-flex align-items-center">
                        <?php if ($_SESSION['alerta']['status'] === 'success'): ?>
                            <i class="bi bi-check-circle-fill me-2"></i>
                        <?php elseif ($_SESSION['alerta']['status'] === 'danger'): ?>
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?php elseif ($_SESSION['alerta']['status'] === 'warning'): ?>
                            <i class="bi bi-exclamation-diamond-fill me-2"></i>
                        <?php else: ?>
                            <i class="bi bi-info-circle-fill me-2"></i>
                        <?php endif; ?>
                        <strong><?= $_SESSION['alerta']['msg'] ?></strong>
                    </div>
                    <!-- Botón cerrar -->
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['alerta']); ?>
    <?php endif; ?>