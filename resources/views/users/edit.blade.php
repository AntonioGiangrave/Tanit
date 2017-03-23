@extends('cache.index')

@section('page_heading', $datiRecuperati['nome'] . " " . $datiRecuperati['cognome'])
@section('body')

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

        {{
        Form::model($datiRecuperati,
        ['method' => 'put', 'url' =>'users/'. $datiRecuperati['id']])
        }}

        <div class="row">
            <div class="col-md-4">

                <div class="form-group">
                    {{ Form::label('nome', 'Il tuo nome:') }}
                    {{ Form::text('nome', null, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('cognome', 'Il tuo cognome:') }}
                    {{ Form::text('cognome', null, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('email', 'La tua email:') }}

                    {{ Form::text('email', null, ['class' => 'form-control']) }}
                </div>

            </div>

            <div class="col-md-4">

                <div class="form-group">
                    {{ Form::label('societa_id', 'Società di appartenenza:') }}
                    {{ Form::select('societa_id', $societa, null, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('bloccato', 'Bloccato:') }}
                    {{ Form::select('bloccato', array(0 => 'No' , 1=> 'Si'),null ,['class' => 'form-control' ]) }}
                </div>

            </div>


        </div>

        <hr>

        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion"
                           href="#collapse1"><i class="fa fa-user fa-2x fa-width" aria-hidden="true"></i>
                            DETTAGLI PROFILO
                        </a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse ">
                    <div class="panel-body">
                        @include('users.edit_detail',  $datiRecuperati)
                    </div>
                </div>
            </div>
        </div>

        <hr>
        @role(['admin'])
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion"
                           href="#collapse7"><i class="fa fa-users fa-2x fa-width" aria-hidden="true"></i>
                            GRUPPI
                        </a>
                    </h4>
                </div>
                <div id="collapse7" class="panel-collapse collapse ">
                    <div class="panel-body">
                        @include('users.edit_gruppi_tutor',  $datiRecuperati)
                    </div>
                </div>
            </div>
        </div>

        <hr>
        @endrole
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion"
                           href="#collapse5"><i class="fa fa-wrench fa-2x fa-width" aria-hidden="true"></i>
                            MANSIONI
                        </a>
                    </h4>
                </div>
                <div id="collapse5" class="panel-collapse collapse ">
                    <div class="panel-body">
                        @include('users.edit_mansioni',  $datiRecuperati)
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion"
                           href="#collapse4"><i class="fa fa-shield fa-2x fa-width" aria-hidden="true"></i>
                            INCARICHI SICUREZZA
                        </a>
                    </h4>
                </div>
                <div id="collapse4" class="panel-collapse collapse ">
                    <div class="panel-body">
                        @include('users.edit_incarichi_sicurezza',  $datiRecuperati)
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion"
                           href="#collapse3"><i class="fa fa-drivers-license fa-2x fa-width" aria-hidden="true"></i>
                            ALBI PROFESSIONALI
                        </a>
                    </h4>
                </div>
                <div id="collapse3" class="panel-collapse collapse ">
                    <div class="panel-body">
                        @include('users.edit_albi',  $datiRecuperati)
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion"
                           href="#collapse6"><i class="fa fa-thermometer-half fa-2x fa-width" aria-hidden="true"></i>
                            CLASSE DI RISCHIO
                        </a>
                    </h4>
                </div>
                <div id="collapse6" class="panel-collapse collapse ">
                    <div class="panel-body">
                        @include('users.edit_classe_rischio',  $datiRecuperati)
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="pull-right">


                {{ Form::button('<i class="fa fa-save"></i> Aggiorna', ['class' => 'btn btn-tanit btn-xs', 'type'=>'submit', 'type'=>'submit']) }}

                {{ Form::close() }}

            </div>

        </div>

    </div>

@stop



    {{--<script type="text/javascript">--}}
        {{--$(document).ready(function() {--}}
            {{--$(".panel-heading").click(function () {--}}
                {{--console.log('ok');--}}

            {{--});--}}
        {{--});--}}


    {{--</script>--}}


