@extends('cache.index')

@section('page_heading','Gestione personale da formare')

@section('action_button')

    @role(['admin', 'azienda'])
        <a class="btn btn-tanit" href="/users"> Monitora la formazione dei dipendenti </a>
    @endrole

@stop

@section('body')


    @role((['admin', 'azienda']))

    {{ Form::open(array('url' => '/registro_formazione_index',   'method' => 'post')) }}


    @if($societa->count() > 1)
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {{ Form::select('societa[]', $societa, $societa_selezionate,['id'=> 'societa_selezionate', 'class' => '  selectpicker  ', 'multiple']) }}
            </div>
        </div>
    </div>
@endif

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


    </script>

@stop

