@extends('cache.index')


@section('body')



    @if(Auth::user()->hasAnyGroups('user'))

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
    @endif


    <div class="clearfix"></div>
    <div class="clearfix"></div>

    @if(Auth::user()->hasAnyGroups('azienda'))


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

    @endif

@stop
