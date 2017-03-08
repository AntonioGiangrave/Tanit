@extends('cache.index')

@section('page_heading')
    @role((['admin', 'gestoremultiplo' , 'superuser']))
    {{ Form::open(array('url' => '/users', 'action'=>'index' , 'method' => 'get')) }}
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::label('societa_id', 'Azienda:') }}
                {{ Form::select('societa_id', $societa, $societa_id,['class' => 'form-control']) }}
            </div>
        </div>
    </div>
    {{Form::close()}}

    @endrole

@stop

@section('action_button')
    @role((['admin', 'gestoremultiplo' , 'superuser', 'azienda']))
    <a href="/sync_azienda/{{$societa_id}}"><i class="fa fa-refresh">Sincronizza formazione</i></a>
    @endrole
@stop


@section('body')





    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped">

                <thead>  <tr>
                    <th>Cognome</th>
                    <th>Nome</th>
                    <th>Classe</th>
                    <th>Avanzamento formazione</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>


                @foreach($data as $dip)

                    @if($dip->_registro_formazione->count()==0)
                        <?php $percentuale=0; ?>
                    @else
                        <?php $percentuale= round($dip->_avanzamento_formazione->count()/$dip->_registro_formazione->count()*100); ?>
                    @endif

                    <tr>

                        <td>{{ $dip->cognome }}</td>
                        <td>{{ $dip->nome }}</td>
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
                                <a href="" class="text-muted " data-toggle="modal" data-target="#myModal"><small><i title="Classe dipendente diversa da classe ATECO azienda" class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i></small></a>
                            @endif
                        </td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar"
                                     role="progressbar"
                                     aria-valuenow="{{$dip->_avanzamento_formazione->count() }}"
                                     aria-valuemin="0"
                                     aria-valuemax="{{$dip->_registro_formazione->count() }}"
                                     style="width: {{ $percentuale }}%;">
                                    {{ $percentuale . '%' }}
                                </div>
                            </div>
                        </td>
                        <td>
                            @role(['admin', 'superuser', 'gestoremultiplo', 'azienda' ])
                            <a class="text-muted" href="users/{{$dip->id}}/edit" title="modfica"><i class="fa fa-pencil fa-2x"></i></a>
                            <a class="text-muted" href="usersformazione/{{$dip->id}}" title="formazione"><i class="fa fa-mortar-board fa-2x"></i></a>
                            @endrole
                        </td>
                    </tr>

                @endforeach

                </tbody>


            </table>
        </div>
    </div>
@stop


@section('script')
    <script type="text/javascript">

        $('#societa_id').on('change', function(e){
            $(this).closest('form').submit();
        });

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