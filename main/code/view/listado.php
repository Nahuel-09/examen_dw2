<?php 
require_once "../model/lib/ConnDB.php";
require_once "../model/lib/Pagination.php";

$conn = new ConnDB();
$totalRegistros = $conn->contar();
$accion = isset($_GET['accion']) ? $_GET['accion'] : '';
$paginaActual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$paginacion = new Pagination($totalRegistros, $paginaActual, 5);
$mascotas = $conn->conseguirPagina($paginacion->inicio(), $paginacion->getLimite());
?>

<div class="container mb-5">
    <table class="table table-info table-striped-columns text-center justify-content-center align-items-center">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Especie</th>
                <th scope="col">Edad</th>
                <th scope="col">Foto</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($mascotas)): ?>
                <tr><td colspan="6" class="text-center">No hay mascotas registradas</td></tr>
            <?php else: ?>
                <?php foreach ($mascotas as $m): ?>
                    <tr class="container justify-content-center">
                        <th class="align-middle text-center" scope="row"><?= htmlspecialchars($m['id'] ?? '') ?></th>
                        <td class="align-middle text-center"><?= htmlspecialchars($m['nombre'] ?? '') ?></td>
                        <td class="align-middle text-center"><?= htmlspecialchars($m['especie'] ?? '') ?></td>
                        <td class="align-middle text-center"><?= htmlspecialchars($m['edad'] ?? '') ?></td>
                        <td class="align-middle text-center">
                            <?php if (!empty($m['foto'])): ?>
                                <img class="img-thumbnail rounded" src="../model/images/<?= htmlspecialchars($m['foto']) ?>" width="80" alt="Foto de mascota">
                            <?php endif; ?>
                        </td>
                        <td class="align-middle text-center">
                            <a href="?accion=editar&id=<?= $m['id'] ?>" class="btn btn-sm me-2 btn-primary">Editar</a>
                            <a href="?accion=eliminar&id=<?= $m['id'] ?>" class="btn btn-sm me-2 btn-danger" onclick="return confirm('¿Seguro que quieres eliminar esta mascota?');">Eliminar</a>
                            <a onclick="descargarFila(<?= $m['id'] ?>)" class="btn btn-sm me-2 btn-warning">Descargar JSON</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if ($paginacion->totalPaginas() > 0): ?>
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <li class="page-item <?= ($paginaActual <= 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="?accion=listar&pagina=<?= ($paginaActual - 1) ?>">&larr;</a>
        </li>
        
        <?php for ($i = 1; $i <= $paginacion->totalPaginas(); $i++): ?>
            <li class="page-item <?= ($i == $paginaActual) ? 'active' : '' ?>">
                <a class="page-link" href="?accion=listar&pagina=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
        
        <li class="page-item <?= ($paginaActual >= $paginacion->totalPaginas()) ? 'disabled' : '' ?>">
            <a class="page-link" href="?accion=listar&pagina=<?= ($paginaActual + 1) ?>">&rarr;</a>
        </li>
    </ul>
</nav>
<?php endif; ?>

<p class="text-center mt-3">Mostrando <?= ($paginacion->inicio() + 1) ?> a <?= min($paginacion->inicio() + $paginacion->registrosPorPagina, $totalRegistros) ?> de <?= $totalRegistros ?> registros</p>
