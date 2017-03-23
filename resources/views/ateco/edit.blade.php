@extends('cache.index')

@section('page_heading','Ateco: [' .  $datiRecuperati['codice'] . "] - ".  $datiRecuperati['descrizione'])
@section('body')

    {{
           Form::model($datiRecuperati,
           ['method' => 'put', 'url' =>'ateco/'. $datiRecuperati['id']])
    }}


    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-5">
                <div class="form-group">
                    {{ Form::label('codice', 'Codice:') }}
                    {{ Form::text('codice', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('descrizione', 'Descrizione:') }}
                    {{ Form::text('descrizione',null,  ['class' => 'form-control']) }}

                </div>

                <div class="pull-right">
                    {{ Form::submit('Salva', ['class' => 'btn btn-tanit']) }}
                    {{ Form::close() }}
                </div>

            </div>

            <div class="col-sm-7">

                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#spec">Sic. Specifica ({{$datiRecuperati->_corsi_sicurezza_specifica->count()}})</a></li>
                    <li><a data-toggle="tab" href="#rspp">RSPP ({{$datiRecuperati->_corsi_rspp->count()}})</a></li>
                    <li><a data-toggle="tab" href="#aspp">ASPP ({{$datiRecuperati->_corsi_aspp->count()}})</a></li>
                </ul>

                <div class="tab-content">
                    <div id="spec" class="tab-pane fade in active">
                        @include('ateco.corsi_sicurezza_specifica ',  $datiRecuperati)
                    </div>


                    <div id="rspp" class="tab-pane fade">
                        @include('ateco.corsi_rspp ',  $datiRecuperati)
                    </div>


                    <div id="aspp" class="tab-pane fade ">
                        @include('ateco.corsi_aspp ',  $datiRecuperati)
                    </div>
                </div>




















            </div>
        </div>
    </div>


@stop
