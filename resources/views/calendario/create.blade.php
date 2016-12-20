@extends('layouts.dashboard')
@section('page_heading','Inserisci commessa')


@section('section')


    <div class="col-xs-12 col-md-6">


        {{ Form::open(['route' => 'calendario.store']) }}

        <div class="form-group">
            {{ Form::hidden('dipendenti_id', Auth::user()->id, ['class' => 'form-control', 'id' => 'dipendenti_id'  ]) }}
            {{ Form::hidden('dalle_ore', 0 ,['class' => 'form-control' ]) }}
        </div>


        <div class="form-group">
            {{ Form::label('commessa_id_text', 'Commessa:') }}
            {{ Form::text('commessa_id_text', null, ['class' => 'form-control', 'placeholder' => 'Inizia a scrivere 3 lettere e scegliene solo dall\'elenco']) }}
            {{ Form::hidden('commessa_id', null, ['id'=>'commessa_id' ,  'class' => 'form-control'  ]) }}

        </div>
        <div class="form-inline">
            <div class="form-group">
                {{ Form::label('n_ore', 'Numero ore:') }}
                {{ Form::select('n_ore',
                array(
                "0.5" => "0,5",
                "1" => "1",
                "1.5" => "1,5",
                "2" => "2",
                "2.5" => "2,5",
                "3" => "3",
                "3.5" => "3,5",
                "4" => "4",
                "4.5" => "4,5",
                "5" => "5",
                "5.5" => "5,5",
                "6" => "6",
                "6.5" => "6,5",
                "7" => "7",
                "7.5" => "7,5",
                "8" => "8"
                )
                ,null, ['class' => 'form-control autoWidth']) }}




                {{ Form::label('giorno', 'Giorno:') }}
                {{ Form::text('giorno', null, ['class' => 'form-control autoWidth']) }}

            </div>
        </div>
        <div class="form-inline">
            <div class="form-group">

                {{ Form::text('type_text', 'Commessa normale', ['class' => 'form-control ', 'id'=>'type_text', "disabled"]) }}
                {{ Form::hidden('type', 0, ['class' => 'form-control' , 'id'=>'type'  ]) }}

                {{ Form::label('cambia tipo:') }}

                {{Form::button('Regolare' ,[
                         'type' => 0,
                         'type_text' => 'Commessa normale',
                          'class' => "btn btn-default type "
                         ])}}

                {{Form::button('Recupero    +' ,[
                         'type' => 4,
                         'type_text' => 'Recupero+ ',
                          'class' => "btn btn-warning  type"
                         ])}}

                {{Form::button('Straordinario' ,[
                         'type' => 3,
                         'type_text' => 'Straordinario ',
                          'class' => "btn btn-danger type "
                         ])}}




            </div>
        </div>





        <div class="pull-right">
            {{ Form::submit('Invia', ['class' => 'btn btn-success']) }}
            {{ Form::close() }}
        </div>

    </div>

    <div class="hidden-xs col-md-4 col-md-offset-2">

        {{ Form::label('Ultime commesse usate') }}
        <div class="list-group">
            @foreach($mostUsed as $single)
                <a href="#"
                   commessa_id="{{ $single->commessa->id; }}"
                   commessa_text="{{ $single->commessa->oggetto; }}"
                   class="
                   list-group-item
                   mostUsed
                    @if($single->commessa->id>=1000)
                           list-group-item-warning
                           @endif
                           ">
                    {{ $single->commessa->oggetto; }}
                </a>
            @endforeach
        </div>
    </div>
@stop




@section('script')


    <script type="text/javascript">

        $( document ).ready(function()
        {

            $("#commessa_id_text").autocomplete({
                source: APP_URL+"/autocomplete/commesse",
                minLength: 3,
                select: function (event, ui) {
                    $('#commessa_id_text').val(ui.item.value);
                    $('#commessa_id').val(ui.item.id);
                }
            });

            $(".mostUsed").click(function() {
                $('#commessa_id_text').val($(this).attr("commessa_text"));
                $('#commessa_id').val($(this).attr("commessa_id"));

            });

            $(".type").click(function(e) {
                e.preventDefault();
                $('#type_text').val($(this).attr("type_text"));
                $('#type').val($(this).attr("type"));
            });

            $( "#giorno" ).datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true
            });
        });

    </script>

@endsection
