@extends('cache.index')


@section('body')



    @role('user')

    <a href="/users/{{ Auth::user()->id }}/edit">
        <div class="boxhome"><i class="fa fa-user fa-5x"></i>
            <h4>  Gestisci il tuo profilo</h4>
        </div>
    </a>
    <a href="/userformazione/{{ Auth::user()->id }}">
        <div class="boxhome"><i class="fa fa-mortar-board fa-5x"></i>
            <h4> Monitora la tua formazione </h4>
        </div>
    </a>
    @endrole


    <div class="clearfix"></div>


    @role('azienda')
    <a href="/societa/{{ Auth::user()->societa->id }}/edit">
        <div class="boxhome"><i class="fa fa-building-o  fa-5x"></i>
            <h4>Gestisci il profilo della tua azienda</h4>
        </div>
    </a>

    <a href="/societa/{{ Auth::user()->societa->id }}/edit">
        <div class="boxhome"><i class="fa fa-users fa-5x"></i>
            <h4>Monitora la formazione dei dipendenti</h4>
        </div>
    </a>

    @endrole

    <div class="clearfix"></div>

    @role(['gestoremultiplo', 'superuser', 'admin'])
    <a href="/societa/">
        <div class="boxhome"><i class="fa fa-building-o  fa-5x"></i>
            <h4>Gestisci un'azienda</h4>
        </div>
    </a>

    <a href="/users/">
        <div class="boxhome"><i class="fa fa-users fa-5x"></i>
            <h4>Monitora i dipendenti</h4>
        </div>
    </a>


    @endrole


@stop
