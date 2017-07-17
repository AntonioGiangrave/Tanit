@extends('cache.index')

@section('page_heading','Crea sessione')
@section('body')

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">


        {{ Form::open(['url' =>'aule_sessioni/'])}}


        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    {{ Form::label('descrizione', 'Descrizione:') }}
                    {{ Form::text('descrizione', null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    {{ Form::label('id_aula', 'Aula o Fad   :') }}
                    {{ Form::select('id_aula', $aule , null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    {{ Form::label('id_corso', 'Corso:') }}
                    {{ Form::select('id_corso', $corsi , null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>




        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('dal', 'Attivo dal:') }}
                    {{ Form::text('dal',  null, ['class' => 'form-control giorno']) }}
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('al', 'Fino  al:') }}
                    {{ Form::text('al',  null , ['class' => 'form-control giorno']) }}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('orario_dalle', 'Dalle ore:') }}
                    {{ Form::text('orario_dalle',  null , ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    {{ Form::label('orario_alle', 'Alle ore:') }}
                    {{ Form::text('orario_alle',   null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>



        <div class="pull-right">

            <div class="pull-right" id="q">
                {{ Form::submit('inserisci', ['class' => 'btn btn-success']) }}

                {{ Form::close() }}


            </div>


        </div>
    </div>



@stop

@section('script')


    <script type="text/javascript">

        $( document ).ready(function()
        {



            $( ".giorno" ).datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true
            });
        });

    </script>

@endsection