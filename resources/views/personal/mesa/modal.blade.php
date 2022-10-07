<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$mesa->idmesa}}">
    {{Form::open(array('action'=>array('MesaController@destroy',$mesa->idmesa),'method'=>'delete'))}}
    <div class="modal-dialog">
        @if ($mesa->estado == '1')
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> <dact>Desactivar</dact> Mesa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Confirme si desea Desactivar la mesa: <STRong>{{$mesa->num_mesa}}</STRong></p>            
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="far fa-window-close fa-fw"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="far fa-check-square fa-fw"></i> Confirmar</button>
                </div>
            </div>
        @else
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> <act>Activar</act> Mesa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Confirme si desea Activar la mesa: <STRong>{{$mesa->num_mesa}}</STRong></p>            
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="far fa-window-close fa-fw"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="far fa-check-square fa-fw"></i> Confirmar</button>
                </div>
            </div>
        @endif      
    </div>
    {{Form::Close()}}    
</div>