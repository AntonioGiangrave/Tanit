@extends('cache.index')

@section('page_heading','Nuova aula')
@section('body')

    {{
           Form::open(['url' =>'aule'])
    }}


    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-5">
                <div class="form-group">
                    {{ Form::label('descrizione', 'Descrizione:') }}
                    {{ Form::text('descrizione', null, ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('indirizzo', 'Indirizzo:') }}
                    {{ Form::text('indirizzo',null,  ['class' => 'form-control']) }}

                </div>

                <div class="form-group">
                    {{ Form::label('fad', 'Ambiente fad:') }}
                    {{ Form::select('fad',array(0=>'No', 1=>'Si'),null,   ['class' => 'form-control']) }}

                </div>

                <div class="form-group">
                    {{ Form::label('posti', 'Posti:') }}
                    {{ Form::text('posti',null,  ['class' => 'form-control']) }}

                </div>

                <div class="pull-right">
                    {{ Form::submit('Salva', ['class' => 'btn btn-success']) }}
                    {{ Form::close() }}
                </div>

            </div>

            </div>
        </div>
    </div>


@stop
