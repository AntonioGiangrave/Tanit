<br>
<div class="form-group filterlist">
    <div class="row">
        <div class="col-sm-4">
            {{ Form::text('txtSearch',null,  [ 'id'=> 'txtSearch', 'class' => 'form-control', 'placeholder' => 'Filtra']) }}
        </div>
        <div class="col-sm-1"></div>
        <div class="col-sm-3">
            <a class="btn btn-tanit btn-xs resetfilter"   href="#">visualizza tutti</a>
        </div>
        <div class="col-sm-3">
            <a class="btn btn-tanit btn-xs soloselezionati"   href="#">visualizza selezionati</a>
        </div>

    </div>
    <hr>

    {{--ho disattivato la possibilità di scegliere mansioni multiple, questa era la riga originaria--}}
    {{--{{ Form::select('_mansioni[]',$lista_mansioni, $datiRecuperati->_mansioni->lists('id')->toArray(),  ['class' => 'form-control, list-group', 'multiple']) }}--}}

    {{ Form::select('_mansioni[]',$lista_mansioni, $datiRecuperati->_mansioni->lists('id')->toArray(),  ['class' => 'form-control, list-group']) }}

</div>