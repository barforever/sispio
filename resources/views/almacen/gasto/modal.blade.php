<style>
    t { color: red; }
    t2 { color: #007BFF;} 
</style>
<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$g->idgasto}}">
    {{Form::open(array('action'=>array('GastoController@destroy',$g->idgasto),'method'=>'delete'))}}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-left">
                <h4 class="modal-title">Anular Gasto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>                
            </div>
            <div class="modal-body">
                <p>Confirme si desea <t>Anular</t> el gasto :  <t2>{{$g->nombre}}</t2></p>            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Confirmar</button>
            </div>
        </div>
    </div>
    {{Form::Close()}}    
</div>