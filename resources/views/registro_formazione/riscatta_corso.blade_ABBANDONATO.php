@extends('cache.index')

@section('page_heading','Utenti')
@section('body')

    <div class="row">
        <div class="col-sm-12">


            {{ Form::model($elemento, ['method' => 'put', 'url' =>'mansioni/'. $elemento['id']]) }}


            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-5">

                        <div class="form-group">
                            {{ Form::label('data_superamento', 'Data superamento:') }}
                            {{ Form::date('nome', $elemento['data_superamento'], ['class' => 'form-control']) }}
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