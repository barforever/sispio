<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$car->idcargo}}">
    {{Form::open(array('action'=>array('CargoController@destroy',$car->idcargo),'method'=>'delete'))}}
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> <dact>Eliminar</dact> Cargo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Confirme si desea Eliminar el cargo <STRong>{{$car->nombre}}</STRong></p>            
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="far fa-window-close fa-fw"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="far fa-check-square fa-fw"></i> Confirmar</button>
                </div>
            </div>        
    </div>
    {{Form::Close()}}    
</div>