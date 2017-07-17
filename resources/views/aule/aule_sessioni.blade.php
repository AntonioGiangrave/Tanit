@extends('cache.index')

@section('page_heading','Elenco sessioni')
@section('body')

    <div class="row">
        <div class="col-sm-12">

            @section('action_button')

                <a class="btn btn-tanit btn-xs" href="/aule_sessioni/create"><i class="fa fa-plus-square"></i> Nuova sessione</a>

            @stop
            <table class="table table-striped">
                <thead>  <tr>
                    <th>Descrizione</th>
                    <th>dal</th>
                    <th>al</th>
                    <th>dalle ore</th>
                    <th>alle ore</th>
                    <th>dove</th>
                    <th>prenotazioni</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>


                @foreach($sessioni as $single)
                    @if($single->_aula->fad)
                        <tr>
                            <td>{{ $single->_corso->titolo }}</td>
                            <td colspan="4"> SESSIONE FAD</td>
                            <td>{{ $single->_aula->descrizione ." - ".$single->_aula->indirizzo }}</td>
                            <td>{{ $single->_posti_occupati()->count() }}</td>
                            {{--<td> - </td>--}}

                            <td>
                                @role(['admin' , 'superuser'])
                                <a class="btn btn-tanit btn-xs "   href="/aule_sessioni/{{$single->id}}/edit">modifica</a>
                                @endrole
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td>{{ $single->_corso->titolo }}</td>
                            <td>{{ $single->dal}}</td>
                            <td>{{ $single->al}}</td>
                            <td>{{ $single->orario_dalle}}</td>
                            <td>{{ $single->orario_alle}}</td>
                            <td>{{ $single->_aula->descrizione ." - ".$single->_aula->indirizzo }}</td>
                            <td>{{ $single->_posti_occupati()->count() }}</td>

                            <td>
                                @role(['admin' , 'superuser'])
                                <a class="btn btn-tanit btn-xs "   href="/aule_sessioni/{{$single->id}}/edit">modifica</a>
                                @endrole
                            </td>
                        </tr>
                    @endif
                @endforeach

                </tbody>


            </table>
        </div>
    </div>




@stop