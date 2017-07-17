@extends('cache.index')

@section('page_heading','Elenco Corsi')

@section('action_button')
    <div class="push-right">
        <a class="btn btn-tanit btn-xs "   href="/corsi/create"><i class="fa fa-plus-square "></i> Nuovo corso</a>
    </div>
@stop


@section('body')

    <div class="row">
        <div class="col-sm-12">


            <table class="table table-striped">

                <thead>  <tr>
                    <th>Titolo</th>
                    <th>Durata</th>
                    <th>Tipo</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>

                @foreach($corsi as $single)

                    <tr>
                        <td>{{ $single->titolo}}</td>
                        <td>{{ $single->durata }}</td>

                        @if($single->tipo == 'R')
                            <td> <span  class="badge green" >{{$single->tipo}}</span> </td>
                        @endif

                        @if($single->tipo == 'S')
                            <td> <span  class="badge orange" >{{$single->tipo}}</span> </td>
                        @endif


                        <td>
                            <a class="btn btn-tanit btn-xs "   href="/corsi/{{$single->id}}/edit">modifica</a>
                        </td>
                    </tr>

                @endforeach

                </tbody>


            </table>
        </div>
    </div>




@stop


@section('help')
    Questi sono tutti i corsi attualmente disponibili sulla piattaforma. Contatta il gestore per richiederne di altri.
@stop