<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//con esto habilitamos el Requests en nuestra carpeta donde esta guardada nuestro sistema
use sisvenpopi\Http\Requests;
//con esto agregamos el modelo que vamos a utilizar en este controlador
//es decir le asignamos a que modelo va a controlar nuestro controlador
use App\Pedido;
use App\DetallePedido;
use App\Mesa;
//llamamos a Redirect para hacer redicciones
use Illuminate\Support\Facades\Redirect;
//llamamos a Input para poder subir la imagen del cliente hacia nuestro servidor
use Illuminate\Support\Facades\Input;
//llamamos al request creado para Producto
use App\Http\Requests\PedidoFormRequest;
//llamamos a la clase DB de Laravel
use DB;

use Carbon\Carbon; //obtiene la fecha segun la zona horaria
use Response;
use Iluminate\Support\Collection;

class PedidoController extends Controller
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
            $pedidos = DB::table('pedido as p')
            ->join('mesa as m','p.idmesa','=','m.idmesa')
            ->join('colaborador as c','p.idmozo','=','c.idcolaborador')
            ->join('detallepedido as dp','p.idpedido','=','dp.idpedido')
            ->join('producto as pro','dp.idproducto','=','pro.idproducto')
            ->select('p.idpedido','p.fecha','p.num_comanda','m.num_mesa','c.nickname','p.estado',DB::raw('SUM(pro.precio*dp.cantidad) as monto'))
            ->where('m.num_mesa','LIKE','%'.$query.'%')
            ->where('p.estado','!=','2')
            ->whereDate('p.fecha',$h)
            ->groupBy('p.idpedido','p.fecha','p.num_comanda','m.num_mesa','c.nickname','p.estado')
            ->orderBy('p.estado','desc')
            ->orderBy('p.fecha','desc')
            ->paginate(100);
            
            $m = DB::table('pedido')
            ->select(DB::raw('COUNT(idpedido) as n'))
            ->whereDate('fecha',$h)
            ->first();

            $n = $m->n;
            
            $mesas = DB::table('mesa')
            ->where('estado','=','1')
            ->orwhere('estado','=','2')
            ->get();

            return view('ventas.pedido.index',["pedidos"=>$pedidos,"searchText"=>$query,"hoy"=>$hoy,"n"=>$n,"mesas"=>$mesas]);
        }        
    }
    
    //creamos la funcion create (crear), crea un nuevo elemento para ser almacenado, solo crea no guarda.
    public function create($id)
    {
        $mozos = DB::table('colaborador as c')
        ->join('cargo as ca','c.idcargo','=','ca.idcargo')
        ->select('c.idcolaborador','c.nickname')
        ->where('ca.nombre','=','mozo')
        ->get();

        $mesa = DB::table('mesa')
        ->where('idmesa','=',$id)
        ->first();

        $categorias = DB::table('categoria')
        ->where('estado','=','1')
        ->get();

        $productos = DB::table('producto')
        ->where('estado','=','1')
        ->get();

        $igv = 0.18;

        return view("ventas.pedido.create",["mozos"=>$mozos,"mesa"=>$mesa,"categorias"=>$categorias,"productos"=>$productos,"igv"=>$igv]);
    }

    //creamos la funcion store (almacenar), almacena o guarda el elemento nuevo.
    //va recibir un parametro de validacion, ¿que usabamos para validar? pues habiamos creado un ProductoFormRequest
    //que nos valida los datos ingresados desde los formulario html.
    public function store(PedidoFormRequest $request)
    {
        try{
            DB::beginTransaction();
            $pedido = new Pedido;
            $pedido->idmozo = $request->get('idmozo'); //
            $pedido->idmesa = $request->get('idmesa');
            $pedido->num_comanda = $request->get('num_comanda');

            $mytime = Carbon::now('America/Lima');
            $pedido->fecha = $mytime->toDateTimeString();
            $pedido->estado = '2';
            $pedido->save(); 

            $idproducto = $request->get('idproducto');
            $cantidad = $request->get('cantidad');
            $precio_venta = $request->get('precio_venta');

            $cont = 0;

            while($cont < count($idproducto)){
                $detalle = new DetallePedido();
                $detalle->idpedido = $pedido->idpedido;
                $detalle->idproducto = $idproducto[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precio_venta = $precio_venta[$cont];
                $detalle->save();
                $cont=$cont+1;
            }

            $me = Mesa::findOrFail($pedido->idmesa);
            $me->estado = '2';
            $me->update();

            DB::commit();
        }catch(\Exception $e)
        {
            DB::rollback();
        }
        
        return Redirect::to('ventas/pedido');     //redireccionamos a almacen/categoria donde va estar nuestro index(pagina principal) para categoria.
    }
    
    //creamos la funcion show (mostrar), muestra los datos de la tabla
    //recibe un parametro id para mostrar solo la categoria que se le pida mediante el id
    public function show($id)
    {
        $pedido = DB::table('pedido as p')
        ->join('colaborador as c','p.idmozo','=','c.idcolaborador')
        ->join('mesa as m','p.idmesa','=','m.idmesa')
        ->where('p.estado','=','2')
        ->where('m.idmesa','=',$id)
        ->first();

        $detallepedido = DB::table('detallepedido as dp')
        ->join('pedido as p','dp.idpedido','=','p.idpedido')
        ->join('producto as pro','dp.idproducto','=','pro.idproducto')
        ->select('pro.nombre','dp.cantidad','pro.precio','dp.precio_venta')
        ->where('p.estado','=','2')
        ->where('p.idmesa','=',$id)
        ->get();

        $total = DB::table('detallepedido as dp')
        ->join('pedido as p','dp.idpedido','=','p.idpedido')
        ->select('p.idpedido',DB::Raw('SUM(dp.cantidad*dp.precio_venta) as monto_total'))
        ->where('p.estado','=','2')
        ->where('p.idmesa','=',$id)
        ->groupBy('p.idpedido')
        ->first();

        $n = 1;
        $igv = 0.18;
        $st = $total->monto_total/(1+$igv);
        $igv2 = $total->monto_total-$st;

        return view("ventas.pedido.show",["pedido"=>$pedido,"detallepedido"=>$detallepedido,"n"=>$n,"igv2"=>$igv2,"st"=>$st,"total"=>$total]);//llama a la vista show y le envia la categoria id
    }
    
    public function show2($id)
    {
        $pedido = DB::table('pedido as p')
        ->join('colaborador as c','p.idmozo','=','c.idcolaborador')
        ->join('mesa as m','p.idmesa','=','m.idmesa')
        ->where('p.idpedido','=',$id)
        ->first();

        $detallepedido = DB::table('detallepedido as dp')
        ->join('pedido as p','dp.idpedido','=','p.idpedido')
        ->join('producto as pro','dp.idproducto','=','pro.idproducto')
        ->select('pro.nombre','dp.cantidad','pro.precio','dp.precio_venta')
        ->where('p.idpedido','=',$id)
        ->get();

        $total = DB::table('detallepedido as dp')
        ->join('pedido as p','dp.idpedido','=','p.idpedido')
        ->select('p.idpedido',DB::Raw('SUM(dp.cantidad*dp.precio_venta) as monto_total'))
        ->where('p.idpedido','=',$id)
        ->groupBy('p.idpedido')
        ->first();

        $n = 1;
        $igv = 0.18;
        $st = $total->monto_total/(1+$igv);
        $igv2 = $total->monto_total-$st;

        return view("ventas.pedido.show2",["pedido"=>$pedido,"detallepedido"=>$detallepedido,"n"=>$n,"igv2"=>$igv2,"st"=>$st,"total"=>$total]);//llama a la vista show y le envia la categoria id
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
