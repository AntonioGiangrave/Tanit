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

                @foreach($items as $item)

                <tr> 
                    <td><span>{{ $item->_user->nome }}</span></td>
                    <td><span title="Durata: {{ $item->_corsi->durata }}">{{ $item->_corsi->titolo}}</span></td>
                    <td>{{ $item->data_superamento}}</td>
                </tr>

                @endforeach 

            </tbody> 
        </table>
    </div>
</div>

@stop