<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//con esto habilitamos el Requests en nuestra carpeta donde esta guardada nuestro sistema
use sisvenpopi\Http\Requests;
//con esto agregamos el modelo que vamos a utilizar en este controlador
//es decir le asignamos a que modelo va a controlar nuestro controlador
use App\Ingreso;
use App\DetalleIngreso;
//llamamos a Redirect para hacer redicciones
use Illuminate\Support\Facades\Redirect;
//llamamos a Input para poder subir la imagen del cliente hacia nuestro servidor
use Illuminate\Support\Facades\Input;
//llamamos al request creado para Producto
use App\Http\Requests\IngresoFormRequest;
//llamamos a la clase DB de Laravel
use DB;

use Carbon\Carbon; //obtiene la fecha segun la zona horaria
use Response;
use Iluminate\Support\Collection;

class IngresoController extends Controller
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
            
            $query = trim($request->get('searchText'));
            $compras = DB::table('ingreso as i')
            ->join('persona as p','i.idproveedor','=','p.idpersona')
            ->select('i.idingreso','i.fecha','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.estado',DB::raw('SUM(monto_total) as monto_total'))
            ->where('i.num_comprobante','LIKE','%'.$query.'%')
            ->whereDate('i.fecha',$h)
            ->groupBy('i.idingreso','i.fecha','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.estado')
            ->orderBy('i.fecha','desc')
            ->paginate(20);
            
            $m = DB::table('ingreso')
            ->select(DB::raw('COUNT(idingreso) as n'))
            ->whereDate('fecha',$h)
            ->first();

            $n = $m->n;

            return view('almacen.ingreso.index',["compras"=>$compras,"searchText"=>$query,"hoy"=>$hoy,"n"=>$n]);
        }        
    }
    
    //creamos la funcion create (crear), crea un nuevo elemento para ser almacenado, solo crea no guarda.
    public function create()
    {
        $proveedores = DB::table('persona')
        ->where('tipo_persona','=','proveedor')
        ->where('estado','=','1')
        ->orderBy('idpersona','desc')
        ->get();

        $insumos = DB::table('insumo')
        ->select('idinsumo','nombre','cantidad','unidad_medida')
        ->get();

        $igv = 0.18;
        $numnv = DB::table('ingreso')
        ->select(DB::raw('MAX(num_comprobante) as num_comprobante'))
        ->where('serie_comprobante','=','01')
        ->first();

        $numb = DB::table('ingreso')
        ->select(DB::raw('MAX(num_comprobante) as num_comprobante'))
        ->where('serie_comprobante','=','02')
        ->first();

        $numf = DB::table('ingreso')
        ->select(DB::raw('MAX(num_comprobante) as num_comprobante'))
        ->where('serie_comprobante','=','03')
        ->first();

        return view("almacen.ingreso.create",["proveedores"=>$proveedores,"insumos"=>$insumos,"igv"=>$igv,"numnv"=>$numnv,"numb"=>$numb,"numf"=>$numf]);
    }

    //creamos la funcion store (almacenar), almacena o guarda el elemento nuevo.
    //va recibir un parametro de validacion, ¿que usabamos para validar? pues habiamos creado un ProductoFormRequest
    //que nos valida los datos ingresados desde los formulario html.
    public function store(IngresoFormRequest $request)
    {
        try{
            DB::beginTransaction();
            $ingreso = new Ingreso;
            $ingreso->idproveedor = $request->get('idproveedor'); //
            $ingreso->tipo_comprobante = $request->get('tipo_comprobante');
            $ingreso->serie_comprobante = $request->get('serie_comprobante');
            $ingreso->num_comprobante = $request->get('num_comprobante');

            $mytime = Carbon::now('America/Lima');
            $ingreso->fecha = $mytime->toDateTimeString();
            $ingreso->monto_total = $request->get('monto_total');
            $ingreso->estado = '1';
            $ingreso->save(); 

            $idinsumo = $request->get('idinsumo');
            $cantidad = $request->get('cantidad');
            $precio_compra = $request->get('precio_compra');

            $cont = 0;

            while($cont < count($idinsumo)){
                $detalle = new DetalleIngreso();
                $detalle->idingreso = $ingreso->idingreso;
                $detalle->idinsumo = $idinsumo[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precio_compra = $precio_compra[$cont];
                $detalle->save();
                $cont=$cont+1;
            }

            DB::commit();
        }catch(\Exception $e)
        {
            DB::rollback();
        }
        
        return Redirect::to('almacen/ingreso');     //redireccionamos a almacen/categoria donde va estar nuestro index(pagina principal) para categoria.
    }
    
    //creamos la funcion show (mostrar), muestra los datos de la tabla
    //recibe un parametro id para mostrar solo la categoria que se le pida mediante el id
    public function show($id)
    {
        $ingreso = DB::table('ingreso as i')
        ->join('persona as p','i.idproveedor','=','p.idpersona')
        ->where('i.idingreso','=',$id)
        ->first();

        $detalleingreso = DB::table('detalleingreso as di')
        ->join('insumo as i','di.idinsumo','=','i.idinsumo')
        ->select('di.idingreso','i.nombre','i.unidad_medida','di.cantidad','di.precio_compra')
        ->where('di.idingreso','=',$id)
        ->get();

        $n = 1;
        $igv = 0.18;
        $st = $ingreso->monto_total/(1+$igv);
        $igv2 = $ingreso->monto_total-$st;

        return view("almacen.ingreso.show",["ingreso"=>$ingreso,"detalleingreso"=>$detalleingreso,"n"=>$n,"igv2"=>$igv2,"st"=>$st]);//llama a la vista show y le envia la categoria id
    }
    
    //creamos la funcion edit (editar), edita los datos de la tabla pero no las guarda
    //recibe un parametro id, lo cual despues creare un formulario para que se muestre la categoria correspondiente al id
    //la funcion solo nos mostrara la categoria, lo cual podra ser editada  pero se guardara con la funcion update.
    //public function edit($id)
    //{
      //  $producto = Producto::findOrFail($id);
      //  $categorias = DB::table('categoria')->where('estado','=','1')->get();

        //return view("almacen.producto.edit",["producto"=>$producto,"categorias"=>$categorias]);
    //}
    
     
    //Creamos la funcion destroy (borrar), borra o destruye datos de la tabla
    //Recibe un parametro $id para saber que categoria sera borrada. en nuestro caso no eliminamos la categoria
    // simplemente le cambiamos el estado, ya que si el estado es 1 se muestra y si es 0 ya no se muestra en el index.
    //Esto de mostrar si es 1 y ocultar si es 0 lo habiamos echo en la funcion index ->where('condicion','=','1')
    public function destroy($id)
    {
        $pedido = DB::table('pedido as p')
        ->join('mesa as m','p.idmesa','=','m.idmesa')
        ->select('p.idpedido','m.idmesa')
        ->where('p.estado','=','2')
        ->where('m.idmesa','=',$id)
        ->first();

        $pe = Pedido::findOrFail($pedido->idpedido);
        $pe->estado = '0';
        $pe->update();

        $me = Mesa::findOrFail($pedido->idmesa);
        $me->estado = '1';
        $me->update();        
        
        return Redirect::to('ventas/pedido');
    }
}
