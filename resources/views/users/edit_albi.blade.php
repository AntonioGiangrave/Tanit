<br>
<div class="form-group filterlist">
    {{ Form::select('_albi_professionali[]',$lista_albi, $datiRecuperati->_albi_professionali->lists('id')->toArray(),  ['class' => 'form-control, list-group', 'multiple']) }}
</div>