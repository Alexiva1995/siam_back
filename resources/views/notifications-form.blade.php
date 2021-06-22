@extends('adminlte::page')

@section('title', $title . ' - ' . config('adminlte.brand'))

@section('content_header')
    <div class="row">
        <div class="col">
            <h1 class="m-0 text-dark">{{ $title }}</h1>
        </div>
    </div>
@stop

@section('content')
    <form role="form" method="POST" autocomplete="off" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Español</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="esTitleInput">Título</label>
                            <input name="es_title" value="{{ old('es_title') }}" type="text" class="form-control {{ $errors->get('es_title') ? 'is-invalid' : '' }}" id="esTitleInput">
                            @error('es_title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        <div class="form-group">
                            <label for="esBodyInput">Texto</label>
                            <input name="es_body" value="{{ old('es_body') }}" type="text" class="form-control {{ $errors->get('es_body') ? 'is-invalid' : '' }}" id="esBodyInput">
                            @error('es_body')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                    </div>
                </div>
            </div>
            <div class="col-md">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Inglés</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="enTitleInput">Título</label>
                            <input name="en_title" value="{{ old('en_title') }}" type="text" class="form-control {{ $errors->get('en_title') ? 'is-invalid' : '' }}" id="enTitleInput">
                            @error('en_title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        <div class="form-group">
                            <label for="enBodyInput">Texto</label>
                            <input name="en_body" value="{{ old('en_body') }}" type="text" class="form-control {{ $errors->get('en_body') ? 'is-invalid' : '' }}" id="enBodyInput">
                            @error('en_body')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Ambos idiomas</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Link</label>
                            <select class="form-control" name="link">
                                <option value="">Ninguno</option>
                                @foreach($extra_data['links'] as $key => $group)
                                    <optgroup label="{{ $key }}">
                                        @foreach($group as $link => $name)
                                            <option value="{{ $link }}">{{ $name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div><!--card-body-->
                </div><!--card-->
            </div><!--col-->
        </div><!--row-->
        <div class="row pb-5">
            <div class="col">
                <a class="btn btn-lg btn-danger" href="/notifications">Cancelar</a>
            </div>
            <div class="col text-right">
                <button type="submit" class="btn btn-lg btn-primary">Enviar</button>
            </div>
        </div>
    </form>
@stop
