<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 08/03/2017
 * Time: 12:21
 */

$image_path = '/images/logo.png';
?>

<div id="fh5co-logo"><img src="{{ public_path() . $image_path }}" alt="Logo Tanit"></div>
<hr>
<h3>SCHEDA DI RIEPILOGO</h3>
<p>CORSO:<b> {{ $sessione->_corso->titolo }} </b> </p>
<p>PERIODO: dal <b>{{ $sessione->dal }}</b> al <b>{{ $sessione->al }}</b> </p>
<p>AULA: <b>{{ $sessione->_aula->descrizione }}</b> (<b>{{ $sessione->_aula->indirizzo }}</b>) </p>
<hr>

<?php $i=1; ?>
<table>
    <tr>
    <td> </td>
    <td>Cognome</td>
    <td>Nome</td>
        <td>Azienda</td>
    </tr>
    <tbody>
    @foreach($sessione->_posti_occupati() as $iscritti)
        <tr style='border-bottom: 1px solid grey;'>
            <td>{{ $i++ }}</td>
            <td width="100">{{ $iscritti->_user->cognome }}</td>
            <td width="100">{{ $iscritti->_user->nome }} </td>
            <td width="100">{{ $iscritti->_user->societa->ragione_sociale}} </td>
            <td>{{ $iscritti->_user->email }} </td>
        </tr>
    @endforeach
    </tbody>
</table>