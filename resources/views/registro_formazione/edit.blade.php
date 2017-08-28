@extends('cache.index')

@section('page_heading')
    Iscrizione al corso {{$corso->titolo }}
@stop

@section('action_button')

    @role(['admin', 'azienda'])
    <a class="btn btn-tanit" href="/registro_formazione"> Gestione personale da formare </a>
    @endrole

@stop

@section('body')

    {{Form::Open(['name'=> 'prenotazioni' , 'id'=> 'prenotazioni' , 'method' => 'post' , 'url' =>'registro_formazione']) }}

    <div class="row">

        <div class="col-sm-4">
            <h4>Vuoi usufruire di un fondo?</h4>
            <div id="list_fondo" class="list-group">
                {{ Form::select('fondo', $fondiprofessionali, Session::get('sessioneaula_id_fondo'),  ['class' => 'form-control, list-group', 'id' => 'fondo']) }}
            </div>
        </div>

        @if((int)Session::get('sessioneaula_step')> 0 )
            <div class="col-sm-8">
                <h4>Quale sessione ti interessa?</h4>
                <div id="list_sessione" class="list-group">
                    @if($sessioniAula->count() > 0 || !is_null($corso->_fad))
                        @foreach($sessioniAula as $sessione)

                            @if($sessione->_aula->fad)

                                <a href="#" data-value="{{$sessione->id}}"
                                   class="list-group-item
                                   @if((int)Session::get('sessioneaula_id_sessione')== $sessione->id) active @endif
                                           " {{-- fineclass--}}
                                   postiliberi="9999"
                                >
                                    {{$sessione->descrizione}} ({{ $sessione->_aula->descrizione }})
                                    <span class="badge">FAD</span>
                                </a>


                            @else
                                <?php $posti_occupati= $sessione->_posti_occupati()->count(); ?>

                                @if($posti_occupati < $sessione->_aula->posti )
                                    <a href="#" data-value="{{$sessione->id}}"
                                       class="list-group-item
                                   @if((int)Session::get('sessioneaula_id_sessione')== $sessione->id) active @endif
                                               " {{-- fineclass--}}
                                       postiliberi="{{$sessione->_aula->posti - $posti_occupati}}"
                                    >
                                        {{$sessione->descrizione}} - dal {{$sessione->dal}} ({{ $sessione->_aula->descrizione }})
                                        <span class="badge">Posti occupati {{$posti_occupati}}/{{$sessione->_aula->posti}}</span>
                                    </a>
                                @endif
                            @endif



                        @endforeach

                    @else
                        <p>Non ci sono sessioni attive per questo corso </p>

                    @endif
                </div>
            </div>
        @endif
    </div>
    <div class="row">
        @if((int)Session::get('sessioneaula_step')> 1 )
            <div class="col-sm-6">
                <h4>Quali utenti vuoi iscrivere?
                    {{--<span  class="badge pull-right" id="selezionati">Nessun utente selezionato</span>--}}
                </h4>
                <ul class="list-group filtrabile utenti_da_iscrivere" data-toggle="items">
                    @foreach($utenti as $utente)
                        <a href="#"
                           data-value="{{$utente->id}}"
                           data-filter="{{$utente->societa->id}}"

                           {{--data-value="{{$utente->id}}"--}}
                           data-mansione="{{$utente->_mansioni->implode('id')}}"

                           class="list-group-item" >
                            {{ Str::upper($utente->nome)}} {{Str::upper($utente->cognome) }}
                            <span class="badge">{{$utente->societa->ragione_sociale}}</span>
                        </a>
                    @endforeach
                </ul>
            </div>
            <div class="col-sm-6">
                <h4>Filtri</h4>

                <h5>Cerca nominativo</h5>
                {{--<input type="text" id="search" onkeyup="cercaNominativo()" placeholder="Cerca nominativo..." class="form-control">--}}
                {{--<br>--}}


                <div class="row">
                    <div class="col-sm-4">
                        {{ Form::text('txtSearch',null,  [ 'id'=> 'txtSearch', 'class' => 'form-control', 'placeholder' => 'Cerca...']) }}
                    </div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <a class="btn btn-tanit btn-xs resetfilter"   href="#">visualizza tutti</a>
                    </div>
                    <div class="col-sm-3">
                        <a class="btn btn-tanit btn-xs soloselezionati"   href="#">visualizza selezionati</a>
                    </div>

                </div>

                <hr>


                <h5>Quanti</h5>
                <button id="btn_seleziona_piuchepuoi" class="btn btn-default btn-xs">Seleziona più utenti possibile</button>
                <button id="btn_seleziona_clear" class="btn btn-default btn-xs">Azzera selezione</button>

                <hr>

                <h5>Con quale mansione</h5>
                <ul class="list-group2 filtra_mansione" data-toggle="items">

                    @foreach($mansioni as $key => $value)
                        <a href="#" data-value="{{$value}}" class="list-group-item" >
                        {{$key}}
                        </a>
                    @endforeach
                    <hr>
                </ul>

                <h5>Di quale societa</h5>
                <ul class="list-group2 filtra_societa" data-toggle="items">

                    @foreach($aziende as $azienda)
                        <a href="#" data-value="{{$azienda->societa->id}}" class="list-group-item" >
                            {{$azienda->societa->ragione_sociale}}
                        </a>
                    @endforeach
                    <hr>
                </ul>

                <hr>

            </div>
            <div class="pull-right">
                {{ Form::hidden('id_sessione', 'id_sessione', array('id' => 'id_sessione')) }}
                {{ Form::hidden('id_utenti', 'id_utenti', array('id' => 'id_utenti')) }}


                {{ Form::submit('Conferma e iscrivi', ['class' => 'btn btn-tanit']) }}
                {{ Form::close() }}
            </div>
        @endif

    </div>

