@extends('cache.index')

@section('page_heading','Aule formazione')
@section('body')

    <div class="row">
        <div class="col-sm-12">


            <table class="table table-striped ">

                <thead>  <tr>
                    <th>Descrizione</th>
                    <th>Indirizzo</th>
                    <th>Posti</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>



                @foreach($aule as $single)

                    <tr>
                        <td>{{ $single->descrizione}}</td>
                        <td>{{ $single->indirizzo}}</td>
                        <td>{{ $single->posti}}</td>
                        <td>

                            @role(['admin', 'superuser'])
                                <a class="btn btn-tanit btn-xs disabled  "   href="/ateco/{{$single->id}}/edit">modifica</a>
                            @endrole
                        </td>
                    </tr>

                @endforeach

                </tbody>


            </table>
        </div>
    </div>




@stop