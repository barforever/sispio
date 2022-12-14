<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//con esto habilitamos el Requests en nuestra carpeta donde esta guardada nuestro sistema
use sisvenpopi\Http\Requests;
//con esto agregamos el modelo que vamos a utilizar en este controlador
//es decir le asignamos a que modelo va a controlar nuestro controlador
use App\Gasto;
//llamamos a Redirect para hacer redicciones
use Illuminate\Support\Facades\Redirect;
//llamamos a Input para poder subir la imagen del cliente hacia nuestro servidor
use Illuminate\Support\Facades\Input;
//llamamos al request creado para Producto
use App\Http\Requests\GastoFormRequest;
//llamamos a la clase DB de Laravel
use DB;

use Carbon\Carbon; //obtiene la fecha segun la zona horaria
use Response;
use Iluminate\Support\Collection;

class GastoController extends Controller
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
            $hoy = Carbon::now('America/Lima')->format('d-m-Y');
            $h = Carbon::now('America/Lima')->format('Y-m-d');

            $m = DB::table('gasto')
            ->select(DB::raw('COUNT(idgasto) as n'))
            ->whereDate('fecha',$h)
            ->first();
            $n = $m->n;

            $costo = DB::table('gasto')
            ->select(DB::raw('SUM(costo) as costo'))
            ->where('estado','=','1')
            ->whereDate('fecha',$h)
            ->get();

            $query = trim($request->get('searchText'));
            $gastos = DB::table('gasto')
            ->select('idgasto','fecha','nombre','cantidad','costo','detalle','estado')
            ->where('nombre','LIKE','%'.$query.'%')
            ->whereDate('fecha',$h)
            ->orderBy('idgasto','desc')
            ->paginate(10);

            return view('almacen.gasto.index',["gastos"=>$gastos,"searchText"=>$query,"costo"=>$costo,"hoy"=>$hoy,"n"=>$n]);
        }        
    }
    
    //creamos la funcion create (crear), crea un nuevo elemento para ser almacenado, solo crea no guarda.
    public function create()
    {
        return view("almacen.gasto.create");
    }

    //creamos la funcion store (almacenar), almacena o guarda el elemento nuevo.
    //va recibir un parametro de validacion, ??que usabamos para validar? pues habiamos creado un ProductoFormRequest
    //que nos valida los datos ingresados desde los formulario html.
    public function store(GastoFormRequest $request)
    {
        $gasto = new Gasto;
        $mytime = Carbon::now('America/Lima');
        $gasto->fecha = $mytime->toDateTimeString();
        $gasto->nombre = $request->get('nombre');
        $gasto->cantidad = $request->get('cantidad');
        $gasto->costo = $request->get('costo');
        $gasto->detalle = $request->get('detalle');
        $gasto->estado = '1';
        $gasto->save();
        return Redirect::to('almacen/gasto');
    }
    
    //creamos la funcion show (mostrar), muestra los datos de la tabla
    //recibe un parametro id para mostrar solo la categoria que se le pida mediante el id
    public function show($id)
    {
        $gasto = DB::table('gasto')
            ->select('idgasto','fecha','nombre','cantidad','costo','detalle','estado')
            ->where('idgasto','=',$id)
            ->first();
        
        return view("almacen.gasto.show",["gasto"=>$gasto]);//llama a la vista show y le envia la categoria id
    }
    
    //creamos la funcion edit (editar), edita los datos de la tabla pero no las guarda
    //recibe un parametro id, lo cual despues creare un formulario para que se muestre la categoria correspondiente al id
    //la funcion solo nos mostrara la categoria, lo cual podra ser editada  pero se guardara con la funcion update.
    //public function edit($id)
    //{
    //    return view("almacen.gasto.edit",["gasto"=>Gasto::findOrFail($id)]);
    //}
    
   
    
    //Creamos la funcion destroy (borrar), borra o destruye datos de la tabla
    //Recibe un parametro $id para saber que categoria sera borrada. en nuestro caso no eliminamos la categoria
    // simplemente le cambiamos el estado, ya que si el estado es 1 se muestra y si es 0 ya no se muestra en el index.
    //Esto de mostrar si es 1 y ocultar si es 0 lo habiamos echo en la funcion index ->where('condicion','=','1')
    public function destroy($id)
    {
        $gasto = Gasto::findOrFail($id);
        $gasto->estado = '0';
        $gasto->update();
        return Redirect::to('almacen/gasto');
    }
}
