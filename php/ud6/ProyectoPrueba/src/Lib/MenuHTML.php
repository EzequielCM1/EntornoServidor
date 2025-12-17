<?php
    namespace Ezequiel\Lib;

    class MenuHTML{

        public function __construct(private array $opciones)
        {

        }

        public function agregarOpcion($titulo, $enlace){
            $this->opciones[$titulo] = $enlace ;
        }

        public function mostrarHorizontal(){
            $fila = "";
            foreach($this->opciones as $titulo => $enlace){
                $fila .= '<a href="'.$enlace.'">'.$titulo.'</a>-';
            }
            return $fila;
        }
    }
?>