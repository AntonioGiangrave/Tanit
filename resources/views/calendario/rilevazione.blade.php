@extends('layouts.dashboard')
@section('page_heading','Rilevazioni per stipendi')


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

                @foreach($rilevazione as $single)




                    <tr >
                        <td>{{ $single->user->cognome}}</td>
                        <td>{{ $single->user->nome}}</td>
                        <td>{{ $single->commessa->oggetto}}</td>
                        <td>{{ $single->tipoassenza->tipo   }}</td>
                        <td>{{ $single->giorno}}</td>
                        <td>{{ $single->n_ore}}</td>
                        <td>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>



            {{Form::open(['url' =>'do_rileva'] ) }}
            {{ Form::submit('RILEVA VOCI', ['class' => 'btn btn-warning btn-lg btn-block']) }}
            {{ Form::close() }}



        </div>
    </div>




@stop