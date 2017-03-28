@extends('cache.index')

@section('page_heading','Libretto formativo di
 <a href="/users/'.$datiRecuperati->id . '/edit">' . $datiRecuperati->cognome .' '.$datiRecuperati->nome . '</a> [classe '.$datiRecuperati->user_profiles->classe_rischio.']'
 )
@section('body')


    <h4>Società: <a href="/societa/{{$datiRecuperati->societa->id}}/edit">{{$datiRecuperati->societa->ragione_sociale}}</a>,  ateco {{$datiRecuperati->societa->ateco->codice}}, classe di rischio {{$datiRecuperati->societa->ateco->classe_rischio}} </h4>


    <div class="row">
        <div class="col-sm-6">


            <h4>Sei al {{ round($avanzamentoFormazione/$totaleFormazione*100) . '%' }} della tua formazione</h4>
        <span>
            Hai ancora {{$totaleFormazione - $avanzamentoFormazione}} corsi da completare,
            indica per quali hai già conseguito un attestato e procedi a iscriverti agli altri.
        </span>

        </div>
        <div class="col-sm-6">

            <div class="progress progress-tall ">
                <div class="progress-bar progress-bar-success progress-bar-striped" style="width: {{ round($avanzamentoRuolo/$totaleFormazione*100) . '%' }}">
                    <span class="sr-only">35% Complete (success)</span>
                </div>
                <div class="progress-bar progress-bar-warning progress-bar-striped" style="width: {{ round($avanzamentoSicurezza/$totaleFormazione*100) . '%' }}">
                    <span class="sr-only">20% Complete (warning)</span>
                </div>

            </div>

        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-sm-6">
            <h4>Le tue mansioni sono:</h4>
            <ul>
                @foreach($datiRecuperati->_mansioni as $mansione)
                    <li>{{ $mansione->nome  }}  (Classe rischio {{ $mansione->classe_rischio }}) </li>
                @endforeach
            </ul>
        </div>

        <div class="col-sm-6">
            <h4>I tuoi incarichi sicurezza sono: </h4>
            <ul>
                @foreach($datiRecuperati->_incarichi_sicurezza as $incarico)
                    <li>{{ $incarico->nome  }}   </li>
                @endforeach
            </ul>

        </div>

    </div>



    <br>
    <hr>
    <div class="row">
        <div class="col-sm-12">


            <table class="table table-striped">

                <thead>  <tr>
                    <th></th>
                    <th></th>
                    <th>Corso</th>
                    <th align="center">Data conseguimento</th>
                    <th></th>

                </tr>
                </thead>
                <tbody>
                @foreach($datiRecuperati->_registro_formazione as $corso)
                    <tr>
                        <td @if( $corso->data_superamento )class="success" @endif></td>
                        <td align="center">@if( $corso->_corsi->tipo == 'S' ) <i class="fa fa- fa-shield  fa-2x"> </i> @endif</td>
                        <td>{{ strtoupper($corso->_corsi->titolo) }}   </td>
                        <td align="center">
                            @if($corso->esonerato == 1)
                                {{ $corso->description }}
                            @else
                                {{ $corso->data_superamento }}
                            @endif

                        </td>
                        <td>
                            <a class="" href="#{{$corso->corso_id}}" title="Dettaglio corso" onclick="showDetailCorso({{$corso->corso_id}})">
                                <i class="fa fa-eye fa-2x"></i></a>

                            <a data-toggle="modal"
                               data-target="#cambiaData"
                               data-user_id="{{$datiRecuperati->id}}"
                               data-corso_id="{{$corso->corso_id}}"
                               data-data_superamento="{{$corso->data_superamento}}"
                               class="open_set_data_superamento"
                               href=""
                               {{--href="/registro_formazione/{{$datiRecuperati->id}}-{{$corso->corso_id}}/edit"--}}
                               title="riscatta corso"
                            >
                                <i class="fa fa-calendar-check-o fa-2x"></i>
                            </a>
                        </td>
                    </tr>


                    <tr id="corso{{$corso->corso_id}}" class="dettagliocorso hide">
                        <td colspan="5">
                            <span  class="">
                                <dl class="dl-horizontal">
                                    <dt>Programma</dt>
                                    <dd>{{ Helper::view_dd_if($corso->_corsi->programma) }} </dd>

                                    <dt>Durata</dt>
                                    <dd>{{ Helper::view_dd_if($corso->_corsi->durata) }} ore </dd>

                                    <dt>Aula</dt>
                                    <dd>
                                        Ci sono  {{ $corso->_corsi->_sessioni()->count() }} sessioni relative a questo corso.
                                    </dd>

                                    <dt>Fad</dt>
                                    <dd>{{ Helper::view_dd_if($corso->_corsi->fad) }} </dd>

                                    <dt>Validita</dt>
                                    <dd>{{ Helper::view_dd_if($corso->_corsi->validita) }} </dd>
                                </dl>
                            </span>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>

    @stop


            <!-- Modal -->
    <div class="modal fade" id="cambiaData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Imposta la data di superamento</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('data_superamento', 'Giorno conseguimento attestato :') }}
                                {{ Form::text('data_superamento',  null , ['class' => 'form-control', 'readonly'=>'readonly']) }}
                            </div>

                            {{ Form::hidden('corso_id', null , ['class' => 'form-control', 'hidden'=>'hidden', 'id'=>'corso_id', 'name'=>'corso_id']) }}
                            {{ Form::hidden('user_id', null , ['class' => 'form-control', 'hidden'=>'hidden', 'id'=>'user_id', 'name'=>'user_id']) }}

                        </div>

                    </div>

                </div>
                <div class="modal-footer">


                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                    <button type="button" id="cancella_data_superamento" name="cancella_data_superamento" class="btn btn-primary">Cancella data</button>
                    <button type="button" id="salva_data_superamento" name="salva_data_superamento" class="btn btn-primary">Salva</button>
                </div>
            </div>
        </div>
    </div>



@section('script')
    @parent
    <script type="text/javascript">

        $(document).on("click", ".open_set_data_superamento", function () {
            var user_id = $(this).data('user_id');
            var corso_id = $(this).data('corso_id');
            var data_superamento = $(this).data('data_superamento');

            $("#user_id").val( user_id );
            $("#corso_id").val( corso_id );
            $("#data_superamento").val( data_superamento );
        });

        $( "#data_superamento" ).datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            buttonText: 'Show Date',
            buttonImageOnly: true,
            buttonImage: "/images/calendar.gif"
        });

        $("#salva_data_superamento").click(function () {
            $.post("/set_data_superamento", {
                user_id: $('#user_id').val(),
                corso_id: $('#corso_id').val(),
                data_superamento: $('#data_superamento').val(),
                _token: "{{ csrf_token() }}"
            }).done(function(data){
                if(data)
                    location.reload();
            });
        });

        $("#cancella_data_superamento").click(function () {
            $.post("/set_data_superamento", {
                user_id: $('#user_id').val(),
                corso_id: $('#corso_id').val(),
                data_superamento: null,
                _token: "{{ csrf_token() }}"
            }).done(function(data){
                if(data)
                    location.reload();
            });
        });

    </script>
@stop
