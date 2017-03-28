<br>
<div class="form-group filterlist">
    {{ Form::select('_incarichi_sicurezza[]',$lista_incarichi_sicurezza, $datiRecuperati->_incarichi_sicurezza->lists('id')->toArray(),  ['class' => 'form-control, list-group', 'multiple']) }}
</div>