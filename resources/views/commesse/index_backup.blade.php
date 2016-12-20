@extends('layouts.dashboard')
@section('page_heading','Commesse')


@section('section')


    @if(count($errors->all()) > 0)
        <div class="alert alert-danger" role="alert">
            <p><b>OOOPS!</b></p>
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{$e}}</li>
                @endforeach
            </ul>
        </div>
    @endif



    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped">
                <thead>  <tr>
                    <th>id</th>
                    <th>Protocollo</th>
                    <th>Cliente</th>
                    <th>Oggetto</th>
                    <th>Stato</th>
                    <th>Referente</th>
                </tr>
                </thead>
                <tbody>

                <?php $canedit = Auth::user()->hasAnyGroups('Admin'); ?>
                @foreach($data as $val)
                    <tr>
                        <td>{{ $val->id }}</td>
                        <td>{{ $val->commessa->protocollo}}</td>
                        <td>{{ $val->commessa->clienti->nome}}</td>
                        <td>{{ $val->commessa->oggetto}}</td>
                        <td>{{ $val->commessa->stato}}</td>
                        <td>{{ $val->commessa->referente}}</td>
                        <td>{{ $val->tot}}</td>


                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop