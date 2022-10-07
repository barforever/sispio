<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//con esto habilitamos el Requests en nuestra carpeta donde esta guardada nuestro sistema
use sispio\Http\Requests;
//con esto agregamos el modelo que vamos a utilizar en este controlador
//es decir le asignamos a que modelo va a controlar nuestro controlador
use App\Persona;
//llamamos a Redirect para hacer redicciones
use Illuminate\Support\Facades\Redirect;
//llamamos al request creado para Categoria
use App\Http\Requests\PersonaFormRequest;
//llamamos a la clase DB de Laravel
use DB;

class ProveedorController extends Controller
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
            $n = 1;

            $query = trim($request->get('searchText'));
            $proveedores = DB::table('persona')            
            ->where('nombre','LIKE','%'.$query.'%')
            ->where('tipo_persona','=','proveedor')            
            ->orwhere('num_documento','LIKE','%'.$query.'%')
            ->where('tipo_persona','=','proveedor') 
            ->orderBy('estado','desc')
            ->orderBy('nombre','asc')
            ->paginate(10);
            return view('almacen.proveedor.index',["proveedores"=>$proveedores,"searchText"=>$query,"n"=>$n]);
        }
        //return view('almacen.categoria.index');
    }
    
    //creamos la funcion create (crear), crea un nuevo elemento para ser almacenado, solo crea no guarda.
    public function create()
    {
        return view("almacen.proveedor.create");
    }

    //creamos la funcion store (almacenar), almacena o guarda el elemento nuevo.
    //va recibir un parametro de validacion, ¿que usabamos para validar? pues habiamos creado un CategoriaFormRequest
    //que nos valida los datos ingresados desde los formulario html.
    public function store(PersonaFormRequest $request)
    {
        
        $proveedor = new Persona; //creamos un nuevo objeto (una categoria)
        $proveedor->tipo_persona = 'proveedor'; //al campo nombre le pasamos el nombre obtenido del formulario html
        $proveedor->nombre = $request->get('nombre'); //al campo estado le asignamos 1 por default
        $proveedor->tipo_documento = $request->get('tipo_documento'); //al campo estado le asignamos 1 por default
        $proveedor->num_documento = $request->get('num_documento');
        $proveedor->direccion = $request->get('direccion');
        $proveedor->telefono = $request->get('telefono');
        $proveedor->f_nacimiento = $request->get('f_nacimiento');
        $proveedor->email = $request->get('email');
        $proveedor->estado = '1';
        $proveedor->save();                           //guardamos la categoria en la base de datos
        return Redirect::to('almacen/proveedor');     //redireccionamos a almacen/categoria donde va estar nuestro index(pagina principal) para categoria.
    }
    
    //creamos la funcion show (mostrar), muestra los datos de la tabla
    //recibe un parametro id para mostrar solo la categoria que se le pida mediante el id
    public function show($id)
    {
        $proveedor = DB::table('persona')            
        ->select('nombre','tipo_documento','num_documento','direccion','telefono','f_nacimiento','email')
        ->where('idpersona','=',$id)
        ->first();

        $visitas = DB::table('ingreso')
        ->select(DB::RAW('COUNT(idingreso) as cant'))
        ->where('idproveedor','=',$id)
        ->first();

        return view("almacen.proveedor.show",["proveedor"=>$proveedor,"visitas"=>$visitas]);//llama a la vista show y le envia la categoria id
    }
    
    //creamos la funcion edit (editar), edita los datos de la tabla pero no las guarda
    //recibe un parametro id, lo cual despues creare un formulario para que se muestre la categoria correspondiente al id
    //la funcion solo nos mostrara la categoria, lo cual podra ser editada  pero se guardara con la funcion update.
    public function edit($id)
    {
        return view("almacen.proveedor.edit",["proveedor"=>Persona::findOrFail($id)]);
    }
    
    //creamos la funcion update (actualizar), actualiza los datos de la tabla y guarda.
    //recibe dos parametros, el primero $request recibira los datos enviados por la funcion edit para ser validados.
    // el segundo parametro $id recibira el id de la categoria que quiero modificar.
    public function update(PersonaFormRequest $request,$id)
    {
        $proveedor = Persona::findOrFail($id); //traigo al objeto categoria mediante el id el cual se almacena en $categoria
        $proveedor->nombre = $request->get('nombre'); //al campo estado le asignamos 1 por default
        $proveedor->tipo_documento = $request->get('tipo_documento'); //al campo estado le asignamos 1 por default
        $proveedor->num_documento = $request->get('num_documento');
        $proveedor->direccion = $request->get('direccion');
        $proveedor->telefono = $request->get('telefono');
        $proveedor->f_nacimiento = $request->get('f_nacimiento');
        $proveedor->email = $request->get('email');
        $proveedor->update(); //actualiza el objeto categoria
        return Redirect::to('almacen/proveedor');     //redireccionamos a almacen/categoria donde va estar nuestro index(pagina principal) para categoria
    }
    
    //Creamos la funcion destroy (borrar), borra o destruye datos de la tabla
    //Recibe un parametro $id para saber que categoria sera borrada. en nuestro caso no eliminamos la categoria
    // simplemente le cambiamos el estado, ya que si el estado es 1 se muestra y si es 0 ya no se muestra en el index.
    //Esto de mostrar si es 1 y ocultar si es 0 lo habiamos echo en la funcion index ->where('condicion','=','1')
    public function destroy($id)
    {
        $proveedor = Persona::findOrFail($id);
        if ($proveedor->estado == '1') {
            $proveedor->estado = '0';
            $proveedor->update();
        } 
        else {
            $proveedor->estado = '1';
            $proveedor->update();
        }
                
        return Redirect::to('almacen/proveedor');
    }
}
