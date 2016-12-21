@extends('cache.index')

@section('page_heading','Utenti')
@section('body')

<div class="row">
    <div class="col-sm-12">


        <table class="table table-striped">

            <thead>  <tr>  
                    <th>Cognome</th>
                    <th>Nome</th>
                    <th>Email</th>  
                    <th>Societa</th>  
                    <th> </th>  
                </tr>  
            </thead> 
            <tbody>


                @foreach($data as $dip) 

                <tr> 
                    <td>{{ $dip->cognome }}</td>
                    <td>{{ $dip->nome }}</td>
                    <td>{{ $dip->email }}</td>
                    <td>{{ $dip->societa->ragione_sociale }}</td>
                    <td>
                        @role(['admin', 'superuser', 'gestoremultiplo' ])
                            <a class="btn btn-warning btn-xs" href="users/{{$dip->id}}/edit" title="modfica"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-warning btn-xs" href="usersformazione/{{$dip->id}}" title="formazione"><i class="fa fa-mortar-board"></i></a>
                        @endrole
                    </td>
                </tr>  

                @endforeach 

            </tbody> 


        </table>
    </div>
</div>




@stop