@stop

@section('script')
    <script type="text/javascript">
        $( document ).ready(function() {


            var filter_societa='';
            var filter_mansione='';

            $('#prenotazioni').submit(function( event ) {

                var id_fondo=$('#list_fondo .active').attr('data-value');
                var id_sessione=$('#list_sessione .active').attr('data-value');

                var id_utenti= new Array();
                $('.utenti_da_iscrivere').find('.active').each(function(i, items){
                    id_utenti.push($(items).attr('data-value'));
                });
                id_utenti = id_utenti.toString();

                $('#id_sessione').val(id_sessione);
                $('#id_utenti').val(id_utenti);

                if(!id_fondo || !id_sessione || !id_utenti) {
                    alert("Compilare tutte le informazioni prima di inviare");
                    return false;
                }

                return true;
            });

            //seleziono il fondo
            $('#list_fondo .list-group-item').on('click', function (e) {
                $('#list_sessione').html('Caricamento sessioni in corso...');
                $('.utenti_da_iscrivere').html('Selezionare prima una sessione');
                $.get("/set_ajax_session", {'sessioneaula_step':'1','sessioneaula_id_fondo':$(this).attr('data-value'), 'sessioneaula_id_sessione': '0'}, function () {
                    location.reload();
                });
            });

            //imposto la seessione selezionata
            $('#list_sessione .list-group-item').on('click', function (e) {
                $('.utenti_da_iscrivere').html('Caricamento utenti in corso...');
                $.get("/set_ajax_session/", {'sessioneaula_step':'2', 'sessioneaula_id_sessione': $(this).attr('data-value') }, function () {
                    location.reload();
                });
            });

            //seleziona piu utenti possibile
            $('#btn_seleziona_piuchepuoi').on('click', function (e) {
                e.preventDefault();
                $('.utenti_da_iscrivere .list-group-item').removeClass('active');
                $('.utenti_da_iscrivere a').show();


                var quanti  = $('#list_sessione').find('.active').attr('postiliberi');
                for(i = 0; i < quanti; i++) {
                    $(".utenti_da_iscrivere .list-group-item " ).eq(i).addClass("active");
                }

                $('#selezionati').html($('.utenti_da_iscrivere a.active').length + ' selezionati');
            });

            //conteggio selezionati
//            $('.utenti_da_iscrivere .list-group-item').click(function (){
//                count = $('.utenti_da_iscrivere a.active').length;
//                $('#selezionati').html(count + ' selezionati');
//            });

            //azzera selezione
            $('#btn_seleziona_clear').on('click', function (e) {
                e.preventDefault();
                $('.utenti_da_iscrivere .list-group-item').removeClass('active');
                $('.utenti_da_iscrivere a').show();

                $('#selezionati').html('0 selezionati');

                filter_societa= '';
                filter_mansione= '';

            });

//            filtra per societa
            $('.filtra_societa .list-group-item ').on('click', function (e) {
                filter_societa = $(this).attr('data-value');
                $('.utenti_da_iscrivere a').show();
                $('.utenti_da_iscrivere a:not([data-filter="' + filter_societa + '"])').hide();
            });

            //filtra per mansione
            $('.filtra_mansione .list-group-item ').on('click', function (e) {
                filter_mansione = $(this).attr('data-value');
                $('.utenti_da_iscrivere a').show();
                $('.utenti_da_iscrivere a:not([data-mansione="' + filter_mansione + '"])').hide()

            });

        });
    </script>
@stop


@role(['admin', 'azienda'])
@section('help')
    Seleziona dall’elenco il tuo fondo interprofessionale e la data del corso di tuo interesse per finalizzare l’iscrizione.
    Successivamente verifica la disponibilità residua per la data che hai scelto e le eventuali sessioni in e-learning del corso di tuo interesse.
@stop

@endrole