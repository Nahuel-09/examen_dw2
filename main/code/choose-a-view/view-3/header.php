    <!-- Navbar moderno -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-gradient p-3 rounded-top-4 shadow-sm">
        <div class="container-fluid">
            <!-- Logo y nombre -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../../img/olimpia.png" style="max-width: 80px;" alt="Logo" class="me-2 rounded-circle border border-white shadow-sm">
                <span class="text-secondary fw-bold fs-5">"Tu nombre"</span>
            </a>

            <!-- Botón responsive -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarOpciones" aria-controls="navbarOpciones" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menú con dropdown moderno -->
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-bold text-secondary" href="#" id="accionesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Acciones
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow rounded-3" aria-labelledby="accionesDropdown" style="min-width: 200px;">
                            <li><a class="dropdown-item text-success fw-semibold" href="?accion=listar"><i class="bi bi-list-ul me-2"></i>Ver Lista</a></li>
                            <li><a class="dropdown-item text-danger fw-semibold" href="?accion=eliminarTodo" onclick="return confirm('¿Estás seguro de que quieres eliminar TODOS los registros? Esta acción no se puede deshacer.');"><i class="bi bi-trash-fill me-2"></i>Eliminar Todo</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-warning fw-semibold" href="#" onclick="descargarTodo()"><i class="bi bi-download me-2"></i>Descargar JSON</a></li>
                            <li><a class="dropdown-item text-secondary fw-semibold" href="?accion=conseguirTodo"><i class="bi bi-eye-fill me-2"></i>Ver JSON</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <br>

    <!-- Toast moderno -->
    <?php if (!empty($_SESSION['alerta']['status']) && !empty($_SESSION['alerta']['msg'])): ?>
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1060; min-width: 280px;">
            <div class="toast show align-items-center border-0 rounded-4 shadow-lg text-bg-<?= $_SESSION['alerta']['status'] ?>" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center">
                        <?php if ($_SESSION['alerta']['status'] === 'success'): ?>
                            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <?php elseif ($_SESSION['alerta']['status'] === 'danger'): ?>
                            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                        <?php elseif ($_SESSION['alerta']['status'] === 'warning'): ?>
                            <i class="bi bi-exclamation-diamond-fill me-2 fs-5"></i>
                        <?php else: ?>
                            <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                        <?php endif; ?>
                        <div class="fw-semibold"><?= $_SESSION['alerta']['msg'] ?></div>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['alerta']); ?>
    <?php endif; ?>