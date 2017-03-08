@extends('cache.index')

@section('page_heading')
    Iscrizione al corso {{$corso->titolo }}
@stop

@section('body')


    {{Form::Open(['name'=> 'prenotazioni' , 'id'=> 'prenotazioni' , 'method' => 'post' , 'url' =>'registro_formazione']) }}


    <div class="row">

        <div class="col-sm-4">
            <h4>Vuoi usufruire di un fondo?</h4>
            <div id="list_fondo" class="list-group">
                {{ Form::select('fondo', $fondiprofessionali, Session::get('sessioneaula.id_fondo'),  ['class' => 'form-control, list-group', 'id' => 'fondo']) }}
            </div>
        </div>



        @if((int)Session::get('sessioneaula.step')> 0 )
            <div class="col-sm-8">
                <h4>Quale sessione ti interessa?</h4>
                <div id="list_sessione" class="list-group">
                    @foreach($sessioniAula as $sessione)
                        <?php $posti_occupati= $sessione->_posti_occupati()->count(); ?>

                        @if($posti_occupati < $sessione->_aula->posti )
                            <a href="#" data-value="{{$sessione->id}}"
                               class="
                               list-group-item
                               @if((int)Session::get('sessioneaula.id_sessione')== $sessione->id) active @endif
                                       " {{-- fineclass--}}

                               postiliberi="{{$sessione->_aula->posti - $posti_occupati}}"
                            >
                                {{$sessione->descrizione}} - dal {{$sessione->dal}} ({{ $sessione->_aula->descrizione }})
                                <span class="badge">{{$posti_occupati}}/{{$sessione->_aula->posti}}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    <div class="row">
        @if((int)Session::get('sessioneaula.step')> 1 )
            <div class="col-sm-6">
                <h4>Quali utenti vuoi iscrivere? <span  class="badge pull-right" id="selezionati">Nessun utente selezionato</span></h4>
                <ul class="list-group utenti_da_iscrivere" data-toggle="items">
                    @foreach($utenti as $utente)
                        <a href="#"
                           data-value="{{$utente->id}}"
                           data-filter="{{$utente->societa->id}}"
                           class="list-group-item" >
                            {{$utente->nome}} {{$utente->cognome}}
                            <span class="badge">{{$utente->societa->ragione_sociale}}</span>
                        </a>
                    @endforeach
                </ul>
            </div>
            <div class="col-sm-6">
                <h4>Filtri</h4>


                <h4>Quanti</h4>
                <button id="btn_seleziona_piuchepuoi" class="btn btn-default btn-xs">Seleziona più utenti possibile</button>
                <button id="btn_seleziona_clear" class="btn btn-default btn-xs">Azzera selezione</button>

                <hr>
                <h4>Di quale societa</h4>
                <ul class="list-group2 filtra_societa" data-toggle="items">

                    @foreach($aziende as $azienda)
                        <a href="#" data-value="{{$azienda->societa->id}}" class="list-group-item" >
                            {{$azienda->societa->ragione_sociale}}
                        </a>
                    @endforeach
                    <hr>
                </ul>

            </div>
            <div class="pull-right">

                {{ Form::hidden('id_sessione', 'id_sessione', array('id' => 'id_sessione')) }}
                {{ Form::hidden('id_utenti', 'id_utenti', array('id' => 'id_utenti')) }}
                {{ Form::hidden('id_corso', $corso->id , array('id' => 'id_corso')) }}


                {{ Form::submit('Conferma e iscrivi', ['class' => 'btn btn-success']) }}
                {{ Form::close() }}
            </div>
        @endif

    </div>




@stop

@section('script')
    <script type="text/javascript">
        $( document ).ready(function() {


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



            $('#list_fondo .list-group-item').on('click', function (e) {
                $('#list_sessione').html('Caricamento sessioni in corso...');
                $('.utenti_da_iscrivere').html('Selezionare prima una sessione');
                var data_session ={'sessioneaula.step':'1','sessioneaula.id_fondo':$(this).attr('data-value'), 'sessioneaula.id_sessione': '0'};
                $.get("/set_ajax_session/", {data_session: data_session }, function () {
                    location.reload();
                });
            });

            //imposto la seessione selezionata
            $('#list_sessione .list-group-item').on('click', function (e) {
                $('.utenti_da_iscrivere').html('Caricamento utenti in corso...');
                var data_session ={'sessioneaula.step':'2', 'sessioneaula.id_sessione': $(this).attr('data-value')};
                $.get("/set_ajax_session/", {data_session: data_session }, function () {
                    location.reload();
                });
            });


            $('#btn_seleziona_piuchepuoi').on('click', function (e) {
                e.preventDefault();
                var quanti  = $('#list_sessione').find('.active').attr('postiliberi');
                for(i = 0; i < quanti; i++) {
                    $(".utenti_da_iscrivere .list-group-item").eq(i).addClass("active");
                }

                $('#selezionati').html($('.utenti_da_iscrivere a.active').length + ' selezionati');
            });


            $('.utenti_da_iscrivere .list-group-item').on('click', function (e) {

                count =$('.utenti_da_iscrivere a.active').length - 1;
                $('#selezionati').html(count + ' selezionati');
            });



            $('#btn_seleziona_clear').on('click', function (e) {
                e.preventDefault();
                $('.utenti_da_iscrivere .list-group-item').removeClass('active');
                $('.utenti_da_iscrivere a').show();

                $('#selezionati').html('0 selezionati');

            });

            $('.filtra_societa .list-group-item ').on('click', function (e) {

                var Filter = $(this).attr('data-value');
                $('.utenti_da_iscrivere a').show();
                $('.utenti_da_iscrivere a:not([data-filter="' + Filter + '"])').hide();

            });



        });
    </script>
@stop