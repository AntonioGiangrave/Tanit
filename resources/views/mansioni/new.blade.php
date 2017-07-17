@extends('cache.index')

@section('page_heading','Crea nuova mansione e attribuisci corsi ')
@section('body')

    {{
           Form::open(['url' =>'mansioni/'])
           }}


    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-5">
                <div class="form-group">
                    {{ Form::label('nome', 'Nome:') }}
                    {{ Form::text('nome', null,   ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('settore_id', 'Settore:') }}
                    {{ Form::select('settore_id',$lista_settori, null,  ['class' => 'form-control']) }}

                </div>

                <div class="pull-right">
                    {{ Form::submit('Salva', ['class' => 'btn btn-tanit']) }}

                </div>

            </div>

            <div class="col-sm-7">
                <div class="form-group filterlist">
                    {{ Form::label('_corsi', 'Corsi da attribuire:') }}
                    <div class="row">
                        <div class="col-sm-4">
                            {{ Form::text('txtSearch',null,  [ 'id'=> 'txtSearch', 'class' => 'form-control', 'placeholder' => 'Filtra']) }}
                        </div>
                        <div class="col-sm-1"></div>
                        <div class="col-sm-3">
                            <a class="btn btn-tanit btn-xs resetfilter" href="#">visualizza tutti</a>
                        </div>
                        <div class="col-sm-3">
                            <a class="btn btn-tanit btn-xs soloselezionati" href="#">visualizza selezionati</a>
                        </div>

                    </div>
                    <hr>

                    {{ Form::select('_corsi[]',$lista_corsi, null,  ['class' => 'form-control, list-group', 'multiple']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>


@stop

@section('action_button')
    {{ Form::open(array('url' => '/mansioni', 'action'=>'index' , 'method' => 'get' )) }}
    {{ Form::submit('Torna a mansioni', ['class' => 'btn btn-tanit btn-xs']) }}
    {{Form::close()}}

@stop


