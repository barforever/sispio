<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//con esto habilitamos el Requests en nuestra carpeta donde esta guardada nuestro sistema
use sisvenpopi\Http\Requests;
//con esto agregamos el modelo que vamos a utilizar en este controlador
//es decir le asignamos a que modelo va a controlar nuestro controlador
use App\Mozo;
//llamamos a Redirect para hacer redicciones
use Illuminate\Support\Facades\Redirect;
//llamamos al request creado para Categoria
use App\Http\Requests\MozoFormRequest;
//llamamos a la clase DB de Laravel
use DB;

class MozoController extends Controller
{
    //creamos una funcion publica de constructor que nos permite construir cada una de las funciones siguientes
    public function __contructor()
    {

    }
    
    //creamos la funcion index (indice), esta para la vista de la pagina principal de categorias.
    // donde va recibir como parametro un objeto de tipo Request y el objeto que recibe se va llamar $request
    public function index(Request $request)
    {
        if ($request)
        {
            $query = trim($request->get('searchText'));
            $mozos = DB::table('mozo')
            ->where('mozo','LIKE','%'.$query.'%')
            ->where('estado','=','1')
            ->orderBy('idmozo','desc')
            ->paginate(5);
            return view('ventas.mozo.index',["mozos"=>$mozos,"searchText"=>$query]);
        }
    }
    
    //creamos la funcion create (crear), crea un nuevo elemento para ser almacenado, solo crea no guarda.
    public function create()
    {
        return view("ventas.mozo.create");
    }

    //creamos la funcion store (almacenar), almacena o guarda el elemento nuevo.
    //va recibir un parametro de validacion, ¿que usabamos para validar? pues habiamos creado un CategoriaFormRequest
    //que nos valida los datos ingresados desde los formulario html.
    public function store(MozoFormRequest $request)
    {
        $mozo = new Mozo; //creamos un nuevo objeto (una categoria)
        $mozo->mozo = $request->get('mozo'); //al campo nombre le pasamos el nombre obtenido del formulario html
        $mozo->nombres = $request->get('nombres'); //al campo nombre le pasamos el nombre obtenido del formulario html
        $mozo->apellidos = $request->get('apellidos'); //al campo nombre le pasamos el nombre obtenido del formulario html
        $mozo->telefono = $request->get('telefono'); //al campo nombre le pasamos el nombre obtenido del formulario html
        $mozo->estado = '1'; //al campo nombre le pasamos el nombre obtenido del formulario html
        $mozo->save();                           //guardamos la categoria en la base de datos
        return Redirect::to('ventas/mozo');     //redireccionamos a almacen/categoria donde va estar nuestro index(pagina principal) para categoria.
    }
    
    //creamos la funcion show (mostrar), muestra los datos de la tabla
    //recibe un parametro id para mostrar solo la categoria que se le pida mediante el id
    public function show($id)
    {
        return view("ventas.mozo.show",["mozo"=>Mozo::findOrFail($id)]);//llama a la vista show y le envia la categoria id
    }
    
    //creamos la funcion edit (editar), edita los datos de la tabla pero no las guarda
    //recibe un parametro id, lo cual despues creare un formulario para que se muestre la categoria correspondiente al id
    //la funcion solo nos mostrara la categoria, lo cual podra ser editada  pero se guardara con la funcion update.
    public function edit($id)
    {
        return view("ventas.mozo.edit",["mozo"=>Mozo::findOrFail($id)]);
    }
    
    //creamos la funcion update (actualizar), actualiza los datos de la tabla y guarda.
    //recibe dos parametros, el primero $request recibira los datos enviados por la funcion edit para ser validados.
    // el segundo parametro $id recibira el id de la categoria que quiero modificar.
    public function update(MozoFormRequest $request,$id)
    {
        $mozo = Mozo::findOrFail($id); //traigo al objeto categoria mediante el id el cual se almacena en $categoria
        $mozo->mozo = $request->get('mozo'); //al campo nombre le pasamos el nombre obtenido del formulario html
        $mozo->nombres = $request->get('nombres'); //al campo nombre le pasamos el nombre obtenido del formulario html
        $mozo->apellidos = $request->get('apellidos'); //al campo nombre le pasamos el nombre obtenido del formulario html
        $mozo->telefono = $request->get('telefono'); //al campo nombre le pasamos el nombre obtenido del formulario html
        $mozo->update(); //actualiza el objeto categoria
        return Redirect::to('ventas/mozo');     //redireccionamos a almacen/categoria donde va estar nuestro index(pagina principal) para categoria
    }
    
    //Creamos la funcion destroy (borrar), borra o destruye datos de la tabla
    //Recibe un parametro $id para saber que categoria sera borrada. en nuestro caso no eliminamos la categoria
    // simplemente le cambiamos el estado, ya que si el estado es 1 se muestra y si es 0 ya no se muestra en el index.
    //Esto de mostrar si es 1 y ocultar si es 0 lo habiamos echo en la funcion index ->where('condicion','=','1')
    public function destroy($id)
    {
        $mozo = Mozo::findOrFail($id);
        $mozo->estado = '0';
        $mozo->update();
        return Redirect::to('ventas/mozo');
    }
}
