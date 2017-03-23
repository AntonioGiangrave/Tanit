@extends('cache.index')

@section('page_heading','Gestione personale da formare')
@section('body')


    @role((['admin', 'gestoremultiplo' , 'superuser']))
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
                    <th>Corso</th>
                    <th class="text-center">Utenti</th>
                    <th class="text-center">Sessioni attive</th>
                    <th class="text-center">Disponibilità fad</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @foreach($corsi as $corso)

                    <tr>
                        <td>{{ $corso->_corsi->titolo }}</td>
                        <td class="text-center">{{ $corso->total }}</td>

                        <td class="text-center">{{ $corso->_corsi->_sessioni()->count()}}</td>
                        <td class="text-center" >@if(is_null($corso->_corsi->_fad))@else{{ $corso->_corsi->_fad->descrizione}} @endif </td>
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

