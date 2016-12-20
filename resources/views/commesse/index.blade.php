@extends('layouts.dashboard')
@section('page_heading','Commesse')


@section('section')

    <div class="row">
        <div class="col-sm-8">
            <table class="table table-striped table-condensed">
                <thead>  <tr>
                    <th>Protocollo</th>
                    <th>Cliente</th>
                    <th>Oggetto</th>
                    <th>Totale ore</th>
                </tr>
                </thead>
                <tbody>

                <?php $canedit = Auth::user()->hasAnyGroups('Admin'); ?>
                @foreach($data as $val)
                    <tr>
                        <td>{{ $val->commessa->protocollo}}</td>
                        <td>{{ $val->commessa->clienti->nome}}</td>
                        <td>{{ $val->commessa->oggetto}}</td>
                        <td>{{ number_format($val->tot, 0) }}</td>
                        <td>
                            @if($canedit)
                                <a class="btn btn-warning" href="commesse/{{$val->id}}/edit">modifica</a>
                            @endif

                            @include('widgets.button', array('value'=>'Dettagli', 'class'=>'info dettagli' , 'id' => $val->commessa->id ))


                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
            {{ $data->render() }}
        </div>

        <div class="col-sm-4">


            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Filtri ricerca</div>

                <div class="panel-body">

                    {{ Form::open(['method'=>'GET','url'=>'commesse','class'=>'','role'=>'search'])  }}
                    {{ Form::text('search', null, ['class' => 'form-control' , 'placeholder' => 'Ricerca libera']) }}
                    {{ Form::text('from', null, ['class' => 'form-control data', 'id' =>'from', 'placeholder' => 'dal...']) }}
                    {{ Form::text('to', null, ['class' => 'form-control data', 'id' =>'to', 'placeholder' => 'al...']) }}

                    {{ Form::submit('cerca', ['class' => 'btn btn-success']) }}


                    {{ Form::close()  }}





                </div>

            </div>



            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Info commessa</div>

                <div class="panel-body">

                    <h5>Id: <span id="idcommessa"></span></h5>
                    <h5>Stato : <span id="stato"></span></h5>
                    <h4>Referente : <span id="referente"></span></h4>

                </div>

            </div>






            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Utenti della commessa</div>

                <!-- Table -->
                <table class="table utenti  ">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Tot ore</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>



    </div>
@stop


@section('script')
    <script type="text/javascript">
        $(document).ready(function ()
        {

            $( ".data" ).datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                constrainInput: true
            });



            $( ".dettagli" ).click(function(){
                var btnId = $(this).attr('id');
                $('.td_dettagli[data-id=' + btnId + ']').toggle();

                $.get( APP_URL+"/userPerCommessa", { id: btnId} )
                        .done(function( data ) {


                            //utenti
                            var trHTML = '';
                            $.each(data.utenti, function (i, item) {
                                trHTML += '<tr><td>' + item.nome + '</td><td>' + item.cognome + '</td><td>' + item.tot + '</td></tr>';
                            });
                            $('.utenti > tbody').html("");
                            $('.utenti tbody').html(trHTML);


                            //stato
                            $('#stato').html(data.stato);

                            //referente
                            $('#referente').html(data.referente);

                            //idcommessa
                            $('#idcommessa').html(data.id);

                        },'json');
            });


        });
    </script>
    </div>

@endsection
