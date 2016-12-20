<li class=" @if($inverted  == true)  timeline-inverted  @endif ">
	<div class="timeline-badge warning"><i class="fa fa-bullhorn "></i>
	</div>
	<div class="timeline-panel">
		<div class="timeline-heading">
			<h4 class="timeline-title">{{ $obj->user->nome ." ". $obj->user->cognome }}</h4>
			<small><i class="fa fa-clock-o"> {{ $obj->giorno  }}</i> </small>
		</div>
		<div class="timeline-body">
			Non è in ufficio per {{ $obj->tipoassenza->tipo }}
			per {{ $obj->n_ore  }} ore
		</div>
	</div>

</li>