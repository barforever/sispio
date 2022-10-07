<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//con esto habilitamos el Requests en nuestra carpeta donde esta guardada nuestro sistema
use sisvenpopi\Http\Requests;
//con esto agregamos el modelo que vamos a utilizar en este controlador
//es decir le asignamos a que modelo va a controlar nuestro controlador
use App\Colaborador;
//llamamos a Redirect para hacer redicciones
use Illuminate\Support\Facades\Redirect;
//llamamos a Input para poder subir la imagen del cliente hacia nuestro servidor
use Illuminate\Support\Facades\Input;
//llamamos al request creado para Producto
use App\Http\Requests\ColaboradorFormRequest;
//llamamos a la clase DB de Laravel
use DB;

class ColaboradorController extends Controller
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
            $colaboradores = DB::table('colaborador as c')
            ->join('cargo as ca','c.idcargo','=','ca.idcargo')
            ->join('turno as t','c.idturno','=','t.idturno')
            ->select('c.idcolaborador','c.nickname','ca.nombre','t.hora_inicio','t.hora_salida','c.estado')
            ->where('c.nombres','LIKE','%'.$query.'%')
            ->orwhere('c.nombres','LIKE','%'.$query.'%')
            ->orderBy('c.estado','desc')
            ->orderBy('c.nickname','asc')            
            ->paginate(10);
            return view('personal.colaborador.index',["colaboradores"=>$colaboradores,"searchText"=>$query,"n"=>$n]);
        }        
    }
    
    //creamos la funcion create (crear), crea un nuevo elemento para ser almacenado, solo crea no guarda.
    public function create()
    {
        //hacer la consulta de las categorias para ponerlas en un combobox y poder seleccionarlas al momento de escoger su categoria
        $cargos = DB::table('cargo')->get();
        $turnos = DB::table('turno')->get();

        return view("personal.colaborador.create",["cargos"=>$cargos,"turnos"=>$turnos]);
    }

    //creamos la funcion store (almacenar), almacena o guarda el elemento nuevo.
    //va recibir un parametro de validacion, ¿que usabamos para validar? pues habiamos creado un ProductoFormRequest
    //que nos valida los datos ingresados desde los formulario html.
    public function store(ColaboradorFormRequest $request)
    {        
        $colaborador = new Colaborador; //creamos un nuevo objeto (un colaborador)
        $colaborador->idcargo = $request->get('idcargo');
        $colaborador->idturno = $request->get('idturno');
        $colaborador->nickname = $request->get('nickname'); //al campo nombre le pasamos el nombre obtenido del formulario html
        $colaborador->nombres = $request->get('nombres');
        $colaborador->apellidos = $request->get('apellidos');
        $colaborador->dni = $request->get('dni');
        $colaborador->direccion = $request->get('direccion');
        $colaborador->telefono = $request->get('telefono');
        $colaborador->estado = '1';                     //al campo estado le asignamos 1 por default
        $colaborador->save();                           //personal colaborador categoria en la base de datos
        return Redirect::to('personal/colaborador');     //redireccionamos a almacen/categoria donde va estar nuestro index(pagina principal) para categoria.
    }
    
    //creamos la funcion show (mostrar), muestra los datos de la tabla
    //recibe un parametro id para mostrar solo la categoria que se le pida mediante el id
    public function show($id)
    {
        $colaborador = DB::table('colaborador as c')
        ->join('cargo as ca','c.idcargo','=','ca.idcargo')
        ->join('turno as t','c.idturno','=','t.idturno')
        ->select('c.idcolaborador','c.nickname','c.nombres','c.apellidos','c.dni','c.direccion','c.telefono','c.estado','ca.nombre','ca.sueldo','t.hora_inicio','t.hora_salida')
        ->where('c.idcolaborador','=',$id)
        ->first();

        return view("personal.colaborador.show",["colaborador"=>$colaborador]);//llama a la vista show y le envia la categoria id
    }
    
    //creamos la funcion edit (editar), edita los datos de la tabla pero no las guarda
    //recibe un parametro id, lo cual despues creare un formulario para que se muestre la categoria correspondiente al id
    //la funcion solo nos mostrara la categoria, lo cual podra ser editada  pero se guardara con la funcion update.
    public function edit($id)
    {
        $colaborador = Colaborador::findOrFail($id);
        $cargos = DB::table('cargo')->get();
        $turnos = DB::table('turno')->get();

        return view("personal.colaborador.edit",["colaborador"=>$colaborador,"cargos"=>$cargos,"turnos"=>$turnos]);
    }
    
    //creamos la funcion update (actualizar), actualiza los datos de la tabla y guarda.
    //recibe dos parametros, el primero $request recibira los datos enviados por la funcion edit para ser validados.
    // el segundo parametro $id recibira el id de la categoria que quiero modificar.
    public function update(ColaboradorFormRequest $request,$id)
    {
        $colaborador = Colaborador::findOrFail($id); //traigo al objeto colaborador mediante el id el cual se almacena en $colaborador
        $colaborador->idcargo = $request->get('idcargo');
        $colaborador->idturno = $request->get('idturno');
        $colaborador->nickname = $request->get('nickname'); //al campo nombre le pasamos el nombre obtenido del formulario html
        $colaborador->nombres = $request->get('nombres');
        $colaborador->apellidos = $request->get('apellidos');
        $colaborador->dni = $request->get('dni');
        $colaborador->direccion = $request->get('direccion');
        $colaborador->telefono = $request->get('telefono');
        $colaborador->update(); //actualiza el objeto colaborador
        return Redirect::to('personal/colaborador');     //redireccionamos a almacen/categoria donde va estar nuestro index(pagina principal) para categoria
    }
    
    //Creamos la funcion destroy (borrar), borra o destruye datos de la tabla
    //Recibe un parametro $id para saber que categoria sera borrada. en nuestro caso no eliminamos la categoria
    // simplemente le cambiamos el estado, ya que si el estado es 1 se muestra y si es 0 ya no se muestra en el index.
    //Esto de mostrar si es 1 y ocultar si es 0 lo habiamos echo en la funcion index ->where('condicion','=','1')
    public function destroy($id)
    {
        $colaborador = Colaborador::findOrFail($id);
        if ($colaborador->estado == '1') {
            $colaborador->estado = '0';
            $colaborador->update();
        } 
        else {
            $colaborador->estado = '1';
            $colaborador->update();
        };

        return Redirect::to('personal/colaborador');
    }
}
