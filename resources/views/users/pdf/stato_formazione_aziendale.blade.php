
<!DOCTYPE html>

<head>


    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!-- <link rel="shortcut icon" href="favicon.ico"> -->

    {{--<link rel="stylesheet" href="{{ asset("assets/stylesheets/styles.css") }}" />--}}


</head>





<?php
$image_path = '/images/logo.png';
?>

<div id="fh5co-logo"><img src="{{ public_path() . $image_path }}" alt="Logo Tanit"></div>
<hr>

<h4>Riepilogo formazione aziendale per: </h4>
<ul>
@foreach($lista_societa  as $societa)
    <li>{{$societa->ragione_sociale}}</li>
@endforeach
</ul>
<hr>

<table class="table table-striped">

    <thead>  <tr>
        <th>Cognome</th>
        <th>Nome</th>
        @if(count($societa_selezionate) > 1)
            <th>Societa</th>
        @endif
        <th>Classe di rischio</th>
        <th>Avanzamento formazione</th>
        <th> </th>
    </tr>
    </thead>
    <tbody>


    @foreach($utenti as $dip)

        <?php
        $_avanzamento_formazione = $dip->_avanzamento_formazione->count();
        $_registro_formazione = $dip->_registro_formazione->count() ;

        $_percentuale_formazione = ($_registro_formazione) ? ($_avanzamento_formazione / $_registro_formazione)*100 : 0;
        $_percentuale_formazione = (int)$_percentuale_formazione."%" ;
        ?>

        <tr>

            <td width="100">{{ Str::title($dip->cognome) }}</td>
            <td width="100">{{ Str::title($dip->nome) }}</td>
            @if(count($societa_selezionate) > 1)
                <td width="100"><span class="badge">{{ Str::title($dip->societa->ragione_sociale) }}</span></td>
            @endif

            <td width="100">
                <?php $classe_dip = $dip->_get_classe_rischio(); ?>

                @if($classe_dip == 1)
                    Bassa
                @endif

                @if($classe_dip == 2)
                        Media
                @endif

                @if($classe_dip == 3)
                    Alta
                @endif

                @if($classe_dip != $dip->societa->ateco->classe_rischio)
                    *
                @endif

                @if($dip->_mansioni->count() == 0)
                    -
                @endif


            </td>
            <td width="50">
                <div class="progress">
                    <div class="progress-bar ">

                        {{ $_percentuale_formazione }}
                    </div>
                </div>
            </td>


        </tr>

    @endforeach

    </tbody>


</table>


