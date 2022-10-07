<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//con esto habilitamos el Requests en nuestra carpeta donde esta guardada nuestro sistema
use sisvenpopi\Http\Requests;
//con esto agregamos el modelo que vamos a utilizar en este controlador
//es decir le asignamos a que modelo va a controlar nuestro controlador
use App\Producto;
use App\InsumoProducto;
//llamamos a Redirect para hacer redicciones
use Illuminate\Support\Facades\Redirect;
//llamamos a Input para poder subir la imagen del cliente hacia nuestro servidor
use Illuminate\Support\Facades\Input;
//llamamos al request creado para Producto
use App\Http\Requests\ProductoFormRequest;
//llamamos a la clase DB de Laravel
use DB;

use Carbon\Carbon; //obtiene la fecha segun la zona horaria
use Response;
use Iluminate\Support\Collection;

class ProductoController extends Controller
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
            $productos = DB::table('producto as p')
            ->join('categoria as c','p.idcategoria','=','c.idcategoria')
            ->select('p.idproducto','p.nombre','p.precio','c.nombre as categoria','p.imagen','p.estado')
            ->where('p.nombre','LIKE','%'.$query.'%')
            ->orwhere('c.nombre','LIKE','%'.$query.'%')
            ->orderBy('categoria','desc')
            ->orderBy('p.nombre','asc')
            ->paginate(20);

            return view('almacen.producto.index',["productos"=>$productos,"searchText"=>$query]);
        }        
    }
    
    //creamos la funcion create (crear), crea un nuevo elemento para ser almacenado, solo crea no guarda.
    public function create()
    {
        //hacer la consulta de las categorias para ponerlas en un combobox y poder seleccionarlas al momento de escoger su categoria
        $categorias = DB::table('categoria')->where('estado','=','1')->get();

        $insumos = DB::table('insumo')
        ->select('idinsumo','nombre','cantidad','unidad_medida')
        ->get();

        return view("almacen.producto.create",["categorias"=>$categorias,"insumos"=>$insumos]);
    }

    //creamos la funcion store (almacenar), almacena o guarda el elemento nuevo.
    //va recibir un parametro de validacion, ¿que usabamos para validar? pues habiamos creado un ProductoFormRequest
    //que nos valida los datos ingresados desde los formulario html.
    public function store(ProductoFormRequest $request)
    {        
        try{
            DB::beginTransaction();
            $producto = new Producto;
            $producto->idcategoria = $request->get('idcategoria'); //
            $producto->nombre = $request->get('nombre');
            $producto->precio = $request->get('precio');

            if (Input::hasFile('imagen')){
                $file = Input::file('imagen');
                $file->move(public_path().'/imagenes/productos/',$file->getClientOriginalName());
                $producto->imagen = $file->getClientOriginalName();
            }

            $producto->estado = '1';
            $producto->save(); 

            $idinsumo = $request->get('idinsumo');
            $cantidad_utilizada = $request->get('cantidad_utilizada');

            $cont = 0;
            if (!empty($idinsumo)) {
                while($cont < count($idinsumo)){
                    $detalle = new InsumoProducto();
                    $detalle->idproducto = $producto->idproducto;
                    $detalle->idinsumo = $idinsumo[$cont];
                    $detalle->cantidad_utilizada = $cantidad_utilizada[$cont];
                    $detalle->save();
                    $cont=$cont+1;
                }
            } 

            DB::commit();
        }catch(\Exception $e)
        {
            DB::rollback();
        }
                
        return Redirect::to('almacen/producto');     //redireccionamos a almacen/categoria donde va estar nuestro index(pagina principal) para categoria.
    }
    
    //creamos la funcion show (mostrar), muestra los datos de la tabla
    //recibe un parametro id para mostrar solo la categoria que se le pida mediante el id
    public function show($id)
    {
        $producto = DB::table('producto as p')
        ->join('categoria as c','p.idcategoria','=','c.idcategoria')
        ->select('p.idproducto','p.nombre','c.nombre as categoria','p.precio','p.imagen','p.estado')
        ->where('p.idproducto','=',$id)
        ->first();

        $insumosproducto = DB::table('insumo_producto as ip')
        ->join('insumo as i','ip.idinsumo','=','i.idinsumo')
        ->select('ip.idproducto','i.nombre','ip.cantidad_utilizada','i.unidad_medida')
        ->where('ip.idproducto','=',$id)
        ->get();

        $n = 1;
        
        return view("almacen.producto.show",["producto"=>$producto,"insumosproducto"=>$insumosproducto,"n"=>$n]);//llama a la vista show y le envia la categoria id
    }
    
    //creamos la funcion edit (editar), edita los datos de la tabla pero no las guarda
    //recibe un parametro id, lo cual despues creare un formulario para que se muestre la categoria correspondiente al id
    //la funcion solo nos mostrara la categoria, lo cual podra ser editada  pero se guardara con la funcion update.
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);        
        
        $categorias = DB::table('categoria')->where('estado','=','1')->get();

        $insumos = DB::table('insumo')->get();

        $insumoproducto = DB::table('insumo_producto as ip')
        ->join('insumo as i','ip.idinsumo','=','i.idinsumo')
        ->select('ip.idproducto','ip.idinsumo','i.nombre','ip.cantidad_utilizada','i.unidad_medida')
        ->where('ip.idproducto','=',$id)
        ->get();

        $cont = 0;
        $cont2 = 0;

        return view("almacen.producto.edit",["producto"=>$producto,"categorias"=>$categorias,"insumos"=>$insumos,"insumoproducto"=>$insumoproducto,"cont"=>$cont,"cont2"=>$cont2]);
    }
    
    //creamos la funcion update (actualizar), actualiza los datos de la tabla y guarda.
    //recibe dos parametros, el primero $request recibira los datos enviados por la funcion edit para ser validados.
    // el segundo parametro $id recibira el id de la categoria que quiero modificar.
    public function update(ProductoFormRequest $request,$id)
    {
        $insumoproducto = DB::table('insumo_producto')
        ->where('idproducto','=',$id)
        ->delete();

        try{
            DB::beginTransaction();
            $producto = Producto::findOrFail($id);
            $producto->idcategoria = $request->get('idcategoria'); //
            $producto->nombre = $request->get('nombre');
            $producto->precio = $request->get('precio');

            if (Input::hasFile('imagen')){
                $file = Input::file('imagen');
                $file->move(public_path().'/imagenes/productos/',$file->getClientOriginalName());
                $producto->imagen = $file->getClientOriginalName();
            }

            $producto->update(); 

            $idinsumo = $request->get('idinsumo');
            $cantidad_utilizada = $request->get('cantidad_utilizada');

            $cont = 0;
            if (!empty($idinsumo)) {
                while($cont < count($idinsumo)){
                    $detalle = new InsumoProducto();
                    $detalle->idproducto = $producto->idproducto;
                    $detalle->idinsumo = $idinsumo[$cont];
                    $detalle->cantidad_utilizada = $cantidad_utilizada[$cont];
                    $detalle->save();
                    $cont=$cont+1;
                }
            } 

            DB::commit();
        }catch(\Exception $e)
        {
            DB::rollback();
        }

        return Redirect::to('almacen/producto');     //redireccionamos a almacen/categoria donde va estar nuestro index(pagina principal) para categoria
    }
    
    //Creamos la funcion destroy (borrar), borra o destruye datos de la tabla
    //Recibe un parametro $id para saber que categoria sera borrada. en nuestro caso no eliminamos la categoria
    // simplemente le cambiamos el estado, ya que si el estado es 1 se muestra y si es 0 ya no se muestra en el index.
    //Esto de mostrar si es 1 y ocultar si es 0 lo habiamos echo en la funcion index ->where('condicion','=','1')
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        if ($producto->estado == '1') {
            $producto->estado = '0';
            $producto->update();
        } 
        else {
            $producto->estado = '1';
            $producto->update();
        }

        return Redirect::to('almacen/producto');
    }
}
