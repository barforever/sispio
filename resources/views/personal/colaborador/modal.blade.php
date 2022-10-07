<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$colaborador->idcolaborador}}">
    {{Form::open(array('action'=>array('ColaboradorController@destroy',$colaborador->idcolaborador),'method'=>'delete'))}}
    <div class="modal-dialog">
        @if ($colaborador->estado == '1')
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> <dact>Retirar</dact> Colaborador</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Confirme si desea Retirar el colaborador: </br><STRong>{{$colaborador->nickname}}</STRong></p>            
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="far fa-window-close fa-fw"></i> Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="far fa-check-square fa-fw"></i> Confirmar</button>
                </div>
            </div>
        @else
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> <act>Contratar</act> Colaborador</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Confirme si desea Contratar el colaborador: </br><STRong>{{$colaborador->nickname}}</STRong></p>            
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