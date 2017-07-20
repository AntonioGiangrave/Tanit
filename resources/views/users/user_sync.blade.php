@extends('cache.index')

@section('page_heading')
    Allineamento formazione per: <br>
    @foreach($elencosocieta  as $societa)
        <a href="/users?societa_id={{$societa->id}}">{{ $societa->ragione_sociale }}</a> <br>

    @endforeach
@stop


@section('action_button')

    @role((['admin', 'gestoremultiplo' , 'superuser', 'azienda']))
    {{ Form::submit('AVVIA ALLINEAMENTO FORMAZIONE', ['class' => 'btn btn-tanit btn-xs' , 'id'=>'inizia']) }}
    @endrole
@stop

@section('body')
    <div class="row">
        <div id="progress" class="col-sm-12 ">
            <div class="progress progress-tall">
                <div
                        class="progress-bar progress-bar-success progress-bar-striped"
                        role="progressbar"
                        aria-valuenow=""
                        aria-valuemin="0"
                        aria-valuemax="100"
                        style="width: 0%;">
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped">

                <thead>  <tr>
                    <th>Cognome</th>
                    <th>Nome</th>
                    <th>Completamento</th>
                </tr>
                </thead>
                <tbody>

                @foreach($users as $dip)
                    <tr>
                        <td>{{ $dip->cognome }}</td>
                        <td>{{ $dip->nome }}</td>
                        <td>
                            <div id="id{{ $dip->id }}">
                                <i class=" " aria-hidden="true"></i>
                            </div>
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
        var utenti;
        utenti = {{  $userslist  }};
        quantita = utenti.length;
        var i = 1;
        $('.progress-bar').attr('aria-valuemax', quantita);

        $('#inizia').click(function(){
            sync_user(utenti[0]);
        })

        function sync_user(id)
        {
            $.get("/sync_utente/"+id)
                    .done(function(data){
                        if(data== 'true')
                        {
                            width = Math.floor((i*100)/quantita);
                            $('.progress-bar').css('width', width +'%');
//                            $('.progress-bar').html( width +'%');
                            $('.progress-bar').attr('aria-valuenow', i);
                            $('#id'+id+ ' i').removeClass().addClass('fa fa-check fa-2x');

                            utenti.shift();
                            i++;
                            if(utenti[0])
                                sync_user(utenti[0]);
                            else
                            {
                                $('#inizia').hide();
                                alert("Allineamento completato correttamente");
                            }
                        }
                    });
        }
    </script>
@stop
