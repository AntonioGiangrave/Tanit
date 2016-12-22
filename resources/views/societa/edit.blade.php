@extends('cache.index')

@section('page_heading','Scheda società: ' .  $datiRecuperati['ragione_sociale'])
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
                            {{--@include('societa.utenti', $utentiSocieta)--}}
                        </div>
                    </div>
                </div>
            </div>




    </div>









@stop