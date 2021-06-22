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
        @if ($service)
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
                            <input name="es_title" value="{{ old('es_title', optional($service)->es_title) }}" type="text" class="form-control {{ $errors->get('es_title') ? 'is-invalid' : '' }}" id="esTitleInput" placeholder="Ej: Empaquetado de regalos">
                            @error('es_title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        <div class="form-group">
                            <label for="esDescriptionInput">Descripción</label>
                            <textarea name="es_description" class="form-control {{ $errors->get('es_description') ? 'is-invalid' : '' }}" id="esDescriptionInput">{{ old('es_description', optional($service)->es_description) }}</textarea>
                            <small class="text-muted">
                                Aparecerá en el detalle del servicio
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
                            <input name="en_title" value="{{ old('en_title', optional($service)->en_title) }}" type="text" class="form-control {{ $errors->get('en_title') ? 'is-invalid' : '' }}" id="enTitleInput" placeholder="Ej: Gift packaging">
                            @error('en_title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        <div class="form-group">
                            <label for="enDescriptionInput">Descripción</label>
                            <textarea name="en_description" class="form-control {{ $errors->get('en_description') ? 'is-invalid' : '' }}" id="enDescriptionInput">{{ old('en_description', optional($service)->en_description) }}</textarea>
                            <small class="text-muted">
                                Aparecerá en el detalle del servicio
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
                                <input type="checkbox" name="vip" value="1" {{ optional($service)->vip ? 'checked' : '' }} class="custom-control-input" id="customSwitch1">
                                <label class="custom-control-label" for="customSwitch1">VIP</label>
                            </div>
                        </div><!--form-group-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="shareUrlInput">URL Compartir</label>
                                    <input name="share_url" value="{{ old('share_url', optional($service)->share_url) }}" type="text" class="form-control" id="shareUrlInput" placeholder="">
                                    @error('share_url')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div>
                        </div>
                        

                        <div class="form-group {{ !empty($service['icon']) ? 'd-none' : '' }}" id="iconLoader">
                            <label>Icono</label>
                            <div class="custom-file">
                                <input type="file" name="icon" class="custom-file-input" id="customFile2">
                                <label class="custom-file-label" for="customFile2">Elegir archivo</label>
                            </div>
                            @error('icon')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        @if (!empty($service['icon']))
                        <div class="form-group" on-remove-display="#iconLoader">
                            <label>Icono</label>
                            <ul class="mailbox-attachments">
                                <li id="{{ $service['icon']->hash }}">
                                    <span class="mailbox-attachment-icon has-img"><img src="{{ Storage::url($service['icon']->path) }}" alt="Attachment"></span>
                                    <div class="mailbox-attachment-info">
                                        <a href="#" class="mailbox-attachment-name">{{ Str::limit($service['icon']->name, 18, $end='...') }}</a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                                            <span>{{ number_format($service['icon']->size / 1024, 2) }} KB</span>

                                            <div class="btn-group float-right" role="group">
                                                <button type="button" 
                                                data-toggle="modal" 
                                                data-target="#modal-remove"
                                                data-title="Atención"
                                                data-body="<p>El icono será eliminado.<br>Esta acción no se puede deshacer. ¿Estás seguro?</p>"
                                                data-callback="callDelete('#{{ $service['icon']->hash }}', '/services/{{ $service['id'] }}/icon', '{{ csrf_token() }}')"
                                                class="btn btn-default btn-sm float-right"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </span>
                                    </div>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div><!--form-group-->
                        @endif


                        <div class="form-group {{ !empty($service['images']) ? 'd-none' : '' }}" id="fotoLoader">
                            <label>Foto</label>
                            <div class="custom-file">
                                <input type="file" name="images[]" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Elegir archivo</label>
                            </div>
                            @error('images.*')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        @if (!empty($service['images']))
                        <div class="form-group" on-remove-display="#fotoLoader">
                            <label>Foto</label>
                            <ul class="mailbox-attachments">
                                @foreach($service['images'] as $image)
                                <li id="{{ $image->hash }}">
                                    <span class="mailbox-attachment-icon has-img"><img src="{{ Storage::url($image->path) }}" alt="Attachment"></span>
                                    <div class="mailbox-attachment-info">
                                        <a href="#" class="mailbox-attachment-name">{{ Str::limit($image->name, 18, $end='...') }}</a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                                            <span>{{ number_format($image->size / 1024, 2) }} KB</span>

                                            <div class="btn-group float-right" role="group">
                                                <button type="button" 
                                                data-toggle="modal" 
                                                data-target="#modal-remove"
                                                data-title="Atención"
                                                data-body="<p>La foto será eliminada.<br>Esta acción no se puede deshacer. ¿Estás seguro?</p>"
                                                data-callback="callDelete('#{{ $image->hash }}', '/services/{{ $service['id'] }}/images/{{ $image->hash }}', '{{ csrf_token() }}')"
                                                class="btn btn-default btn-sm float-right"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            <div class="clearfix"></div>
                        </div><!--form-group-->
                        @endif
                    </div><!--card-body-->
                </div><!--card-->
            </div><!--col-->
        </div><!--row-->
        <div class="row pb-5">
            <div class="col">
                <a class="btn btn-lg btn-danger" href="/services">Cancelar</a>
            </div>
            <div class="col text-right">
                <button type="submit" class="btn btn-lg btn-primary">{{ $service ? 'Modificar' : 'Agregar' }}</button>
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
