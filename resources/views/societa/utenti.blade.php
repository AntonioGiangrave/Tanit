<div class="row">
    <div class="col-sm-12">
        <table class="table table-striped">
            <thead>  <tr>
                <th>Cognome</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Avanzamento formazione</th>
                <th></th>
            </tr>
            </thead>
            <tbody>



            @foreach($utentiSocieta as $dip)

                <?php
                $_avanzamento_formazione = $dip->_avanzamento_formazione->count();
                $_registro_formazione = $dip->_registro_formazione->count();

                $_percentuale_formazione = ($_registro_formazione) ? ($_avanzamento_formazione / $_registro_formazione)*100 : 0;
                $_percentuale_formazione = (int)$_percentuale_formazione."%" ;
                ?>

                <tr>
                    <td>{{ Str::upper($dip->cognome) }}</td>
                    <td>{{ Str::upper($dip->nome) }}</td>
                    <td>
                        @if($dip->hasRole('azienda'))
                            <span class="badge">TUTOR</span>

                        @endif
                    </td>

                    <td>

                        <div class="progress">
                            <div class="progress-bar"
                                 role="progressbar"
                                 aria-valuenow="{{$_avanzamento_formazione}}"
                                 aria-valuemin="0"
                                 aria-valuemax="{{$_registro_formazione}}"
                                 style="width: {{ $_percentuale_formazione}}">
                                {{ $_percentuale_formazione }}
                            </div>
                        </div>

                    </td>
                    <td>

                        @role(['admin', 'azienda'])

                        <a class="text-muted" href="/users/{{$dip->id}}/edit" title="Modfica"><i class="fa fa-pencil fa-2x red"></i></a>
                        <a class="text-muted" href="/usersformazione/{{$dip->id}}" title="Visualizza la formazione"><i class="fa fa-mortar-board fa-2x black "></i></a>
                        <a class="text-muted" href="/pdf_user_libretto_formativo/{{$dip->id}}" target="_blank" title="Scarica libretto formativo "><i class="fa fa-file-text fa-2x celeste"></i></a>

                        @endrole

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
