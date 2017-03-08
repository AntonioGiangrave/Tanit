<?php
$classe_utente= $datiRecuperati->_get_classe_rischio();
$classe_societa= $datiRecuperati->societa->ateco->classe_rischio;
?>

@if($classe_utente)

    <div class="row">
        <div id="classe_utente" class="col-md-2
                @if($classe_utente==2)
                col-md-offset-2
                @endif
        @if($classe_utente==3)
                col-md-offset-4
                @endif
                text-center">

            {{$datiRecuperati->cognome}} <br> <i class="fa fa-arrow-down fa-2x" aria-hidden="true"></i>
        </div>
    </div>
@endif

<div class="row">
    <div id="classe_bassa" class="col-md-2  text-center">
        <button type="button" class="btn btn-success btn-success">CLASSE BASSA</button>
    </div>
    <div id="classe_media" class="col-md-2 text-center">
        <button type="button" class="btn btn-success btn-warning">CLASSE MEDIA</button>
    </div>
    <div id="classe_alta" class="col-md-2 text-center">
        <button type="button" class="btn btn-success btn-danger">CLASSE ALTA</button>
    </div>
</div>

<div class="row">
    <div  class="col-md-2 text-center">
        @if($classe_societa==1)
            <i class="fa fa-arrow-up fa-2x" aria-hidden="true"></i> <br> {{$datiRecuperati->societa->ragione_sociale}}
        @endif
    </div>
    <div class="col-md-2 text-center">
        @if($classe_societa==2)
            <i class="fa fa-arrow-up fa-2x" aria-hidden="true"></i> <br> {{$datiRecuperati->societa->ragione_sociale}}
        @endif
    </div>
    <div class="col-md-2 text-center">
        @if($classe_societa==3)
            <i class="fa fa-arrow-up fa-2x" aria-hidden="true"></i> <br> {{$datiRecuperati->societa->ragione_sociale}}
        @endif
    </div>
</div>

{{--CAMPO DEL FORM --}}
<input id="classe_rischio" name="classe_rischio" type="hidden" value="{{$classe_utente}}">
{{--CAMPO DEL FORM --}}



@section('script')
    <script type="text/javascript">

        $('#classe_bassa').on('click', function(e){
            $('#classe_utente').removeClass('col-md-offset-2 col-md-offset-4',100);
            $('#classe_rischio').val(1);
        });

        $('#classe_media').on('click', function(e){
            $('#classe_utente').removeClass('col-md-offset-2 col-md-offset-4',100).addClass('col-md-offset-2',100);
            $('#classe_rischio').val(2);
        });

        $('#classe_alta').on('click', function(e){
            $('#classe_utente').removeClass('col-md-offset-2 col-md-offset-4', 100).addClass('col-md-offset-4',100);
            $('#classe_rischio').val(3);
        });

    </script>

@stop