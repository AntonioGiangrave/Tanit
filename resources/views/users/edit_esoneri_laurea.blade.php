<br>
<div class="row">
    <div class="col-md-8">

        <div class="form-group">
            {{ Form::label('rif_laurea', 'Riferimento laurea:') }}
            {{ Form::select('rif_laurea', array(
            1 =>'Laurea Magistrale (D.M. dell’Università e della Ricerca del 16 marzo 2007)',
            2 =>'Laurea Magistrale (D.M. dell’Università e della ricerca in data 8 gennaio 2009)',
            3 =>'Laurea Specialistica (D.M. dell’Università e della ricerca scientifica e tecnologica del 28 novembre 2000)',
            4 =>'Laurea (D.M. dell’Università e della ricerca del 19 febbraio 2009)',
            5 =>'Laurea (D.M. dell’Università e della Ricerca scientifica e tecnologica del 18 marzo 2006)',
            6 =>'Laurea (D.M. dell’Università e della ricerca scientifica e tecnologica del 4 agosto 2000)'
            ), $datiRecuperati->_esoneri_laurea->lists('id_riferimento')->toArray() , ['placeholder' => 'Seleziona ...', 'class' => 'form-control', 'id' => 'rif_laurea' , 'name' => 'rif_laurea']) }}
        </div>


    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            {{ Form::label('_esoneri_laurea', 'Classe di laurea:') }}
            {{ Form::select('_esoneri_laurea', $esoneri_laurea, $datiRecuperati->_esoneri_laurea->lists('id')->toArray() , ['placeholder' => 'Seleziona ...', 'class' => 'form-control' , 'id' =>'_esoneri_laurea' , 'name' =>'_esoneri_laurea']) }}
        </div>
    </div>
</div>

@section('script')
    @parent
    <script type="text/javascript">
        $('#rif_laurea').on('change', function(e){
            var id = $('#rif_laurea').val();
            $.get("/get_esoneri_laurea/"+id, {}, function (data) {
                var select = $('#_esoneri_laurea');
                select.html('');
                select.find('option').remove();
                $.each(data,function(key, value)
                {
                    select.append('<option value=' + key + '>' + value + '</option>');
                });
            },'json');
        });
    </script>
@stop