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
                    <th> </th>
                </tr>
                </thead>
                <tbody>

                @foreach($aule as $single)

                    <tr>

                        @if($single->fad)
                            <td>{{ $single->descrizione}}</td>
                            <td>{{ $single->indirizzo}}</td>
                            <td>illimitati </td>

                        @else
                            <td>{{ $single->descrizione}}</td>
                            <td>{{ $single->indirizzo}}</td>
                            <td>{{ $single->posti}}</td>
                        @endif

                        <td>
                            {{ Form::open(array('url' => 'aule/' . $single->id .'/edit')) }}
                            {{ Form::hidden('_method', 'GET') }}
                            {{ Form::button('<i class="fa fa-pencil" aria-hidden="true"></i>', array('class' => 'btn btn-xs btn-tanit' , 'type' => 'submit')) }}
                            {{ Form::close() }}
                        </td>

                        <td>
                            {{ Form::open(array('url' => 'aule/' . $single->id )) }}
                            {{ Form::hidden('_method', 'DELETE') }}
                            {{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', array('class' => 'btn btn-xs btn-danger' , 'type' => 'submit')) }}
                            {{ Form::close() }}
                        </td>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop