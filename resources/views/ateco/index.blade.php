@extends('cache.index')

@section('page_heading','Ateco')
@section('body')

    <div class="row">
        <div class="col-sm-12">


            <table class="table table-striped ">

                <thead>  <tr>
                    <th>Codice</th>
                    <th>Descrizione</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>



                @foreach($ateco as $single)

                    <tr>
                        <td>{{ $single->codice}}</td>
                        <td>{{ $single->descrizione}}</td>
                        <td>
                            @role(['admin', 'superuser'])
                                <a class="btn btn-tanit btn-xs "   href="/ateco/{{$single->id}}/edit">modifica</a>

                            @endrole
                        </td>
                    </tr>

                @endforeach

                </tbody>


            </table>
        </div>
    </div>




@stop