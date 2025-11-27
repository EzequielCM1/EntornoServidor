<?php
    //act 14
    echo "<h1> hola </h1>";
    $a = 6 ;
    $b = $a;

    echo "El valor de <strong>a</strong> es $a <br>";
    echo "El valor de <strong>b</strong> es $b <br>";

    $b += 5;

    echo "El valor de <strong>a</strong> es $a <br>";
    echo "El valor de <strong>b</strong> es $b <br>";


    // act 18 
    echo "<h1> Funciones</h1>";

    function mensaje(){

        $mensaje = "Hola mundo";
         echo 'Lo que contiene la variable es <strong>'.$mensaje."</strong><br>";


        global $a; // usamos la global para coger las variables fuera de las funciones
        echo 'Lo que contiene la variable a es <strong>'.$a."</strong><br>";

        // $GLOBALS tambien se puede hacer pero no se recomienda

    }

    $a += 16;
   
    // llamamos a la funcion
    mensaje();  

    // rutas
    echo "<h1> Rutas </h1>";
    echo "la ruta del servidor es ".$_SERVER['PHP_SELF']."<br>";
     echo "El nombre del servidor es ".$_SERVER['SERVER_NAME']."<br>";


     // estatico
     echo "<h1> Estatico </h1>";
     function estatico(){
        static $estatico = 0;
        $estatico ++;
        echo "El valor estatico es : $estatico <br>";
    }

    estatico();
    estatico();
    estatico();
    estatico();


    //Usamos el PRINTF
    echo "<h1> Printf </h1>";

    $number = 9;
    $str = "Beijing";
    printf("Hay %u de bisicletas en  %s.",$number,$str);

    //Usamos contsante
    echo "<h1> Constante </h1>";

    const IVA =  0.21;
    $precioBase = 80;

    $preciofinal = $precioBase * IVA;

    echo "El precio final es : $preciofinal <br>";
    echo 'El precio con IVA es de <strong>'.($precioBase * IVA)."</strong><br>";
     

     echo "<h1> Operacion de asignacion</h1>";
     $num = 25;

     $num +=3;
     echo "$num <br>";
     $num = $num - 2;
     echo "$num <br>";
     $num -=2;
     echo "$num <br>";
     $num *=4;
     echo "$num <br>";

     // Array
     echo "<h1> Array </h1>";
     $colores = ['rojo', 'amarillo', 'verde'];

    echo "El primer color es : $colores[0]<br>";
    echo "El segundo color es : $colores[1]<br>";
    echo "El tercer color es : $colores[2]<br>";

        if (isset($colores[6])){
            echo "El color si existe $colores[0]<br>";
        }else {
            echo "No existe el color <br>";
        }
        echo "<pre>";
        print_r($colores);
        echo "<pre>";
    
    // Ejercicio 30
    