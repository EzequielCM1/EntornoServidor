<?php
    namespace Ezequiel\App;
    class Coche{
        // esto apartir del php 8.0 ya no se hace 
        // private string $marca = "";
        // private string $modelo = "";
        // private int $anyo = 2000;


        private static int $cantidadDeCocches = 0;

        // Contructor
        public function __construct(private string $marca,private string $modelo,private int $anyo = 2021)
        {
            // $this->marca = $Marca;
            // $this->modelo = $Modelo;
            // $this->anyo = $Anyo;
           // esto es de prueba 
           //echo "Coche creado \n";
           self::$cantidadDeCocches++;
        }

        // getter y setter 
        // public function getMarca(){
        //     return $this->marca;
        // }
        // public function getModelo(){
        //     return $this->modelo;
        // }
        // public function getAnyo(){
        //     return $this->anyo;
        // }

        // public function setMarca(string $marca){
        //     $this->marca;
        // }
        // public function setModelo(string $modelo){
        //     $this->modelo;
        // }
        // public function setAnyo(string $anyo){
        //     $this->anyo;
        // }

        public function __get($propiedad)
        {
            if(property_exists($this, $propiedad)){
                return $this->$propiedad;
            }
        }
        public function __set($propiedad, $valor)
        {
            if(property_exists($this, $propiedad)){

                if($propiedad === "anyo" && $valor <= 1886 ){
                    echo "el año debe ser mayor a 1886 \n";
                    return;
                }

                $this->$propiedad = $valor;
            }else{
                //no deberia
                echo "La prorpiedad es null";
            }
        }

        public function mostrarinfo(){
            echo "Marca: ".$this->marca.", Modelo: ".$this->modelo.", Año: ".$this->anyo."\n";
        }
        public function actualizarAnio(int $anyo)//:string
        {
            $this->anyo = $anyo;
        }
        public function compararAntiguedad(Coche $otroCoche){
            if($this->anyo > $otroCoche->anyo){
                return "El coche".$otroCoche->marca." es mas antiguo que (".$this->anyo.")".$this->marca;
            }elseif($this->anyo < $otroCoche->anyo){
                return "El coche".$this->mara." es mas nuevo que (".$otroCoche->anyo.")".$otroCoche->marca;
            }else{
                return "ES del mismo año";
            }
        }
        public function __destruct()
        {
            self::$cantidadDeCocches--;
        }
        public static function getTotalDeCoches(){
            return self::$cantidadDeCocches;
        }

    };

$coche = new Coche("Kia","pikanto", 2005 );
//Al crear el constructor esto ya no es necesario
// $coche->marca = "Kia";
// $coche->modelo = "pikanto";
// $coche->anyo = 2005;

// $coche->mostrarinfo();

// Para ver si hace lo del año y que dte devuelva el mensaje 
// $coche->anyo = 1885;


echo "Tptal de coche: ".$coche->getTotalDeCoches()."\n";
$coche2 = new Coche("Skoda", "fabia");
// $coche2->marca = "Skoda";
// $coche2->modelo = "fabia";
// $coche2->anyo = 2005;

// $coche2->mostrarinfo();
// $coche2->actualizarAnio(2009);
// $coche2->mostrarinfo();

echo $coche->marca."\n";
echo $coche->mostrarinfo();

$coche->marca = "Ferrari";
echo $coche->marca."\n";

echo $coche->compararAntiguedad($coche2)."\n";
echo "Tptal de coche: ".$coche->getTotalDeCoches()."\n";

?>
