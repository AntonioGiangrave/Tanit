@extends('cache.index')

@section('page_heading','Gestione personale da formare')

@section('action_button')

    @role(['admin', 'azienda'])
    @if($societa_id)
        <a class="btn btn-tanit" href="/users?societa_id={{$societa_id}}"> Monitora la formazione dei dipendenti </a>
    @else
        <a class="btn btn-tanit" href="/users"> Monitora la formazione dei dipendenti </a>
    @endif
    @endrole

@stop

@section('body')


    @role((['admin', 'azienda']))
    {{ Form::open(array('url' => '/registro_formazione', 'action'=>'index' , 'method' => 'get')) }}
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


    <div class="row">
        <div class="col-sm-12">

            <table class="table table-striped">
                <thead>
                <tr>
                    <th></th>
                    <th>Corso</th>
                    <th class="text-center">Utenti</th>
                    <th class="text-center">Sessioni attive</th>

                    <th></th>
                </tr>
                </thead>
                <tbody>

                @foreach($corsi as $corso)

                    <tr>

                        <td align="center">@if( $corso->_corsi->tipo == 'S' ) <i class="fa fa- fa-shield  fa-2x"> </i> @endif</td>


                        <td>{{ $corso->_corsi->titolo }}</td>
                        <td class="text-center">{{ $corso->total }}</td>

                        <td class="text-center">{{ $corso->_corsi->_sessioni()->count()}}</td>

                        <td><a title="Gestisci" href="/registro_formazione/{{$corso->_corsi->id}}/edit"><i class="fa fa-random "></i></a></td>
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

