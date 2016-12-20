<div class="pup">

    <div class="panel panel-default"
         style="
                 min-height: {{$pup->n_ore * 80  }};
                 background: {{ $pup->commessa->colore }}" >
        <div class="panel-body">

            {{ $pup->commessa->protocollo }} ({{ $pup->n_ore }} ore)

            <a href="calendario/{{ $pup->id}}/destroy" data-method="delete" data-token="{{ csrf_token() }}">
                <span class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></span>
            </a>
            <br>
            {{ $pup->commessa->oggetto }}


        </div>
    </div>


</div>