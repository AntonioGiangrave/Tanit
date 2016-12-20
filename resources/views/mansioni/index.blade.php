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

                <?php $canedit = Auth::user()->hasAnyGroups('admin'); ?>

                @foreach($mansioni as $single)

                    <tr>
                        <td>{{ $single->nome}}</td>
                        <td>{{ $single->_settore['settore']}}</td>
                        <td>
                            @if($canedit)
                                <a class="btn btn-warning btn-xs "   href="/mansioni/{{$single->id}}/edit">modifica</a>

                            @endif
                        </td>
                    </tr>

                @endforeach

                </tbody>


            </table>
        </div>
    </div>




@stop