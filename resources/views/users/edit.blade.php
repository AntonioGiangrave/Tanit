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

            <div class="col-md-4">


                @role(['admin'])
                    {{ Form::label('Autorizzazioni', 'Gruppi:') }}
                    <div class='form-group'>
                        @foreach ($roles as $key => $val)
                            <br>
                            {{ Form::checkbox('groups[]', $key) }}
                            {{ Form::label('groups', $val) }}
                        @endforeach
                    </div>
                @endrole

            </div>


        </div>

        <hr>

        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion"
                           href="#collapse1">
                            Dettagli profilo
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

        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion"
                           href="#collapse5">
                            Mansioni
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
                           href="#collapse4">
                            Incarichi di sicurezza
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
                           href="#collapse3">
                            Albi Professionali
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

        <div class="row">

            <div class="pull-right">
                {{ Form::button('<i class="fa fa-save"></i> Aggiorna', ['class' => 'btn btn-success', 'type'=>'submit', 'type'=>'submit']) }}

                {{ Form::close() }}

            </div>

        </div>

    </div>

@stop