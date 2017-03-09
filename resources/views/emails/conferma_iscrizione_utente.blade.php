<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 09/03/2017
 * Time: 12:34
 */?>

<h2>Gentile {{ $user }},</h2>
questa mail conferma la tua <b>iscrizione</b> al corso di formazione. <br>
Ecco i dettagli : <br>
<hr>
<p>CORSO:<b> {{ $sessione->_corso->titolo }} </b> </p>
<p>PERIODO: dal <b>{{ $sessione->dal }}</b> al <b>{{ $sessione->al }}</b></p>
<p>ORARIO: dalle <b>{{ $sessione->orario_dalle }}</b> alle <b>{{ $sessione->orario_alle }}</b></p>
<p>AULA: <b>{{ $sessione->_aula->descrizione }}</b> - <b>{{ $sessione->_aula->indirizzo }}</b> </p>
<hr>