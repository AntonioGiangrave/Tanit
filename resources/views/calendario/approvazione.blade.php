@extends('layouts.dashboard')
@section('page_heading','Approvazioni')


@section('section')


    <div class="row">
        <div class="col-sm-12">


            <table class="table table-striped">

                <thead>  <tr>
                    <th>Cognome</th>
                    <th>Nome</th>
                    <th>Commessa</th>
                    <th>Azione</th>
                    <th>Giorno</th>
                    <th>Num ore</th>
                    <th></th>

                    <th> </th>
                </tr>
                </thead>
                <tbody>

                @foreach($approvazioni as $single)

                    <tr>
                        <td>{{ $single->user->cognome}}</td>
                        <td>{{ $single->user->nome}}</td>
                        <td>{{ $single->commessa->oggetto}}</td>
                        <td>{{ $single->tipoassenza->tipo   }}</td>
                        <td>{{ $single->giorno}}</td>
                        <td>{{ $single->n_ore}}</td>
                        <td>
                            @if($single->user->referente_id == Auth::user()->id)

                                {{Form::open(['method' => 'put', 'url' =>'calendario/'.$single->id] ) }}
                                {{ Form::submit('Approva', ['class' => 'btn btn-success btn-xs']) }}
                                {{ Form::close() }}

                                {{Form::open(['method' => 'delete', 'url' =>'calendario/'.$single->id] ) }}
                                {{ Form::submit('Rifiuta', ['class' => 'btn btn-danger btn-xs']) }}
                                {{ Form::close() }}

                            @endif
                        </td>


                    </tr>

                @endforeach

                </tbody>


            </table>
        </div>
    </div>




@stop