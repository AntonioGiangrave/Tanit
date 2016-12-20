<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <div class="form-group">
                {{ Form::label('Albo professionale') }}<br />
                {{ Form::select('albi_professionali[]', $lista_albi, $datiRecuperati->_albi_professionali->lists('id')->toArray(),
                    ['class' => 'form-control multiselect',
                    'multiple' => 'multiple']) }}
            </div>

        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <div class="form-group">
                {{ Form::label('Mansioni') }}<br />
                {{ Form::select('mansioni[]', $lista_mansioni, $datiRecuperati->_mansioni->lists('id')->toArray(),
                    ['row' => '20',
                    'class' => 'form-control multiselect',
                    'multiple' => 'multiple']) }}
            </div>

        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <div class="form-group">
                {{ Form::label('Incarichi sicurezza') }}<br />
                {{ Form::select('incarichi_sicurezza[]', $lista_incarichi_sicurezza, $datiRecuperati->_incarichi_sicurezza->lists('id')->toArray(),
                    ['class' => 'form-control multiselect',
                    'multiple' => 'multiple']) }}
            </div>

        </div>
    </div>
</div>

