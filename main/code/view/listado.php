<?php 
// Importar las clases necesarias para la conexión a base de datos y paginación
require_once "../model/lib/ConnDB.php";
require_once "../model/lib/Pagination.php";

// Crear instancia de la conexión a base de datos
$conn = new ConnDB();

// Obtener el total de registros en la tabla para calcular la paginación
$totalRegistros = $conn->contar();

// Obtener la acción actual desde GET, o cadena vacía si no está definida
$accion = isset($_GET['accion']) ? $_GET['accion'] : '';

// Obtener la página actual desde GET, asegurando que sea al menos 1
$paginaActual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;

// Crear objeto de paginación con total registros, página actual y límite de registros por página (5)
$paginacion = new Pagination($totalRegistros, $paginaActual, 5);

// Obtener los registros de mascotas correspondientes a la página actual, usando los métodos de paginación
$mascotas = $conn->conseguirPagina($paginacion->inicio(), $paginacion->getLimite());
?>

<br>
<br>
<br>

<!-- Contenedor principal -->
<section class="container">
    <!-- Tabla Bootstrap con estilos para mostrar mascotas -->
    <table class="table table-info table-striped-columns text-center justify-content-center align-items-center">
        <thead>
            <tr>
                <!-- Encabezados de columnas -->
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Especie</th>
                <th scope="col">Edad</th>
                <th scope="col">Foto</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Verifica si no hay mascotas para mostrar -->
            <?php if (empty($mascotas)): ?>
                <tr>
                    <td colspan="6" class="text-center">No hay mascotas registradas</td>
                </tr>
            <?php else: ?>
                <!-- Recorre cada mascota para mostrar en filas -->
                <?php foreach ($mascotas as $m): ?>
                    <tr class="container justify-content-center">
                        <!-- Mostrar cada campo con htmlspecialchars para evitar XSS -->
                        <th class="align-middle text-center" scope="row"><?= htmlspecialchars($m['id'] ?? '') ?></th>
                        <td class="align-middle text-center"><?= htmlspecialchars($m['nombre'] ?? '') ?></td>
                        <td class="align-middle text-center"><?= htmlspecialchars($m['especie'] ?? '') ?></td>
                        <td class="align-middle text-center"><?= htmlspecialchars($m['edad'] ?? '') ?></td>
                        <td class="align-middle text-center">
                            <!-- Mostrar imagen miniatura si existe -->
                            <?php if (!empty($m['foto'])): ?>
                                <img class="img-thumbnail rounded" src="../model/images/<?= htmlspecialchars($m['foto']) ?>" style="min-height: 80px; min-width: 80px;" alt="Foto de mascota">
                            <?php endif; ?>
                        </td>
                        <td class="align-middle text-center">
                            <!-- Botones para editar, eliminar y descargar JSON de la mascota -->
                            <a href="?accion=editar&id=<?= $m['id'] ?>" class="btn btn-sm me-2 btn-primary">Editar</a>
                            <a href="?accion=eliminar&id=<?= $m['id'] ?>" class="btn btn-sm me-2 btn-danger" onclick="return confirm('¿Seguro que quieres eliminar esta mascota?');">Eliminar</a>
                            <a onclick="descargarFila(<?= $m['id'] ?>)" class="btn btn-sm me-2 btn-warning">Descargar JSON</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<br>
<br>

<!-- Verifica si hay más de una página para mostrar la paginación -->
<section class="d-flex justify-content-center">
    <?php if ($paginacion->totalPaginas() > 0): ?>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <!-- Botón para página anterior, deshabilitado si estamos en la primera página -->
            <li class="page-item <?= ($paginaActual <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?accion=listar&pagina=<?= ($paginaActual - 1) ?>">&larr;</a>
            </li>
            
            <!-- Genera enlaces para cada página -->
            <?php for ($i = 1; $i <= $paginacion->totalPaginas(); $i++): ?>
                <li class="page-item <?= ($i == $paginaActual) ? 'active' : '' ?>">
                    <a class="page-link" href="?accion=listar&pagina=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            
            <!-- Botón para página siguiente, deshabilitado si estamos en la última página -->
            <li class="page-item <?= ($paginaActual >= $paginacion->totalPaginas()) ? 'disabled' : '' ?>">
                <a class="page-link" href="?accion=listar&pagina=<?= ($paginaActual + 1) ?>">&rarr;</a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>
</section>

<!-- Muestra información sobre los registros mostrados y total -->
<p class="text-center mt-3">
    Mostrando <?= ($paginacion->inicio() + 1) ?> a <?= min($paginacion->inicio() + $paginacion->registrosPorPagina, $totalRegistros) ?> de <?= $totalRegistros ?> registros
</p>
