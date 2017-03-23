@extends('cache.index')

@section('page_heading','Scheda corso: ' .  $datiRecuperati['ragione_sociale'])
@section('body')

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">


        {{Form::model($datiRecuperati, ['method' => 'put', 'url' =>'corsi/'. $datiRecuperati['id']]) }}

        {{ Form::hidden('token', csrf_token(), ['type'=>'hidden']) }}




        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    {{ Form::label('titolo', 'Titolo:') }}
                    {{ Form::text('titolo', null, ['class' => 'form-control']) }}
                </div>

            </div>

        </div>

        <div class="row">
            <div class="col-sm-1">
                <div class="form-group">
                    {{ Form::label('durata', 'Durata:') }}
                    {{ Form::text('durata', null, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="col-sm-11">
                <div class="form-group">
                    {{ Form::label('validita', 'Validità:') }}
                    {{ Form::text('validita', null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>


        <h4>Modalità di erogazione</h4>

        <div class="row">

            <div class="col-sm-2">
                <div class="form-group">
                    {{ Form::label('cfp', 'CFP:') }}
                    {{ Form::checkbox('cfp', null, $datiRecuperati['cfp'], ['class' => 'form-control_']) }}
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    {{ Form::label('aula', 'Informazioni aula:') }}
                    {{ Form::select('aula', [''=>'Corso non disponibile in aula'] + $aule , $datiRecuperati['aula'], ['class' => 'form-control']) }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    {{ Form::label('fad', 'Informazioni fad:') }}
                    {{ Form::select('fad', [''=>'Corso non disponibile in fad'] + $fad , $datiRecuperati['fad'], ['class' => 'form-control']) }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    {{ Form::label('programma', 'Programma:') }}
                    {{ Form::textarea('programma', null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>

        <hr>

        <h4>Competenza Albi</h4>

        <div class="row">
            <div class="col-sm-12">
                <div class='form-group'>
                    @foreach ($albi_professionali as $key => $val)
                        <br>
                        {{ Form::checkbox('competenza_albi[]', $key) }}
                        {{ Form::label('competenza_albi', $val) }}
                    @endforeach
                </div>
            </div>
        </div>

        <div class="pull-right">
            {{ Form::submit('aggiorna', ['class' => 'btn btn-success']) }}

            {{ Form::close() }}

        </div>

        <div class="pull-right">
            {{ Form::open([
                               'method' => 'DELETE',
                               'url' => ['corsi', $datiRecuperati['id']]
                               ]) }}
            {{ Form::submit('Cancella', ['class' => 'btn btn-danger btn-sm']) }}
            {{ Form::close() }}
        </div>
    </div>

@stop

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({
        selector:'textarea',
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code'
        ],
        toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        content_css: '//www.tinymce.com/css/codepen.min.css'

    });</script>