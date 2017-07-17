@extends('cache.index')

@section('page_heading')

    Attivazione account

@stop
@section('body')


    <div class="col-xs-4 col-xs-offset-4">
        <div class="text-center">

            {{
            Form::open(['url' =>'users/attivazione'])
            }}

            <div class="row">

                <div class="form-group">
                    {{ Form::label('attivazione', 'Codice di attivazione:') }}
                    {{ Form::text('attivazione', null, ['class' => 'form-control ']) }}
                </div>

            </div>

            <div class="row">
                <div class="text-center">

                    {{ Form::button('<i class="fa fa-save"></i> Conferma', ['class' => 'btn btn-tanit btn-xs', 'type'=>'submit', 'type'=>'submit']) }}
                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
@stop



