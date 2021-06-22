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
        @if ($slide)
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
                        <div class="form-group">
                            <label for="esTitleInput">Título</label>
                            <input name="es_title" value="{{ old('es_title', optional($slide)->es_title) }}" type="text" class="form-control {{ $errors->get('es_title') ? 'is-invalid' : '' }}" id="esTitleInput" placeholder="Ej: Rebajas de Invierno">
                            @error('es_title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        <div class="form-group">
                            <label for="esCaptionInput">Bajada</label>
                            <input name="es_caption" value="{{ old('es_caption', optional($slide)->es_caption) }}" type="text" class="form-control {{ $errors->get('es_caption') ? 'is-invalid' : '' }}" id="esCaptionInput" placeholder="Ej: 7 Enero / 6 Marzo">
                            @error('es_caption')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        <div class="form-group">
                            <label for="esDescriptionShortInput">Descripción breve</label>
                            <input name="es_description_short" value="{{ old('es_description_short', optional($slide)->es_description_short) }}" type="text" class="form-control {{ $errors->get('es_description_short') ? 'is-invalid' : '' }}" id="esDescriptionShortInput" placeholder="Ej: Hasta 90% off">
                            @error('es_description_short')
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
                            <label for="esTitleInput">Título</label>
                            <input name="en_title" value="{{ old('en_title', optional($slide)->en_title) }}" type="text" class="form-control {{ $errors->get('en_title') ? 'is-invalid' : '' }}" id="esTitleInput" placeholder="Ej: Winter season OFF">
                            @error('en_title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        <div class="form-group">
                            <label for="esCaptionInput">Bajada</label>
                            <input name="en_caption" value="{{ old('en_caption', optional($slide)->en_caption) }}" type="text" class="form-control {{ $errors->get('en_caption') ? 'is-invalid' : '' }}" id="esCaptionInput" placeholder="Ej: January 7th / March 6th">
                            @error('en_caption')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        <div class="form-group">
                            <label for="esDescriptionShortInput">Descripción breve</label>
                            <input name="en_description_short" value="{{ old('en_description_short', optional($slide)->en_description_short) }}" type="text" class="form-control {{ $errors->get('en_description_short') ? 'is-invalid' : '' }}" id="esDescriptionShortInput" placeholder="Ej: Sale up to 50% OFF">
                            @error('en_description_short')
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
                                    <label>Link</label>
                                    <select class="form-control" name="link">
                                        <option value="">Ninguno</option>
                                        @foreach($extra_data['links'] as $key => $group)
                                            <optgroup label="{{ $key }}">
                                                @foreach($group as $link => $name)
                                                    <option value="{{ $link }}" {{ $link == optional($slide)->link ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">
                                        Es el destino del botón "Ver más"
                                    </small>
                                </div>
                            </div><!--col-md-->
                        </div>
                        <div class="form-group {{ !empty($slide['image']) ? 'd-none' : '' }}" id="fotoLoader">
                            <label for="inputFile">Foto</label>
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Elegir archivo</label>
                            </div>
                            @error('image')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        @if (!empty($slide['image']))
                        <div class="form-group" on-remove-display="#fotoLoader">
                            <label for="image">Foto</label>
                            <ul class="mailbox-attachments">
                                <li id="{{ $slide['image']->hash }}">
                                    <span class="mailbox-attachment-icon has-img"><img src="{{ Storage::url($slide['image']->path) }}" alt="Attachment"></span>
                                    <div class="mailbox-attachment-info">
                                        <a href="#" class="mailbox-attachment-name">{{ Str::limit($slide['image']->name, 18, $end='...') }}</a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                                            <span>{{ number_format($slide['image']->size / 1024, 2) }} KB</span>

                                            <div class="btn-group float-right" role="group" aria-label="Basic example">
                                                <button type="button" 
                                                data-toggle="modal" 
                                                data-target="#modal-remove"
                                                data-title="Atención"
                                                data-body="<p>La foto será eliminada.<br>Esta acción no se puede deshacer. ¿Estás seguro?</p>"
                                                data-callback="callDelete('#{{ $slide['image']->hash }}', '/slides/{{ $slide['id'] }}/images/{{ $slide['image']->hash }}', '{{ csrf_token() }}')"
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
                <a class="btn btn-lg btn-danger" href="/slides">Cancelar</a>
            </div>
            <div class="col text-right">
                <button type="submit" class="btn btn-lg btn-primary">{{ $slide ? 'Modificar' : 'Agregar' }}</button>
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
@stop
