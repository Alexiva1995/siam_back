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
        @if ($news)
            <input type="hidden" name="_method" value="PUT">
        @endif
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Español</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="esTitleInput">Título</label>
                                    <input name="es_title" value="{{ old('es_title', optional($news)->es_title) }}" type="text" class="form-control {{ $errors->get('es_title') ? 'is-invalid' : '' }}" id="esTitleInput" placeholder="Ej: Carnavales por todo lo alto">
                                    @error('es_title')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="esCaptionInput">Bajada</label>
                                    <input name="es_caption" value="{{ old('es_caption', optional($news)->es_caption) }}" type="text" class="form-control {{ $errors->get('es_caption') ? 'is-invalid' : '' }}" id="esCaptionInput" placeholder="Ej: 7 Enero / 6 Marzo">
                                    @error('es_caption')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="esDescriptionInput">Descripción breve</label>
                            <input name="es_description" value="{{ old('es_description', optional($news)->es_description) }}" type="text" class="form-control {{ $errors->get('es_description') ? 'is-invalid' : '' }}" id="esDescriptionInput">
                            @error('es_description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        <div class="form-group">
                            <label for="esLongTextInput">Texto</label>
                            <textarea name="es_long_text" class="form-control {{ $errors->get('es_long_text') ? 'is-invalid' : '' }} ckeditor" id="esLongTextInput" rows="5">{{ old('es_long_text', optional($news)->es_long_text) }}</textarea>
                            @error('es_long_text')
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="enTitleInput">Título</label>
                                    <input name="en_title" value="{{ old('en_title', optional($news)->en_title) }}" type="text" class="form-control {{ $errors->get('en_title') ? 'is-invalid' : '' }}" id="enTitleInput" placeholder="Ej: Carnivals in style">
                                    @error('en_title')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="enCaptionInput">Bajada</label>
                                    <input name="en_caption" value="{{ old('en_caption', optional($news)->en_caption) }}" type="text" class="form-control {{ $errors->get('en_caption') ? 'is-invalid' : '' }}" id="enCaptionInput" placeholder="Ej: January 7th / March 6th">
                                    @error('en_caption')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="enDescriptionInput">Descripción breve</label>
                            <input name="en_description" value="{{ old('en_description', optional($news)->en_description) }}" type="text" class="form-control {{ $errors->get('en_description') ? 'is-invalid' : '' }}" id="enDescriptionInput">
                            @error('en_description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        <div class="form-group">
                            <label for="enLongTextInput">Texto</label>
                            <textarea name="en_long_text" class="form-control {{ $errors->get('en_long_text') ? 'is-invalid' : '' }} ckeditor" id="enLongTextInput" rows="5">{{ old('en_long_text', optional($news)->en_long_text) }}</textarea>
                            @error('en_long_text')
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="shareUrlInput">URL Compartir</label>
                                    <input name="share_url" value="{{ old('share_url', optional($news)->share_url) }}" type="text" class="form-control" id="shareUrlInput" placeholder="">
                                    @error('share_url')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div>
                        </div>
                        <div class="form-group {{ !empty($news['image']) ? 'd-none' : '' }}" id="fotoLoader">
                            <label for="inputFile">Foto</label>
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="customFile" multiple>
                                <label class="custom-file-label" for="customFile">Elegir archivo</label>
                            </div>
                            @error('image.*')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        @if (!empty($news['image']))
                        <div class="form-group" on-remove-display="#fotoLoader">
                            <label for="image">Foto</label>
                            <ul class="mailbox-attachments">
                                <li id="{{ $news['image']->hash }}">
                                    <span class="mailbox-attachment-icon has-img"><img src="{{ Storage::url($news['image']->path) }}" alt="Attachment"></span>
                                    <div class="mailbox-attachment-info">
                                        <a href="#" class="mailbox-attachment-name">{{ Str::limit($news['image']->name, 18, $end='...') }}</a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                                            <span>{{ number_format($news['image']->size / 1024, 2) }} KB</span>

                                            <div class="btn-group float-right" role="group" aria-label="Basic example">
                                                <button type="button" 
                                                data-toggle="modal" 
                                                data-target="#modal-remove"
                                                data-title="Atención"
                                                data-body="<p>La foto será eliminada.<br>Esta acción no se puede deshacer. ¿Estás seguro?</p>"
                                                data-callback="callDelete('#{{ $news['image']->hash }}', '/news/{{ $news['id'] }}/image', '{{ csrf_token() }}')"
                                                class="btn btn-default btn-sm float-right"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </div><!--form-group-->
                        @endif
                    </div><!--card-body-->
                </div><!--card-->
            </div><!--col-->
        </div><!--row-->
        <div class="row pb-5">
            <div class="col">
                <a class="btn btn-lg btn-danger" href="/news">Cancelar</a>
            </div>
            <div class="col text-right">
                <button type="submit" class="btn btn-lg btn-primary">{{ $news ? 'Modificar' : 'Agregar' }}</button>
            </div>
        </div>
    </form>
	
	<div class="modal fade" id="modal-remove">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header text-danger">
					<h4 class="modal-title"></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">No, cancelar</button>
					<button type="button" class="btn btn-danger" data-proceed>Sí, eliminar</button>
				</div>
			</div><!--modal-content-->
		</div><!--modal-dialog-->
	</div><!--modal-->

    <script src="{{ asset('/vendors/ckeditor/ckeditor.js') }}"></script>
@stop
