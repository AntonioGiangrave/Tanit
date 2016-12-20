@extends('layouts.dashboard')
@section('page_heading','Dashboard')
@section('section')

        <!-- /.row -->
<div class="col-sm-12">

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-4">
            @section ('pane2_panel_title', 'Assenze di oggi')
            @section ('pane2_panel_body')
                <ul class="timeline">
                    <?php $inverted = false; ?>
                    @foreach($assenze as $obj)
                        <?php $inverted = !$inverted; ?>
                        @include('widgets.timelineelement',array('obj' =>  $obj , 'inverted' => $inverted));
                    @endforeach
                </ul>
            @endsection
            @include('widgets.panel', array('header'=>true, 'as'=>'pane2'))
        </div>


        <div class="col-lg-4">
            @section ('pane3_panel_title', 'Assenze di domani')
            @section ('pane3_panel_body')
                <ul class="timeline">
                    <?php $inverted = false; ?>
                    @foreach($assenze_domani as $obj)
                        <?php $inverted = !$inverted; ?>
                        @include('widgets.timelineelement',array('obj' =>  $obj , 'inverted' => $inverted));
                    @endforeach
                </ul>
            @endsection
            @include('widgets.panel', array('header'=>true, 'as'=>'pane3'))
        </div>




        <div class="col-md-4">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">Ultime commesse</div>
                            <div></div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">

                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>

                        <div class="list-group">
                        @foreach($ultime_commesse as $obj)

                                <a href="#" class="list-group-item">
                                    <i class="fa  fa-dribbble  fa-fw  fa-x3"></i>[{{$obj->protocollo}}] {{$obj->oggetto}}
                                    <span class="pull-right text-muted small"><em>{{$obj->clienti->nome}}</em>
                                    </span>
                                </a>

                        @endforeach
                    </div>
                </a>
            </div>
        </div>




        <!-- /.col-lg-8 -->


        <!-- /.col-lg-4 -->
    </div>
</div>
@stop
