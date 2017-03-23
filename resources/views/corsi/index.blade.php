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
                    <th>Aula</th>
                    <th>FAD</th>
                    <th>CFP</th>
                    <th>Validita</th>


                    <th> </th>
                </tr>
                </thead>
                <tbody>

                @foreach($corsi as $single)

                    <tr>
                        <td>{{ $single->titolo}}</td>
                        <td>{{ $single->durata }}</td>
                        <td> @if( $single->aula ) <span title="{{ $single->_aula->descrizione ." - ".$single->_aula->indirizzo }}"><i class="fa fa-check"></i></span> @endif </td>
                        <td> @if( $single->fad ) <span title="{{ $single->_fad->descrizione ." - ".$single->_fad->indirizzo }}"><i class="fa fa-check"></i></span> @endif </td>
                        <td> @if( $single->cfp ) <i class="fa fa-check"></i> @endif </td>
                        <td>{{ $single->validita}}</td>
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