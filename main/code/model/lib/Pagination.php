<?php 
class Pagination {
    // Número total de registros disponibles
    public $totalRegistros;
    // Cantidad de registros que se mostrarán por página
    public $registrosPorPagina;
    // Página actual que se está visualizando
    public $paginaActual;

    // Constructor que inicializa las propiedades
    // $total: total de registros
    // $pag: página actual (por defecto 1)
    // $ult: registros por página (por defecto 10)
    public function __construct($total, $pag = 1, $ult = 10) {
        $this->totalRegistros = (int)$total; // Se asegura que sea entero
        $this->registrosPorPagina = max(1, (int)$ult); // Mínimo 1 registro por página
        $this->setPaginaActual($pag); // Se establece la página actual validando el valor
    }

    // Calcula y retorna el total de páginas necesarias según total de registros y registros por página
    public function totalPaginas() {
        return ceil($this->totalRegistros / $this->registrosPorPagina);
    }

    // Calcula el índice del primer registro para la página actual (offset para consultas SQL)
    public function inicio() {
        return ($this->paginaActual - 1) * $this->registrosPorPagina;
    }

    // Retorna el límite (cantidad de registros por página) para usar en consultas SQL
    public function getLimite() {
        return $this->registrosPorPagina;
    }

    // Establece la página actual validando que esté dentro del rango válido
    public function setPaginaActual($pagina) {
        $pagina = (int)$pagina; // Convierte a entero
        $totalPaginas = $this->totalPaginas(); // Obtiene total de páginas disponibles
        
        if ($pagina < 1) {
            // Si el número de página es menor que 1, se asigna la página 1
            $this->paginaActual = 1;
        } elseif ($totalPaginas > 0 && $pagina > $totalPaginas) {
            // Si la página es mayor que el total de páginas, asigna la última página válida
            $this->paginaActual = $totalPaginas;
        } else {
            // Si está dentro del rango válido, asigna la página recibida
            $this->paginaActual = $pagina;
        }
    }
}
?>
