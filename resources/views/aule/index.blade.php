@extends('cache.index')

@section('page_heading','Aule e Fad')

@section('action_button')
    @role('admin')
    <div class="push-right">
        <a class="btn btn-tanit btn-xs "   href="/aule/create"><i class="fa fa-plus-square "></i>Nuova Aula/Fad</a>
    </div>
    @endrole
@stop

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
                    @if($single->fad)
                        <tr>
                            <td>{{ $single->descrizione}}</td>
                            <td>{{ $single->indirizzo}}</td>
                            <td>illimitati </td>
                            <td></td>
                        </tr>
                    @else
                        <tr>
                            <td>{{ $single->descrizione}}</td>
                            <td>{{ $single->indirizzo}}</td>
                            <td>{{ $single->posti}}</td>
                            <td>

                                {{--@role(['admin'])--}}
                                {{--<a class="btn btn-tanit btn-xs disabled  "   href="/ateco/{{$single->id}}/edit">modifica </a>--}}
                                {{--@endrole--}}
                            </td>
                        </tr>

                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop