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

            <div class="col-sm-6">
                <div class="form-group">
                    {{ Form::label('validita', 'Validità:') }}
                    {{ Form::text('validita', null, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="col-sm-5">
                <div class="form-group">
                    {{ Form::label('tipo', 'Tipo:') }}
                    {{ Form::select('tipo', array('S' => 'Corso sicurezza' , 'R' => 'Corso ruolo'),  $datiRecuperati['tipo'], ['placeholder'=> 'Seleziona la tipologia...', 'class' => 'form-control']) }}
                </div>
            </div>
        </div>


        {{--<h4>Modalità di erogazione</h4>--}}

        {{--<div class="row">--}}

            {{--<div class="col-sm-2">--}}
                {{--<div class="form-group">--}}
                    {{--{{ Form::label('cfp', 'CFP:') }}--}}
                    {{--{{ Form::checkbox('cfp', null, $datiRecuperati['cfp'], ['class' => 'form-control_']) }}--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

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
            {{ Form::submit('aggiorna', ['class' => 'btn btn-tanit']) }}

            {{ Form::close() }}

        </div>

        {{--<div class="pull-right">--}}
            {{--{{ Form::open([--}}
                               {{--'method' => 'DELETE',--}}
                               {{--'url' => ['corsi', $datiRecuperati['id']]--}}
                               {{--]) }}--}}
            {{--{{ Form::submit('Cancella', ['class' => 'btn btn-danger ']) }}--}}
            {{--{{ Form::close() }}--}}
        {{--</div>--}}
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


@section('help')


    Cos’è Lorem Ipsum?

    Lorem Ipsum è un testo segnaposto utilizzato nel settore della tipografia e della stampa. Lorem Ipsum è considerato il testo segnaposto standard sin dal sedicesimo secolo, quando un anonimo tipografo prese una cassetta di caratteri e li assemblò per preparare un testo campione. È sopravvissuto non solo a più di cinque secoli, ma anche al passaggio alla videoimpaginazione, pervenendoci sostanzialmente inalterato. Fu reso popolare, negli anni ’60, con la diffusione dei fogli di caratteri trasferibili “Letraset”, che contenevano passaggi del Lorem Ipsum, e più recentemente da software di impaginazione come Aldus PageMaker, che includeva versioni del Lorem Ipsum.
    Perchè lo utilizziamo?

    È universalmente riconosciuto che un lettore che osserva il layout di una pagina viene distratto dal contenuto testuale se questo è leggibile. Lo scopo dell’utilizzo del Lorem Ipsum è che offre una normale distribuzione delle lettere (al contrario di quanto avviene se si utilizzano brevi frasi ripetute, ad esempio “testo qui”), apparendo come un normale blocco di testo leggibile. Molti software di impaginazione e di web design utilizzano Lorem Ipsum come testo modello. Molte versioni del testo sono state prodotte negli anni, a volte casualmente, a volte di proposito (ad esempio inserendo passaggi ironici).

    @stop