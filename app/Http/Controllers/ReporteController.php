<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//con esto habilitamos el Requests en nuestra carpeta donde esta guardada nuestro sistema
use sisvenpopi\Http\Requests;
//con esto agregamos el modelo que vamos a utilizar en este controlador
//es decir le asignamos a que modelo va a controlar nuestro controlador
use App\Venta;
use App\DetalleVenta;
use App\Gasto;
//llamamos a Redirect para hacer redicciones
use Illuminate\Support\Facades\Redirect;
//llamamos a Input para poder subir la imagen del cliente hacia nuestro servidor
use Illuminate\Support\Facades\Input;
//llamamos al request creado para Producto
use App\Http\Requests\VentaFormRequest;
//llamamos a la clase DB de Laravel
use DB;
use PDF;

use Carbon\Carbon; //obtiene la fecha segun la zona horaria
use Response;
use Iluminate\Support\Collection;

class ReporteController extends Controller
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
            $n = 0;
            
            $query = trim($request->get('searchText'));

            $ventas = DB::table('venta as v')
            ->join('pedido as p','v.idpedido','=','p.idpedido')
            ->join('colaborador as c','p.idmozo','=','c.idcolaborador')
            ->select('v.idventa','p.fecha','p.num_comanda','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.monto_total')
            ->whereDate('p.fecha',$query)
            ->orderBy('p.num_comanda','asc')
            ->groupBy('v.idventa','p.fecha','p.num_comanda','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.monto_total')
            ->paginate(500);
            
            $vtotal = DB::table('venta as v')
            ->join('pedido as p','v.idpedido','=','p.idpedido')
            ->select(DB::raw('SUM(v.monto_total) as monto_total'))
            ->whereDate('p.fecha',$query)
            ->first();
                        
            $compras = DB::table('ingreso as i')
            ->join('persona as pe','i.idproveedor','=','pe.idpersona')
            ->select('i.idingreso','i.fecha','pe.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.monto_total','pe.tipo_documento','pe.num_documento')
            ->whereDate('i.fecha',$query)
            ->orderBy('i.monto_total','desc')
            ->groupBy('i.idingreso','i.fecha','pe.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.monto_total','pe.tipo_documento','pe.num_documento')
            ->get();
            
            $ctotal = DB::table('ingreso')
            ->select(DB::raw('SUM(monto_total) as monto_total'))
            ->whereDate('fecha',$query)
            ->first();

            $n3 = 1;

            $tinsumos = DB::table('insumo as i')
            ->leftJoin('detalleingreso as di','i.idinsumo','=','di.idinsumo')
            ->leftJoin('ingreso as inn','di.idingreso','=','inn.idingreso')
            ->select('i.nombre','i.cantidad as actual','i.unidad_medida as um',DB::raw('i.cantidad-SUM(di.cantidad) as anterior'),DB::raw('SUM(di.cantidad) as ingreso'))
            ->groupBy('i.nombre','actual','um')
            ->orderBy('i.nombre','asc')
            ->get();
            
            return view('reportes.diario.index',["tinsumos"=>$tinsumos,"ventas"=>$ventas,"compras"=>$compras,"searchText"=>$query,"n"=>$n,"hoy"=>$hoy,"vtotal"=>$vtotal,"ctotal"=>$ctotal]);
        }       
     }

     public function reporte($fecha)
     {
        $hoy = Carbon::now('America/Lima')->format('d-m-Y');
        $h = Carbon::now('America/Lima')->format('Y-m-d');
        $n = 1;
        $fech = $fecha;

        $ventas = DB::table('venta as v')
        ->join('pedido as p','v.idpedido','=','p.idpedido')
        ->join('colaborador as c','p.idmozo','=','c.idcolaborador')
        ->join('persona as pe','v.idcliente','=','pe.idpersona')
        ->select('v.idventa','v.fecha','p.num_comanda','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.monto_total','c.nickname','pe.nombre')
        ->whereDate('p.fecha',$fecha)
        ->orderBy('p.num_comanda','desc')
        ->groupBy('v.idventa','v.fecha','p.num_comanda','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.monto_total','c.nickname','pe.nombre')
        ->get();

        $vtotal = DB::table('venta as v')
        ->join('pedido as p','v.idpedido','=','p.idpedido')
        ->select(DB::raw('SUM(v.monto_total) as monto_total'))
        ->whereDate('p.fecha',$fecha)
        ->first();

        $n2 = 1;

        $compras = DB::table('ingreso as i')
        ->join('persona as pe','i.idproveedor','=','pe.idpersona')
        ->select('i.idingreso','i.fecha','pe.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.monto_total','pe.tipo_documento','pe.num_documento')
        ->whereDate('i.fecha',$fecha)
        ->orderBy('i.monto_total','desc')
        ->groupBy('i.idingreso','i.fecha','pe.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.monto_total','pe.tipo_documento','pe.num_documento')
        ->get();
        
        $ctotal = DB::table('ingreso')
        ->select(DB::raw('SUM(monto_total) as monto_total'))
        ->whereDate('fecha',$fecha)
        ->first();

        $n3 = 1;

        $insumos = DB::table('insumo as i')
        ->leftjoin('detalleingreso as di','i.idinsumo','=','di.idinsumo')
        ->leftjoin('ingreso as inn','di.idingreso','=','inn.idingreso')
        ->whereDate('inn.fecha',$fecha)
        ->orderBy('i.nombre','asc')
        ->get();

        $pdf = PDF::loadView('reportes.diario.pdf.reporte',compact('fech','ventas','hoy','n','vtotal','compras','n2','ctotal','n3','insumos'));

        return $pdf->stream('reporte'.'-'.$fecha.'.pdf');
     }

     public function diarioinsumo($fecha)
     {
        $hoy = Carbon::now('America/Lima')->format('d-m-Y');
        $h = Carbon::now('America/Lima')->format('Y-m-d');
        $n = 1;
        $fech = $fecha;

        $n3 = 1;

        $insumos = DB::table('insumo as i')
        ->leftJoin('detalleingreso as di','i.idinsumo','=','di.idinsumo')
        ->leftJoin('ingreso as inn','di.idingreso','=','inn.idingreso')
        ->select('i.nombre','i.cantidad as actual','i.unidad_medida as um',DB::raw('i.cantidad-SUM(di.cantidad) as anterior'),DB::raw('SUM(di.cantidad) as ingreso'))
        ->whereDate('inn.fecha',$fecha)
        ->groupBy('i.nombre','actual','um')
        ->orderBy('i.nombre','asc')
        ->get();

        $tinsumos = DB::table('insumo as i')
        ->leftJoin('detalleingreso as di','i.idinsumo','=','di.idinsumo')
        ->leftJoin('ingreso as inn','di.idingreso','=','inn.idingreso')
        ->select('i.nombre','i.cantidad as actual','i.unidad_medida as um',DB::raw('i.cantidad-SUM(di.cantidad) as anterior'),DB::raw('SUM(di.cantidad) as ingreso'))
        ->groupBy('i.nombre','actual','um')
        ->orderBy('i.nombre','asc')
        ->get();

        $pdf = PDF::loadView('reportes.diario.pdf.diarioinsumo',compact('n3','insumos','tinsumos','fech'));

        return $pdf->stream('insumo'.$fecha.'.pdf');
     }
     
     //creamos la funcion create (crear), crea un nuevo elemento para ser almacenado, solo crea no guarda.
     public function create()
     {
 
         return view("ventas.venta.create");
     }
 
     //creamos la funcion store (almacenar), almacena o guarda el elemento nuevo.
     //va recibir un parametro de validacion, ¿que usabamos para validar? pues habiamos creado un ProductoFormRequest
     //que nos valida los datos ingresados desde los formulario html.
     public function store(VentaFormRequest $request)
     {
                 
         return Redirect::to('ventas/venta');     //redireccionamos a almacen/categoria donde va estar nuestro index(pagina principal) para categoria.
     }
     
     //creamos la funcion show (mostrar), muestra los datos de la tabla
     //recibe un parametro id para mostrar solo la categoria que se le pida mediante el id
     public function show($id)
     {         
         $venta = DB::table('venta as v')
             ->join('mozo as m','v.idmozo','=','m.idmozo')
             ->join('detalleventa as dv','v.idventa','=','dv.idventa')
             ->select('v.idventa','v.fecha','m.mozo','v.num_venta','v.mesa','v.estado','v.monto_total')
             ->where('v.idventa','=',$id)
             ->first();
 
         $detalles = DB::table('detalleventa as d')
             ->join('producto as p','d.idproducto','=','p.idproducto')
             ->select('p.nombre as producto','d.cantidad','d.precio_venta','p.cantpollo')
             ->where('d.idventa','=',$id)
             ->get();

         $pollo = DB::table('detalleventa as d')
             ->join('producto as p','d.idproducto','=','p.idproducto')
             ->select(DB::RAW('SUM(d.cantidad*p.cantpollo) as pollo'))
             ->where('d.idventa','=',$id)
             ->get();
 
         return view("reportes.diario.show",["venta"=>$venta,"detalles"=>$detalles,"pollo"=>$pollo]);//llama a la vista show y le envia la categoria id
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
         $venta = Venta::findOrFail($id);
         $venta->estado = '0';
         $venta->update();
         return Redirect::to('ventas/venta');
     }

     public function imprimir(){
        $pdf = PDF::loadView('personal.turno.create');

        return $pdf->stream();
     }
}
