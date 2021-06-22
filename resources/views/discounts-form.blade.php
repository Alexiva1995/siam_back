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
        @if ($discount)
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
                            <input name="es_title" value="{{ old('es_title', optional($discount)->es_title) }}" type="text" class="form-control {{ $errors->get('es_title') ? 'is-invalid' : '' }}" id="esTitleInput" placeholder="Ej: Descuento 50% Champañas y Espumantes.">
                            @error('es_title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        <div class="form-group">
                            <label for="esCaptionInput">Bajada</label>
                            <input name="es_caption" value="{{ old('es_caption', optional($discount)->es_caption) }}" type="text" class="form-control {{ $errors->get('es_caption') ? 'is-invalid' : '' }}" id="esCaptionInput" placeholder="Ej: En bodegas nombre marca">
                            @error('es_caption')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        <div class="form-group">
                            <label for="esDescriptionInput">Descripción</label>
                            <textarea name="es_description" class="form-control {{ $errors->get('es_description') ? 'is-invalid' : '' }} ckeditor" id="esDescriptionInput">{{ old('es_description', optional($discount)->es_description) }}</textarea>
                            <small class="text-muted">
                                Aparecerá en el detalle del descuento
                            </small>
                            @error('es_description')
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
                            <input name="en_title" value="{{ old('en_title', optional($discount)->en_title) }}" type="text" class="form-control {{ $errors->get('en_title') ? 'is-invalid' : '' }}" id="enTitleInput" placeholder="Ej: 50% OFF champagne and sparkling wines.">
                            @error('en_title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        <div class="form-group">
                            <label for="enCaptionInput">Bajada</label>
                            <input name="en_caption" value="{{ old('en_caption', optional($discount)->en_caption) }}" type="text" class="form-control {{ $errors->get('en_caption') ? 'is-invalid' : '' }}" id="enCaptionInput" placeholder="Ej: Brand name wineries">
                            @error('en_caption')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        <div class="form-group">
                            <label for="enDescriptionInput">Descripción</label>
                            <textarea name="en_description" class="form-control {{ $errors->get('en_description') ? 'is-invalid' : '' }} ckeditor" id="enDescriptionInput">{{ old('en_description', optional($discount)->en_description) }}</textarea>
                            <small class="text-muted">
                                Aparecerá en el detalle del descuento
                            </small>
                            @error('en_description')
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
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="vip" value="1" {{ optional($discount)->vip ? 'checked' : '' }} class="custom-control-input" id="customSwitch1">
                                <label class="custom-control-label" for="customSwitch1">VIP</label>
                            </div>
                        </div><!--form-group-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hourInput">Fecha</label>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Desde</span>
                                                </div>
                                                <input name="date_from" value="{{ old('date_from', optional($discount)->date_from) }}" type="text" class="form-control {{ $errors->get('date_from') ? 'is-invalid' : '' }}" id="hourInput" placeholder="" data-inputmask="'alias': 'datetime','inputFormat': 'dd/mm/yyyy', 'placeholder': 'dd/mm/aaaa'">                                                
                                            </div>
                                            @error('date_from')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Hasta</span>
                                                </div>
                                                <input name="date_to" value="{{ old('date_to', optional($discount)->date_to) }}" type="text" class="form-control {{ $errors->get('date_to') ? 'is-invalid' : '' }}" placeholder="" data-inputmask="'alias': 'datetime','inputFormat': 'dd/mm/yyyy','placeholder': 'dd/mm/aaaa'">
                                            </div>
                                            @error('date_to')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div><!--form-group-->
                            </div><!--col-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="shareUrlInput">URL Compartir</label>
                                    <input name="share_url" value="{{ old('share_url', optional($discount)->share_url) }}" type="text" class="form-control" id="shareUrlInput" placeholder="">
                                    @error('share_url')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div>
                        </div>
                        <div class="form-group {{ !empty($discount['images']) ? 'd-none' : '' }}" id="fotoLoader">
                            <label for="inputFile">Foto</label>
                            <div class="custom-file">
                                <input type="file" name="images[]" class="custom-file-input" id="customFile" multiple>
                                <label class="custom-file-label" for="customFile">Elegir archivos</label>
                            </div>
                            @error('images.*')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        @if (!empty($discount['images']))
                        <div class="form-group" on-remove-display="#fotoLoader">
                            <label for="images">Foto</label>
                            <ul class="mailbox-attachments">
                                @foreach($discount['images'] as $image)
                                <li id="{{ $image->hash }}">
                                    <span class="mailbox-attachment-icon has-img"><img src="{{ Storage::url($image->path) }}" alt="Attachment"></span>
                                    <div class="mailbox-attachment-info">
                                        <a href="#" class="mailbox-attachment-name">{{ Str::limit($image->name, 18, $end='...') }}</a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                                            <span>{{ number_format($image->size / 1024, 2) }} KB</span>

                                            <div class="btn-group float-right" role="group" aria-label="Basic example">
                                                <button type="button" 
                                                data-toggle="modal" 
                                                data-target="#modal-remove"
                                                data-title="Atención"
                                                data-body="<p>La foto será eliminada.<br>Esta acción no se puede deshacer. ¿Estás seguro?</p>"
                                                data-callback="callDelete('#{{ $image->hash }}', '/discounts/{{ $discount['id'] }}/images/{{ $image->hash }}', '{{ csrf_token() }}')"
                                                class="btn btn-default btn-sm float-right"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div><!--form-group-->
                        @endif
                    </div><!--card-body-->
                </div><!--card-->
            </div><!--col-->
        </div><!--row-->
        <div class="row pb-5">
            <div class="col">
                <a class="btn btn-lg btn-danger" href="/discounts">Cancelar</a>
            </div>
            <div class="col text-right">
                <button type="submit" class="btn btn-lg btn-primary">{{ $discount ? 'Modificar' : 'Agregar' }}</button>
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
