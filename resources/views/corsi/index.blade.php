@extends('cache.index')

@section('page_heading','Elenco Corsi')
@section('body')

    <div class="row">
        <div class="col-sm-12">


            <div class="push-right">
                <a class="btn btn-warning btn-xs "   href="/corsi/create"><i class="fa fa-plus-square fa-2x"></i> Nuovo corso</a>
            </div>



            <table class="table table-striped">

                <thead>  <tr>
                    <th>Titolo</th>
                    <th>Durata</th>
                    <th>Aula</th>
                    <th>FAD</th>
                    <th>CFP</th>
                    <th>Validita</th>
                    <th>Proprietario</th>

                    <th> </th>
                </tr>
                </thead>
                <tbody>

                <?php $canedit = Auth::user()->hasAnyGroups('admin'); ?>

                @foreach($corsi as $single)

                    <tr>
                        <td>{{ $single->titolo}}</td>
                        <td>{{ $single->durata }}</td>
                        <td> @if( $single->aula ) <span title="{{ $single->_aula->descrizione ." - ".$single->_aula->indirizzo }}"><i class="fa fa-check"></i></span> @endif </td>
                        <td> @if( $single->fad ) <span title="{{ $single->_fad->descrizione ." - ".$single->_fad->indirizzo }}"><i class="fa fa-check"></i></span> @endif </td>
                        <td> @if( $single->cfp ) <i class="fa fa-check"></i> @endif </td>
                        <td>{{ $single->validita}}</td>
                        <td>{{ $single->proprietario['ragione_sociale'] }} </td>

                        <td>
                            @if($canedit)
                                <a class="btn btn-warning btn-xs "   href="/corsi/{{$single->id}}/edit">modifica</a>

                            @endif
                        </td>
                    </tr>

                @endforeach

                </tbody>


            </table>
        </div>
    </div>




@stop