<?php

$variable = "hola";

if (isset($variable)){
    echo "esta definida <br>";
}else{
    echo "no esta definida <br>";
};

$variable2 = null;

if (isset($variable2)){
    echo "esta definida <br>";
}else{
    echo "no esta definida <br>";
};