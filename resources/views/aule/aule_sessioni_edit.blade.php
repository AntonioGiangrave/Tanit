@extends('cache.index')

@section('page_heading','Sessione del corso ' .$datiRecuperati->_corso->titolo  )
@section('body')


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">


            {{Form::model($datiRecuperati, ['method' => 'put', 'url' =>'aule_sessioni/'. $datiRecuperati['id']]) }}

            {{ Form::hidden('token', csrf_token(), ['type'=>'hidden']) }}




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
                        {{ Form::label('id_aula', 'Aula:') }}
                        {{ Form::select('id_aula', $aule , $datiRecuperati['id_aula'], ['class' => 'form-control']) }}
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        {{ Form::label('id_corso', 'Corso:') }}
                        {{ Form::select('id_corso', $corsi , $datiRecuperati['id_corso'], ['class' => 'form-control']) }}
                    </div>
                </div>
            </div>




            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        {{ Form::label('dal', 'Attivo dal:') }}
                        {{ Form::text('dal',  $datiRecuperati['dal'], ['class' => 'form-control giorno']) }}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        {{ Form::label('al', 'Fino  al:') }}
                        {{ Form::text('al',  $datiRecuperati['al'], ['class' => 'form-control giorno']) }}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        {{ Form::label('orario_dalle', 'Dalle ore:') }}
                        {{ Form::text('orario_dalle',  $datiRecuperati['orario_dalle'], ['class' => 'form-control']) }}
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        {{ Form::label('orario_alle', 'Alle ore:') }}
                        {{ Form::text('orario_alle',  $datiRecuperati['orario_alle'], ['class' => 'form-control']) }}
                    </div>
                </div>
            </div>


            <div class="pull-right">
                {{ Form::submit('Salva', ['class' => 'btn btn btn-tanit btn-xs']) }}
                {{ Form::close() }}
            </div>

            <div class="pull-right">

                <a target="_blank" class="button btn btn-tanit btn-xs" href="{{'/aule_sessioni_pdf/'. $datiRecuperati['id'].''}}">Scarica riepilogo</a>

                @if($datiRecuperati->scheda_corso())
                    <a target="_blank" class="button btn btn-tanit btn-xs" href="{{'/uploads/'. $datiRecuperati['id'].'/SCHEDA_CORSO.pdf'}}">Scarica scheda corso</a>
                @endif
            </div>


        </div>
    </div>



    <hr>
    <h4>Upload scheda corso/slides</h4>
    {{ Form::open(array('class' => 'form-inline' ,  'url'=>'/aule_sessioni_uploadpdf/','method'=>'POST', 'files'=>true)) }}

    <div class="form-group">
        <label for="exampleInputFile"> </label>
        {{ Form::file('pdf[]', array('multiple'=>true)) }}
        <p class="help-block">Selezionare file PDF max 2MB</p>
    </div>

    {{ Form::hidden('id', $datiRecuperati['id'], ['class' => 'form-control']) }}
    {{ Form::hidden('name', $datiRecuperati->_corso->titolo, ['class' => 'form-control']) }}


    {{ Form::submit('Carica file' , ['class' => 'btn btn btn-tanit btn-xs']) }}
    {{ Form::close() }}
    <hr>



    <div class="row">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion"
                           href="#collapse1">
                            Utenti iscritti <i class="fa fa-arrow-circle-down"></i>
                        </a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse in ">
                    <div class="panel-body">
                        <table class="table table-striped">
                            @foreach($datiRecuperati->_posti_occupati() as $rf)
                                <tr>
                                    <td>{{ $rf->_user->cognome }} </td>
                                    <td>{{ $rf->_user->nome}} </td>
                                    <td>{{ $rf->_user->societa->ragione_sociale}} </td>
                                    <td>{{ $rf->_user->societa->ateco->descrizione}} </td>
                                    <td>
                                        <a class="btn btn-tanit btn-xs" href="/users/{{$rf->_user->id}}/edit" title="modfica"><i class="fa fa-pencil"></i></a>
                                        <a class="btn btn-tanit btn-xs" href="/usersformazione/{{$rf->_user->id}}/edit"><i class="fa fa-mortar-board "></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
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