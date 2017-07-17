<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 09/03/2017
 * Time: 12:34
 */?>

<h2>Gentile tutor,</h2>

Per completare la procedura di attivazione clicca sul seguente link .

<p>
    clicca sul seguente link : <a href="www.tanitsrl.it/attivazione?attivazione={{ $tutor->attivazione }}">ATTIVA</a>
<br>   e inserisci il codice: {{ $tutor->attivazione }}
</p>


<p>
Una volta attivato il tuo account potrai accedere con le seguenti credenziali: <br>
Username: {{  $societa->email }} <br>
Password: {{ $societa->piva }}

</p>


