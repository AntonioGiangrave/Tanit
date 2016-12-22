@extends('cache.index')

@section('page_heading','Elenco societa')
@section('body')

    <div class="row">
        <div class="col-sm-12">






            <table class="table table-striped">

                <thead>  <tr>
                    <th>Ragione Sociale</th>
                    <th>Partita IVA</th>
                    <th>Email</th>
                    <th>Codice Ateco</th>

                    <th>Tot Dipendenti </th>
                </tr>
                </thead>
                <tbody>



                @foreach($societa as $single)

                    <tr>
                        <td>{{ $single->ragione_sociale }}</td>
                        <td>{{ $single->piva }}</td>
                        <td>{{ $single->email }}</td>
                        <td>
                            @if($single->ateco_id)
                                {{ $single->ateco->codice }}
                            @endif
                        </td>



                        <td align="center"><b>{{$single->user->count()}}</b></td>

                        <td>
                            @role(['admin' ,'superuser' , 'gestoremultiplo' ,'azienda'])
                            <a class="btn btn-warning btn-xs "   href="/societa/{{$single->id}}/edit">modifica</a>
                            @endrole
                        </td>
                    </tr>

                @endforeach

                </tbody>


            </table>
        </div>
    </div>




@stop