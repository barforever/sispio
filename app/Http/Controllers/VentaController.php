<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//con esto habilitamos el Requests en nuestra carpeta donde esta guardada nuestro sistema
use sisvenpopi\Http\Requests;
//con esto agregamos el modelo que vamos a utilizar en este controlador
//es decir le asignamos a que modelo va a controlar nuestro controlador
use App\Venta;
use App\Pedido;
use App\Mesa;
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

class VentaController extends Controller
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
            $fech = $h;
            
            $query = trim($request->get('searchText'));
            $pedidos = DB::table('pedido as p')
            ->join('mesa as m','p.idmesa','=','m.idmesa')
            ->join('colaborador as c','p.idmozo','=','c.idcolaborador')
            ->join('detallepedido as dp','p.idpedido','=','dp.idpedido')
            ->select('p.idpedido','p.fecha','p.num_comanda','m.num_mesa','c.nickname',DB::raw('SUM(dp.precio_venta*dp.cantidad) as monto_total'))
            ->where('m.num_mesa','LIKE','%'.$query.'%')
            ->where('p.estado','=','2')
            ->whereDate('p.fecha',$h)
            ->orderBy('p.fecha','asc')
            ->groupBy('p.idpedido','p.fecha','p.num_comanda','m.num_mesa','c.nickname')
            ->paginate(20);

            $ventas = DB::table('venta as v')
            ->join('pedido as p','v.idpedido','=','p.idpedido')
            ->join('persona as pe','v.idcliente','=','pe.idpersona')
            ->where('v.num_comprobante','LIKE','%'.$query.'%')
            ->where('v.estado','=','1')
            ->whereDate('p.fecha',$h)
            ->orderBy('v.idventa','desc')
            ->paginate(100);

            $m2 = DB::table('pedido')
            ->select(DB::raw('COUNT(idpedido) as n'))
            ->where('estado','=','2')
            ->whereDate('fecha',$h)
            ->first();           
            $n2 = $m2->n;

            $m = DB::table('venta as v')
            ->join('pedido as p','v.idpedido','=','p.idpedido')
            ->select(DB::raw('COUNT(v.idventa) as n'))
            ->whereDate('v.fecha',$h)
            ->first();
            $n = $m->n;

            $sumav = DB::table('venta')
            ->select(DB::raw('SUM(monto_total) as monto_total'))
            ->where('estado','=','1')
            ->whereDate('fecha',$h)
            ->first();
            
            $sumac = DB::table('ingreso')
            ->select(DB::raw('SUM(monto_total) as monto_total'))
            ->where('estado','=','1')
            ->whereDate('fecha',$h)
            ->first();   
            
            return view('ventas.venta.index',["pedidos"=>$pedidos,"searchText"=>$query,"hoy"=>$hoy,"n"=>$n,"n2"=>$n2,"ventas"=>$ventas,"sumav"=>$sumav,"sumac"=>$sumac,"fech"=>$fech]);
        }        
    }
    
    //creamos la funcion create (crear), crea un nuevo elemento para ser almacenado, solo crea no guarda.
    public function create($id)
    {
        $n = 1;

        $clientes = DB::table('persona')
        ->where('tipo_persona','=','cliente')
        ->where('estado','=','1')
        ->orderBy('idpersona','desc')
        ->get();

        //$query = trim($request->get('searchText'));
        $pedido = DB::table('pedido as p')
        ->join('mesa as m','p.idmesa','=','m.idmesa')
        ->join('colaborador as c','p.idmozo','=','c.idcolaborador')
        ->select('p.idpedido','p.fecha','m.num_mesa','c.nickname','p.estado')
        ->where('p.idpedido','=',$id)
        ->first();

        $detallepedido = DB::table('detallepedido as dp')
        ->join('producto as pro','dp.idproducto','=','pro.idproducto')
        ->select('pro.nombre','dp.cantidad','pro.precio','dp.precio_venta')
        ->where('dp.idpedido','=',$id)
        ->get();

        $total = DB::table('pedido as p')
        ->join('detallepedido as dp','p.idpedido','=','dp.idpedido')
        ->select('p.idpedido',DB::Raw('SUM(dp.cantidad*dp.precio_venta) as monto_total'))
        ->where('p.idpedido','=',$id)
        ->groupBy('p.idpedido')
        ->first();

        $igv = 0.18;
        $st = $total->monto_total/(1+$igv);
        $igv2 = $total->monto_total-$st;

        $numnv = DB::table('venta')
        ->select(DB::raw('MAX(num_comprobante) as num_comprobante'))
        ->where('serie_comprobante','=','01')
        ->first();

        $numb = DB::table('venta')
        ->select(DB::raw('MAX(num_comprobante) as num_comprobante'))
        ->where('serie_comprobante','=','02')
        ->first();

        $numf = DB::table('venta')
        ->select(DB::raw('MAX(num_comprobante) as num_comprobante'))
        ->where('serie_comprobante','=','03')
        ->first();

        return view("ventas.venta.create",["clientes"=>$clientes,"pedido"=>$pedido,"detallepedido"=>$detallepedido,"total"=>$total,"n"=>$n,"igv2"=>$igv2,"st"=>$st,"numnv"=>$numnv,"numb"=>$numb,"numf"=>$numf]);
    }

    //creamos la funcion store (almacenar), almacena o guarda el elemento nuevo.
    //va recibir un parametro de validacion, ¿que usabamos para validar? pues habiamos creado un ProductoFormRequest
    //que nos valida los datos ingresados desde los formulario html.
    public function store(VentaFormRequest $request)
    {
        $venta = new Venta;
        $venta->idpedido = $request->get('idpedido');
        $venta->idcliente = $request->get('idcliente');
        $venta->tipo_comprobante = $request->get('tipo_comprobante');
        $venta->serie_comprobante = $request->get('serie_comprobante');
        $venta->num_comprobante = $request->get('num_comprobante');
        $venta->monto_total = $request->get('monto_total');
        $mytime = Carbon::now('America/Lima');
        $venta->fecha = $mytime->toDateTimeString();
        $venta->estado = '1';
        $venta->save();

        $pedido = Pedido::findOrFail($venta->idpedido);
        $pedido->estado = '1';
        $pedido->update();

        $mesa = DB::table('mesa as m')
        ->join('pedido as p','m.idmesa','=','p.idmesa')
        ->select('m.idmesa')
        ->where('p.idpedido','=',$venta->idpedido)
        ->first();

        $me = Mesa::findOrFail($mesa->idmesa);
        $me->estado = '1';
        $me->update();         

        return Redirect::to('ventas/venta');     //redireccionamos a almacen/categoria donde va estar nuestro index(pagina principal) para categoria.
    }
    
    //creamos la funcion show (mostrar), muestra los datos de la tabla
    //recibe un parametro id para mostrar solo la categoria que se le pida mediante el id
    public function show($id)
    {
        $venta = DB::table('venta as v')
        ->join('pedido as p','v.idpedido','=','p.idpedido')
        ->join('persona as pe','v.idcliente','=','pe.idpersona')
        ->join('mesa as m','p.idmesa','=','m.idmesa')
        ->join('colaborador as c','p.idmozo','=','c.idcolaborador')
        ->where('p.idpedido','=',$id)
        ->first();

        $detallepedido = DB::table('detallepedido as dp')
        ->join('producto as pro','dp.idproducto','=','pro.idproducto')
        ->select('pro.nombre','dp.cantidad','pro.precio','dp.precio_venta')
        ->where('dp.idpedido','=',$id)
        ->get();

        $total = DB::table('pedido as p')
        ->join('detallepedido as dp','p.idpedido','=','dp.idpedido')
        ->join('producto as pro','dp.idproducto','=','pro.idproducto')
        ->select('p.idpedido',DB::Raw('SUM(dp.cantidad*dp.precio_venta) as monto_total'))
        ->where('p.idpedido','=',$id)
        ->groupBy('p.idpedido')
        ->first();
        
        $n = 1;
        $igv = 0.18;
        $st = $total->monto_total/(1+$igv);
        $igv2 = $total->monto_total-$st;


        return view("ventas.venta.show",["venta"=>$venta,"detallepedido"=>$detallepedido,"n"=>$n,"igv2"=>$igv2,"st"=>$st,"total"=>$total]);//llama a la vista show y le envia la categoria id
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

}
