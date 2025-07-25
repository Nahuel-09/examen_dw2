<?php 
class Pagination {
    public $totalRegistros;
    public $registrosPorPagina;
    public $paginaActual;

    public function __construct($total, $pag = 1, $ult = 10) {
        $this->totalRegistros = (int)$total;
        $this->registrosPorPagina = max(1, (int)$ult);
        $this->setPaginaActual($pag);
    }

    public function totalPaginas() {
        return ceil($this->totalRegistros / $this->registrosPorPagina);
    }

    public function inicio() {
        return ($this->paginaActual - 1) * $this->registrosPorPagina;
    }

    public function getLimite() {
        return $this->registrosPorPagina;
    }

    public function setPaginaActual($pagina) {
        $pagina = (int)$pagina;
        $totalPaginas = $this->totalPaginas();
        
        if ($pagina < 1) {
            $this->paginaActual = 1;
        } elseif ($totalPaginas > 0 && $pagina > $totalPaginas) {
            $this->paginaActual = $totalPaginas;
        } else {
            $this->paginaActual = $pagina;
        }
    }
}
?>