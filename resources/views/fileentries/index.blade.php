@extends('app')

@section('content')

    {!! Form::open(['url' => 'fileentry/add', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
    <!-- filefield File input -->
    <div class="form-group">
        {!! Form::file('filefield') !!}
    </div>
    <!-- Submit -->
    <div class="form-group">
        {!! Form::submit('upload', ['class' => 'btn btn-primary form-control']) !!}
    </div>
    {!! Form::close() !!}

    <h1>Pictures List</h1>

    <div class="row">
        <ul class="thumbnails">
            @foreach($entries as $entry)
                <div class="col-md-2">
                    <div class="thumbnail">
                       <!-- You can also pass in the wildcard using the url for example: url('fileentry/get/' . $entry->filename) -->
                        <img src="{{route('getentry', $entry->filename)}}" alt="ALT NAME" class="img-responsive" />
                        <div class="caption">
                            <p>{{$entry->original_filename}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </ul>
    </div>
@stop