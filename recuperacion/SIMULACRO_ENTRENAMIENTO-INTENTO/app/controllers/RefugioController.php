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
        $animales = $model->getAnimales();

        // Extraemos el nombre del usuario de la sesión para pasarlo a la vista
        $usuarioLogueado = SessionManager::get('usuario')['usuario'] ?? 'Invitado';

        // Obtenemos posibles mensajes flash
        $mensajeFlash = SessionManager::getMensajeFlash();

        self::view('listado_view', [
            'animales'     => $animales,
            'usuario'      => $usuarioLogueado,
            'mensajeFlash' => $mensajeFlash
        ]);
    }
    public static function ficha()
    {
        SessionManager::usuarioNoAutenticado("usuario", "login");

        $id = $_POST['id'] ?? null;

        if ($id) {
            $model = new RefugioModel();
            $animal = $model->getAnimal($id);

            if ($animal) {
                $usuarioLogueado = SessionManager::get('usuario')['usuario'] ?? 'invitado';
                self::view('ficha_view', [
                    'animal' => $animal,
                    'usuario' => $usuarioLogueado
                ]);
                return;
            }
        }

        header("Location: " . BASE_URL);
        exit();
    }
    public static function entrenar()
    {
        SessionManager::usuarioNoAutenticado("usuario", "login");

        $id_animal = $_POST['id_animal'] ?? null;
        $id_usuario = SessionManager::get('usuario')['id_usuario'] ?? null;
        if ($id_animal || $id_usuario) {
            $model = new RefugioModel;
            $exito = $model->entrenar($id_animal, $id_usuario);
            if ($exito) {
                SessionManager::setMensajeFlash("Entrenamiento Registrado correctamente", "ole", "exito");
            } else {
                SessionManager::setMensajeFlash("No se ha podido realizar el entrenamiento", "x", "error");
            }
            header("Location: " . BASE_URL);
            exit();
        }
    }

    public static function nuevoAnimal()
    {
        SessionManager::usuarioNoAutenticado("usuario", "login");

        $datosForm = SessionManager::get("formulario") ?? [];
        $erroresForm = SessionManager::get("errores") ?? [];

        $data = [
            'mensajeFlash' => SessionManager::getMensajeFlash(),
            'usuario' => SessionManager::get('usuario')['usuario'] ?? 'Invitado',
            'nombre' => $datosForm['nombre'] ?? "",
            'especie' => $datosForm['especie'] ?? "",
            'raza' => $datosForm['raza'] ?? "",
            'edad' => $datosForm['edad'] ?? "0",
            'peso' => $datosForm['peso'] ?? "0.0",
            'nivel_adiestramiento' => $datosForm['nivel_adiestramiento'] ?? "1",
            'puntos_expediente' => $datosForm['puntos_expediente'] ?? "50",
            'errores' => $erroresForm // Pasamos el array de errores a la vista
        ];

        
        self::view("nuevo_view", $data);
    }

    public static function nuevoAnimalRegistrar()
    {

        $campos = ['nombre', 'especie', 'raza', 'edad', 'peso', 'nivel_adiestramiento', 'puntos_expediente'];
        $obligatorios = ['nombre', 'especie', 'edad']; // <--- Solo estos lanzarán error

        $errores = [];
        $datos = [];

        foreach ($campos as $campo) {
            $valor = trim(htmlspecialchars($_POST[$campo] ?? ""));
            $datos[$campo] = $valor;

            // Validamos solo si está en la lista de obligatorios Y está vacío
            if (in_array($campo, $obligatorios) && empty($valor)) {
                $errores[$campo] = "El campo " . ucfirst($campo) . " es obligatorio.";
            }
        }

        if (!empty($errores)) {
            // Guardamos los datos para no perder lo escrito y los errores
            SessionManager::set("formulario", $datos);
            SessionManager::set("errores", $errores);
            header("location: " . BASE_URL . "nuevoanimal");
            exit();
        } else {
            $model = new RefugioModel;
            $registrar = $model->registrar($datos);
            if ($registrar) {
                SessionManager::setMensajeFlash("Se ha registrado correctamente", "ole", "exito");
            } else {
                SessionManager::setMensajeFlash("No se ha podido realizar el registro", "x", "error");
            }
            SessionManager::eliminar("formulario");
            SessionManager::eliminar("errores");
            header("Location: " . BASE_URL);
            exit();
        }
    }



    /*
    // EJEMPLO DE CÓMO SERÍA POR GET (PARA RECORDAR)
    
    // 1. En la vista (HTML), en lugar de un formulario, usaríamos un enlace:
    // <a href="<?= BASE_URL ?>/entrenar-get?id_animal=<?= $animal['id'] ?>" class="btn">Entrenar</a>

    // 2. En routes/web.php registraríamos la ruta por GET:
    // Route::get('/entrenar-get', [RefugioController::class, 'entrenarGet']);

    // 3. La función en el controlador recogería los datos de $_GET:
    public static function entrenarGet(){
        SessionManager::usuarioNoAutenticado("usuario", "login");

        // Recuperamos por $_GET
        $id_animal = $_GET['id_animal'] ?? null;
        $id_usuario = SessionManager::get('usuario')['id_usuario'] ?? null;

        if($id_animal && $id_usuario){
            $model = new RefugioModel;
            $exito = $model->entrenar($id_animal, $id_usuario);
            
            if($exito){
                SessionManager::setMensajeFlash("Entrenamiento (vía GET) Registrado", "✅", "exito");
            } else {
                SessionManager::setMensajeFlash("No se pudo realizar el entrenamiento", "❌", "error");
            }
        }
        header("Location: ".BASE_URL);
        exit();
    }

    // OTRA FORMA: RECOGIENDO DATOS DESDE LA PROPIA RUTA (DINÁMICA)
    
    // 1. En la vista (HTML):
    // <a href="<?= BASE_URL ?>/entrenar/<?= $animal['id'] ?>" class="btn">Entrenar</a>

    // 2. En routes/web.php (Definimos el parámetro con llaves {}):
    // Route::get('/entrenar/{id}', [RefugioController::class, 'entrenarRuta']);

    // 3. En el controlador, la función RECIBE el dato como argumento:
    public static function entrenarRuta($id_animal){
        SessionManager::usuarioNoAutenticado("usuario", "login");

        // Ya no usamos $_GET['id'], el valor llega directamente en $id_animal
        $id_usuario = SessionManager::get('usuario')['id_usuario'] ?? null;

        if($id_animal && $id_usuario){
            $model = new RefugioModel;
            $exito = $model->entrenar($id_animal, $id_usuario);
            
            if($exito){
                SessionManager::setMensajeFlash("Entrenamiento (Ruta) Registrado", "✨", "exito");
            } else {
                SessionManager::setMensajeFlash("Error en entrenamiento", "❌", "error");
            }
        }
        header("Location: ".BASE_URL);
        exit();
    }
    */
}
