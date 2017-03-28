<?php
$image_path = '/images/logo.png';
?>

<div id="fh5co-logo"><img src="{{ public_path() . $image_path }}" alt="Logo Tanit"></div>
<hr>
<h3>Libretto formativo di {{ Str::upper($utente->nome)}} {{ Str::upper($utente->cognome)}} </h3>
<p>Societa: <b>{{ $utente->societa->ragione_sociale}}</b>  </p>
<p>Mansioni ricoperte: <b>{{ implode(",", $utente->_mansioni->lists('nome')->all())}}</b>  </p>

<hr>

<?php $i=1; ?>
<table>
    <tr>
        <td width="400px"><b>CORSO</b></td>
        <td width="150px" align="center" ><b>SITUAZIONE</b></td>
        <td width="150px" align="center"><b>SIC./RUOLO</b></td>


    </tr>
    <tbody>
    @foreach($utente->_registro_formazione as $corso)
        <tr>
            <td style="font-size: 11px">{{ strtoupper($corso->_corsi->titolo) }}   </td>
            <td style="font-size: 11px" align="center">
                @if($corso->esonerato == 1)
                    {{ $corso->description }}
                @else
                    @if($corso->data_superamento)
                        {{ $corso->data_superamento }}
                    @else
                        Non conseguito
                    @endif
                @endif

            </td>
            <td align="center">{{$corso->_corsi->tipo}}</td>
        </tr>
    @endforeach
    </tbody>
</table>