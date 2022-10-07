<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
     //asigna la tabla que va usar este modelo
     protected $table = 'ingreso';
     //va a tener en cuenta siempre que idcategoria es primaryKey y la va usar siempre para trabajar con el dato especifico
     //ademas permite que el campo id no sea publica y sera posible enviar un valor para que sea almacenada,
     //ya el campo fue creada con un autoincrement.
     protected $primaryKey = 'idingreso';
     //en Laravel al usar tablas y/o procesarlas crea dos columnas una de fecha de creacion y otra de actualizacion
     //con esta linea le decimos que no nos cree estas dos columnas en la tabla Categoria.
     public $timestamps = false;
     
     //asignamos los campos que van a recibir un valor para que sean almacenados en la base de datos.
     //no incluimos al id de la tabla ya que esta se almacena con el autoincrement.
     protected $fillable = ['idproveedor','tipo_comprobante','serie_comprobante','num_comprobante','fecha','monto_total','estado'];
}
