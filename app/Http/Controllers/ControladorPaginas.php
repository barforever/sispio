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

use Carbon\Carbon; //obtiene la fecha segun la zona horaria
use Response;
use Iluminate\Support\Collection;

class ControladorPaginas extends Controller
{
    Public function inicio(){
        return view('welcome');
    }

    Public function ventas($nomCat = null){
        $categorias = ['Pollos','Carta','Bebidas'];

        return view('ventas',compact('categorias','nomCat'));
    }

    Public function productos(){
        return view('productos');
    }

    Public function mozos($nomMozo = null){
        $mozos = ['Brayan','Raul','Lucho'];

        //return view('mozos',['mozo'=>$mozos,'nombre'=>$nombre]);
        return view('mozos',compact('mozos', 'nomMozo'));
    }

    Public function reportes(){
        return view('reportes');
    }

    public function ventaproductos($h)
    {
            
            $hoy = Carbon::now('America/Lima')->format('d-m-Y');

            $fecha = DB::table('venta')
            ->select(DB::raw('DATE(fecha) as fecha'))
            ->where('estado','=','1')
            ->whereDate('fecha',$h)
            ->first();
            
            $suma = DB::table('venta')
            ->select(DB::raw('SUM(monto_total) as monto_total'))
            ->where('estado','=','1')
            ->whereDate('fecha',$h)
            ->get();

            $cantpollo = DB::table('detalleventa as dv')
            ->join('producto as p','dv.idproducto','=','p.idproducto')
            ->join('venta as v','dv.idventa','=','v.idventa')
            ->select(DB::raw('SUM(dv.cantidad*p.cantpollo) as pollo'))
            ->where('v.estado','=','1')
            ->whereDate('v.fecha',$h)
            ->get();

            $cantplatos = DB::table('detalleventa as dv')
            ->join('venta as v','dv.idventa','=','v.idventa')
            ->select(DB::raw('SUM(dv.cantidad) as platos'))
            ->where('v.estado','=','1')
            ->whereDate('v.fecha',$h)
            ->get();

            $ventas = DB::table('detalleventa as dv')
            ->join('venta as v','dv.idventa','=','v.idventa')
            ->join('producto as p','dv.idproducto','=','p.idproducto')
            ->select('p.nombre','dv.precio_venta',DB::raw('SUM(dv.cantidad) as cant'),DB::raw('SUM(dv.cantidad * p.cantpollo) as cpollo'),DB::raw('SUM(dv.precio_venta * dv.cantidad) as total'))
            ->where('v.estado','=','1')
            ->whereDate('v.fecha',$h)
            ->groupBy('p.nombre','dv.precio_venta')
            ->orderBy('cant','desc')
            ->orderBy('total','desc')
            ->paginate();           
            
            return view('reportes.diario.wow',["ventas"=>$ventas,"hoy"=>$hoy,"suma"=>$suma,"fecha"=>$fecha,"cantpollo"=>$cantpollo,"cantplatos"=>$cantplatos]);//llama a la vista show y le envia la categoria id
    }

    public function detallegastos($h)
    {
            
            $hoy = Carbon::now('America/Lima')->format('d-m-Y');

            $fecha = DB::table('venta')
            ->select(DB::raw('DATE(fecha) as fecha'))
            ->where('estado','=','1')
            ->whereDate('fecha',$h)
            ->first();
            
            $costo = DB::table('gasto')
            ->select(DB::raw('SUM(costo) as costo'))
            ->where('estado','=','1')
            ->whereDate('fecha',$h)
            ->get();

            $gastos = DB::table('gasto')
            ->select('idgasto','fecha','nombre','cantidad','costo','detalle','estado')
            ->whereDate('fecha',$h)
            ->orderBy('idgasto','desc')
            ->paginate(10);    
            
            return view('reportes.diario.gasto',["hoy"=>$hoy,"fecha"=>$fecha,"costo"=>$costo,"gastos"=>$gastos]);//llama a la vista show y le envia la categoria id
    }
}
