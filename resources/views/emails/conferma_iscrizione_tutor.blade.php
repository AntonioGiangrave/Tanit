<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 09/03/2017
 * Time: 12:34
 */?>

<h2>Gentile tutor,</h2>
sono stati iscritti {{$users->count()}} nuovi utenti al corso di formazione {{ $sessione->_corso->titolo }}.
Ecco i dettagli : <br>
<hr>
<p>CORSO:<b> {{ $sessione->_corso->titolo }} </b> </p>
<p>PERIODO: dal <b>{{ $sessione->dal }}</b> al <b>{{ $sessione->al }}</b></p>
<p>ORARIO: dalle <b>{{ $sessione->orario_dalle }}</b> alle <b>{{ $sessione->orario_alle }}</b></p>
<p>AULA: <b>{{ $sessione->_aula->descrizione }}</b> - <b>{{ $sessione->_aula->indirizzo }}</b> </p>
<p>POSTI DISPONIBILI: {{$sessione->_aula->posti}}  </p>
<p>CAPIENZA AULA: {{$sessione->_posti_occupati()->count()}}  </p>
<p>FONDO PROFESSIONALE ADOTTATO: <b> {{$fondo->name}} </b> </p>

<hr>
<h3>Nuovi iscritti:</h3>

<ul>
@foreach($users as $user)
    <li>{{ $user->cognome }} {{ $user->nome }} ({{ $user->societa->ragione_sociale }} )</li>
    @endforeach
</ul>