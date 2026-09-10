<?php

namespace Ezequiel\App\controllers;

use Ezequiel\Lib\SessionManager;
use Ezequiel\App\models\RefugioModel;

class RefugioController extends Controller
{
    public static function index()
    {
        //implementar la función index
        //llamar a RefugioModel cuando sea necesario
        //Emplear la clase SesionManager cuando sea necesario
        //llamar a la vista listado_view cuando sea necesario

        SessionManager::usuarioNoAutenticado('usuario', 'login');
        
        $model = new RefugioModel();
        //recogemos los animales en el refugio
        $animales = $model->getAnimalesRefugio();


        // Extraemos el nombre del usuario de la sesión para pasarlo a la vista
        $usuarioLogueado = SessionManager::get('usuario')['usuario'] ?? '';
        
        // Obtenemos posibles mensajes flash
        $mensajeFlash = SessionManager::getMensajeFlash();

        self::view('listado_view', [
            'animales'     => $animales,
            'usuario'      => $usuarioLogueado,
            'mensajeFlash' => $mensajeFlash
        ]);
    }
    //Esta funcion es para alimentar
    public static function alimentar($id){
        SessionManager::usuarioNoAutenticado('usuario', 'login');

         //comprobamos sus energias y higiene y lo validamos 
        $model = new RefugioModel;
        $animal = $model->getAnimal($id);
        $EnergiaAumentar = $animal['energia'] + 25;
        $higeneReducido = $animal['higiene'] - 5;

        if(!max(100, $EnergiaAumentar)){
            SessionManager::setMensajeFlash("El animal ya tiene suficiente energa", "x", "error");
            header("Location: ".BASE_URL);
            exit();
        }else if(min(0, $higeneReducido)){
            SessionManager::setMensajeFlash("No se le puede Alimentar por la energia", "x", "error");
            header("Location: ".BASE_URL);
            exit();
        }
            $alimentar = $model->alimentar($EnergiaAumentar, $higeneReducido, $id);
            if(!$alimentar){
                SessionManager::setMensajeFlash("No se le puede Alimentar por la energia", "x", "error");
            }else{
                SessionManager::setMensajeFlash("Animal ha sido Alimentado correctamente", "✔", "ok");
            }
        
         header("Location: ".BASE_URL);
         exit();
    }
    //Esta funcion es para lmpiar
    public static function limpiar($id){
        SessionManager::usuarioNoAutenticado('usuario', 'login');

        //comprobamos sus energias y higiene y lo validamos 
        $model = new RefugioModel;
        $animal = $model->getAnimal($id);
        $higieneAmentar = $animal['higiene'] + 25;
        $energiaReducir = $animal['energia'] - 10;

        if(!max(100, $higieneAmentar)){
            SessionManager::setMensajeFlash("El animal ya esta limpio", "x", "error");
            header("Location: ".BASE_URL);
            exit();
        }else if(min(0, $energiaReducir)){
            SessionManager::setMensajeFlash("El animal no tiene energia", "x", "error");
            header("Location: ".BASE_URL);
            exit();
        }
            $alimentar = $model->alimentar($higieneAmentar, $energiaReducir, $id);
            if(!$alimentar){
                SessionManager::setMensajeFlash("Ha ocurrido un error al limpiar el animal", "x", "error");
            }else{
                SessionManager::setMensajeFlash("Animal ha sido limpiado correctamente", "✔", "ok");
            }
        
         header("Location: ".BASE_URL);
         exit();
    }

    public static function adopcion(){
        SessionManager::usuarioNoAutenticado('usuario', 'login');
        // Extraemos el nombre del usuario de la sesión para pasarlo a la vista
        $usuarioLogueado = SessionManager::get('usuario')['usuario'] ?? '';
        
        $model = new RefugioModel;
        $animales = $model->getAnimalesRefugio();
        
        // Obtenemos posibles mensajes flash
        $mensajeFlash = SessionManager::getMensajeFlash();
        $data = [
            'usuario' => $usuarioLogueado,
            "animales" => $animales,
            "mensajeFlash" => $mensajeFlash
        ];
        self::view('adopcion_view', $data);
    }
    public static function adoptar($id){
        SessionManager::usuarioNoAutenticado('usuario', 'login');
        $model = new RefugioModel;
        $animal = $model->getAnimal($id);
        if($animal['higiene']>=75 && $animal['higiene']>=75){
            header("Location: ".BASE_URL."/adopcion");
            exit();
        }

        $especie = $animal['especie'];
        $nombre = $animal['nombre'];
        $usuario = SessionManager::get('usuario')['id_usuario'] ?? '';
        $adoptar = $model->adopcion($id, $usuario);
        if(!$adoptar){
            SessionManager::setMensajeFlash("Ha ocurrido un error al adoptar el animal", "x", "error");
        }else{
            SessionManager::setMensajeFlash("El $especie $nombre ha sido adoptado", "✔", "ok");
        }
        header("Location: ".BASE_URL);
        exit();
    }

    public static function dormir(){
        SessionManager::usuarioNoAutenticado('usuario', 'login');

    }

}
