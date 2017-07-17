@extends('cache.index')

@section('page_heading','Scheda azienda: ' .  $datiRecuperati['ragione_sociale'])


@section('action_button')
    <div class="push-right">
        <a class="btn btn-tanit btn-xs "   href="/societa"><i class="fa fa-plus-square "></i>Torna a elenco aziende</a>
    </div>
@stop



@section('body')

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion"
                           href="#collapse1">
                            Informazioni azienda
                        </a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse in ">
                    <div class="panel-body">
                        @include('societa.details', $datiRecuperati)
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion"
                           href="#collapse2">
                            Dipendenti
                        </a>
                    </h4>
                </div>
                <div id="collapse2" class="panel-collapse collapse  ">
                    <div class="panel-body">
                        @include('societa.utenti', $utentiSocieta)
                    </div>
                </div>
            </div>
        </div>

    </div>

@stop