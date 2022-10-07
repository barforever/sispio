<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//con esto habilitamos el Requests en nuestra carpeta donde esta guardada nuestro sistema
use sispio\Http\Requests;
//con esto agregamos el modelo que vamos a utilizar en este controlador
//es decir le asignamos a que modelo va a controlar nuestro controlador
use App\Insumo;
//llamamos a Redirect para hacer redicciones
use Illuminate\Support\Facades\Redirect;
//llamamos al request creado para Categoria
use App\Http\Requests\InsumoFormRequest;
//llamamos a la clase DB de Laravel
use DB;

class InsumoController extends Controller
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
            $m = DB::table('insumo')
            ->select(DB::raw('COUNT(idinsumo) as n'))
            ->first();

            //$n = $m->n;
            $n = 1;
            
            $query = trim($request->get('searchText'));
            $insumos = DB::table('insumo')
            ->where('nombre','LIKE','%'.$query.'%')
            ->orderBy('nombre','asc')
            ->paginate(10);
            return view('almacen.insumo.index',["insumos"=>$insumos,"searchText"=>$query,"n"=>$n]);
        }
        //return view('almacen.categoria.index');
    }
    
    //creamos la funcion create (crear), crea un nuevo elemento para ser almacenado, solo crea no guarda.
    public function create()
    {
        return view("almacen.insumo.create");
    }

    //creamos la funcion store (almacenar), almacena o guarda el elemento nuevo.
    //va recibir un parametro de validacion, ¿que usabamos para validar? pues habiamos creado un CategoriaFormRequest
    //que nos valida los datos ingresados desde los formulario html.
    public function store(InsumoFormRequest $request)
    {
        
        $insumo = new Insumo; //creamos un nuevo objeto (una categoria)
        $insumo->nombre = $request->get('nombre'); //al campo nombre le pasamos el nombre obtenido del formulario html
        $insumo->cantidad = $request->get('cantidad'); //al campo estado le asignamos 1 por default
        $insumo->unidad_medida = $request->get('unidad_medida');  //al campo estado le asignamos 1 por default
        $insumo->save();                           //guardamos la categoria en la base de datos
        return Redirect::to('almacen/insumo');     //redireccionamos a almacen/categoria donde va estar nuestro index(pagina principal) para categoria.
    }
    
    //creamos la funcion show (mostrar), muestra los datos de la tabla
    //recibe un parametro id para mostrar solo la categoria que se le pida mediante el id
    public function show($id)
    {
        return view("almacen.insumo.show",["insumo"=>Insumo::findOrFail($id)]);//llama a la vista show y le envia la categoria id
    }
    
    //creamos la funcion edit (editar), edita los datos de la tabla pero no las guarda
    //recibe un parametro id, lo cual despues creare un formulario para que se muestre la categoria correspondiente al id
    //la funcion solo nos mostrara la categoria, lo cual podra ser editada  pero se guardara con la funcion update.
    public function edit($id)
    {
        return view("almacen.insumo.edit",["insumo"=>Insumo::findOrFail($id)]);
    }
    
    //creamos la funcion update (actualizar), actualiza los datos de la tabla y guarda.
    //recibe dos parametros, el primero $request recibira los datos enviados por la funcion edit para ser validados.
    // el segundo parametro $id recibira el id de la categoria que quiero modificar.
    public function update(InsumoFormRequest $request,$id)
    {
        $insumo = Insumo::findOrFail($id); //traigo al objeto categoria mediante el id el cual se almacena en $categoria
        $insumo->nombre = $request->get('nombre'); //aqui el nombre sera el que este dentro de nuestro objeto nombre del formulario html
        $insumo->cantidad = $request->get('cantidad'); //aqui el nombre sera el que este dentro de nuestro objeto nombre del formulario html
        $insumo->unidad_medida = $request->get('unidad_medida');
        $insumo->update(); //actualiza el objeto categoria
        return Redirect::to('almacen/insumo');     //redireccionamos a almacen/categoria donde va estar nuestro index(pagina principal) para categoria
    }
    
    //Creamos la funcion destroy (borrar), borra o destruye datos de la tabla
    //Recibe un parametro $id para saber que categoria sera borrada. en nuestro caso no eliminamos la categoria
    // simplemente le cambiamos el estado, ya que si el estado es 1 se muestra y si es 0 ya no se muestra en el index.
    //Esto de mostrar si es 1 y ocultar si es 0 lo habiamos echo en la funcion index ->where('condicion','=','1')
    public function destroy($id)
    {
        $insumo = Insumo::findOrFail($id);
        $insumo->delete();
        
        return Redirect::to('almacen/insumo');
    }
}
