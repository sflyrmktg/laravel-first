<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('Date') !!}
            {!! Form::date('made_at', \Carbon\Carbon::now(), array('placeholder' => 'Date','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('Date of value') !!}
            {!! Form::date('value_at', \Carbon\Carbon::now(), array('placeholder' => 'Date of value','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('Concept') !!}
            {!! Form::text('explanation', null, array('placeholder' => 'Concept','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('Method') !!}
            {!! Form::select('method_id', \App\Method::select(), array('placeholder' => 'Method','class' => 'form-control') ) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('Concept') !!}
            {!! Form::select('concept_id', \App\Concept::select(), array('placeholder' => 'Concept','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('Value') !!}
            {!! Form::text('value', null) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::label('Valid') !!}
            {!! Form::checkbox('isvalid', null) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            {!! Form::submit('Add!',
              array('class'=>'btn btn-primary pull-right')) !!}
        </div>
    </div>
</div>