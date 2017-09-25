@extends('cache.index')

@section('page_heading')

    @role((['admin', 'azienda']))
    @if($societa->count() > 1)
        <h3>Monitora personale</h3>
        {{ Form::open(array('url' => '/usersControllerindex',   'method'=>'post' ,  'class' => 'form-inline')) }}
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group ">
                    {{ Form::label('societa', 'Seleziona aziende :') }}
                    {{ Form::select('societa[]', $societa, $societa_selezionate,['id'=> 'societa_selezionate', 'class' => '  selectpicker  ', 'multiple']) }}
                </div>
            </div>
        </div>
        {{Form::close()}}
    @else
        <h3>Monitora personale</h3>
    @endif
    @endrole

@stop

@section('action_button')
    @role((['admin', 'azienda']))
    @if($societa->count() > 0)
        {{ Form::open(array('url' => '/sync_azienda', 'action'=>'index' , 'method' => 'post', 'class' => 'form-inline')) }}
        {{ Form::hidden('sync_societa_id', implode(",", $societa_selezionate) , ['class' => 'form-control', 'hidden'=>'hidden', 'id'=>'sync_societa_id', 'name'=>'sync_societa_id']) }}
        {{ Form::submit('SINCRONIZZA', ['class' => 'btn btn-tanit btn-xs']) }}

        <a href="/users/create" class="btn btn-tanit btn-xs">NUOVO UTENTE</a>

        <a target="_blank" href="/pdf_stato_formazione" class="btn btn-tanit btn-xs">STAMPA</a>

        {{Form::close()}}
    @endif
    @endrole
@stop

@section('body')
    <div class="row">
        <div class="col-sm-12">

            <input type="text" id="search" onkeyup="cercaItem()" placeholder="Cerca utente..." class="form-control">
            <br>

            <table id="tabella" class="table table-striped">

                <thead>  <tr>
                    <th>Cognome</th>
                    <th>Nome</th>
                    @if(count($societa_selezionate) > 1)
                        <th>Societa</th>
                    @endif
                    <th>Classe</th>
                    <th>Avanzamento formazione</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>


                @foreach($data as $dip)

                    <?php
                    $_avanzamento_formazione = $dip->_avanzamento_formazione->count();
                    $_registro_formazione = $dip->_registro_formazione->count() ;

                    $_percentuale_formazione = ($_registro_formazione) ? ($_avanzamento_formazione / $_registro_formazione)*100 : 0;
                    $_percentuale_formazione = (int)$_percentuale_formazione."%" ;
                    ?>

                    <tr>

                        <td>{{ Str::title($dip->cognome) }}</td>
                        <td>{{ Str::title($dip->nome) }}</td>
                        @if(count($societa_selezionate) > 1)
                            <td><span class="badge">{{ Str::title($dip->societa->ragione_sociale) }}</span></td>
                        @endif

                        <td>
                            <?php $classe_dip = $dip->_get_classe_rischio(); ?>

                            @if($classe_dip == 1)
                                <a href="#"> <i title="Classe di rischio bassa" class="text-success fa fa-thermometer-empty fa-2x" aria-hidden="true"></i></a>
                            @endif

                            @if($classe_dip == 2)
                                <a href="#"><i title="Classe di rischio media" class="text-warning fa fa-thermometer-half fa-2x" aria-hidden="true"></i></a>
                            @endif

                            @if($classe_dip == 3)
                                <a href="#"><i title="Classe di rischio alta" class="text-danger fa fa-thermometer-full fa-2x" aria-hidden="true"></i></a>
                            @endif

                            @if($classe_dip != $dip->societa->ateco->classe_rischio)
                                <a href="" class="text-muted " data-toggle="modal" data-target="#myModal"><small><i title="Classe dipendente diversa da classe ATECO azienda" class="fa fa-exclamation-triangle" aria-hidden="true"></i></small></a>
                            @endif

                            @if($dip->_mansioni->count() == 0)
                                <a href="#" class="text-muted "  ><small><i title="Mansioni non selezionate" class="fa fa-wrench" aria-hidden="true"></i></small></a>
                            @endif


                        </td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar"
                                     role="progressbar"
                                     aria-valuenow="{{$_avanzamento_formazione }}"
                                     aria-valuemin="0"
                                     aria-valuemax="{{$_registro_formazione }}"
                                     style="width: {{ $_percentuale_formazione }}">
                                    {{ $_percentuale_formazione }}
                                </div>
                            </div>
                        </td>
                        <td>
                            @role(['admin', 'azienda'])
                            <a class="text-muted" href="users/{{$dip->id}}/edit" title="Modfica"><i class="fa fa-pencil fa-2x red"></i></a>
                            <a class="text-muted" href="usersformazione/{{$dip->id}}" title="Visualizza la formazione"><i class="fa fa-mortar-board fa-2x black "></i></a>
                            <a class="text-muted" href="pdf_user_libretto_formativo/{{$dip->id}}" target="_blank" title="Scarica libretto formativo "><i class="fa fa-file-text fa-2x celeste"></i></a>
                            @endrole

                            @if($dip->hasRole('azienda'))
                                <a class="text-muted" href="#" title="Utente tutor/amministratore"><i class="fa fa-address-card fa-2x yellow"></i></a>
                            @endif

                        </td>
                    </tr>

                @endforeach

                </tbody>


            </table>
        </div>
    </div>
    @stop


    @section('script')

            <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/js/bootstrap-select.min.js"></script>





    <script type="text/javascript">

        $('#societa_selezionate').on('change', function(e){
            $(this).closest('form').submit();
        });

        $(document).ready(function() {
            $('.selectpicker').selectpicker({
                style: 'btn btn-tanit btn-xs scelta-societa selectpicker',
                size: 10
            });

            $('.selectpicker').on('change', function(e){
                var tmp =  $('.scelta-societa span').first().text();
                if(tmp.length > 50)
                    tmp = "Selezione multipla"
                $('.scelta-societa span').first().text(tmp);
            });
        });


        function cercaItem() {
            // Declare variables
            var input, filter, table, tr, td, i;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.getElementById("tabella");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

    </script>

    @stop





            <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Notifica</h4>
                </div>
                <div class="modal-body">

                    <div class="media">
                        <div class="media-left media-middle">
                            <a href="#">
                                <i class="fa fa-warning fa-4x"></i>
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Attenzione, per questo utente è assegnata una classe di rischio differente dalla classe dell'Ateco dell'azienda dove lavora.
                                <br>
                                Se questa situazione è corretta non fare niente, altrimenti clicca sull'icona  <i class="fa fa-pencil fa-2x"></i> corrispondente per modificare il dato.
                            </h4>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>





    @role(['admin', 'azienda'])
@section('help')
    Per visualizzare le informazioni sul personale, clicca sulle icone. Da lì potrai effettuare modifiche, gesrtire i singoli utenti e scaricare il libretto formativo.
    Da qui puoi gestire l’elenco dei dipendenti associati all’azienda. Puoi effettuare una ricerca digitando il nome utente nel campo “cerca”, modificare le informazioni, verificare lo stato di avanzamento di ciascun utente o scaricare il libretto formativo.
@stop

@endrole