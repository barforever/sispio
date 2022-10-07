<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    //asigna la tabla que va usar este modelo
    protected $table = 'persona';
    //va a tener en cuenta siempre que idcategoria es primaryKey y la va usar siempre para trabajar con el dato especifico
    //ademas permite que el campo id no sea publica y sera posible enviar un valor para que sea almacenada,
    //ya el campo fue creada con un autoincrement.
    protected $primaryKey = "idpersona";
    //en Laravel al usar tablas y/o procesarlas crea dos columnas una de fecha de creacion y otra de actualizacion
    //con esta linea le decimos que no nos cree estas dos columnas en la tabla Categoria.
    public $timestamps = false;
    
    //asignamos los campos que van a recibir un valor para que sean almacenados en la base de datos.
    //no incluimos al id de la tabla ya que esta se almacena con el autoincrement.
    protected $fillable = ['tipo_persona','nombre','tipo_documento','num_documento','direccion','telefono','f_nacimiento','email','estado'];
}
