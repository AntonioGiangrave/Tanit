<div class="row">
    <div class="col-sm-12">
        <table class="table table-striped">
            <thead>  <tr>
                <th>Cognome</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Avanzamento formazione</th>
            </tr>
            </thead>
            <tbody>



            @foreach($utentiSocieta as $dip)
                <tr>
                    <td>{{ $dip->cognome }}</td>
                    <td>{{ $dip->nome }}</td>
                    <td>{{ $dip->email }}</td>

                    <td>

                        <div class="progress">
                            <div class="progress-bar"
                                 role="progressbar"
                                 aria-valuenow="{{$dip->_avanzamento_formazione->count() }}"
                                 aria-valuemin="0"
                                 aria-valuemax="{{$dip->_registro_formazione->count() }}"
                                 style="width: {{ round($dip->_avanzamento_formazione->count()/$dip->_registro_formazione->count()*100) }}%;">
                                {{ round($dip->_avanzamento_formazione->count()/$dip->_registro_formazione->count()*100) . '%' }}
                            </div>
                        </div>

                    </td>
                    <td>

                        @role(['admin', 'azienda'])
                            <a class="btn btn-warning btn-xs" href="/usersformazione/{{$dip->id}}/edit"><i class="fa fa-pencil"></i></a>
                        @endrole

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
