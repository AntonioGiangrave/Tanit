@extends('cache.index')

@section('page_heading','Formazione fad')
@section('body')

    <div class="row">
        <div class="col-sm-12">


            <table class="table table-striped ">

                <thead>  <tr>
                    <th>Descrizione</th>
                    <th>Indirizzo</th>

                    <th> </th>
                </tr>
                </thead>
                <tbody>



                @foreach($fad as $single)

                    <tr>
                        <td>{{ $single->descrizione}}</td>
                        <td>{{ $single->indirizzo}}</td>
                        <td>
                            @role(['admin', 'superuser'])
                                <a class="btn btn-warning btn-xs disabled  "   href="/ateco/{{$single->id}}/edit">modifica</a>
                            @endrole
                        </td>
                    </tr>

                @endforeach

                </tbody>


            </table>
        </div>
    </div>




@stop