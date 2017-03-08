@extends('cache.index')

@section('page_heading','Elenco Mansioni')
@section('body')

    <div class="row">
        <div class="col-sm-12">


            <table class="table table-striped">

                <thead>  <tr>
                    <th>Nome</th>
                    <th>Settore</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>



                @foreach($mansioni as $single)

                    <tr>
                        <td>{{ $single->nome}}</td>
                        <td>{{ $single->_settore['settore']}}</td>
                        <td>
                                <a class="btn btn-warning btn-xs "   href="/mansioni/{{$single->id}}/edit">modifica</a>

                        </td>
                    </tr>

                @endforeach

                </tbody>


            </table>
        </div>
    </div>




@stop