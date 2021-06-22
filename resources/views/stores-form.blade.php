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
        @if ($store)
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
                            <label for="esDescriptionShortInput">Descripción breve</label>
                            <input name="es_description_short" value="{{ old('es_description_short', optional($store)->es_description_short) }}" type="text" class="form-control {{ $errors->get('es_description_short') ? 'is-invalid' : '' }}" id="esDescriptionShortInput" placeholder="">
                            <small class="text-muted">
                                Aparecerá en el listado de locales
                            </small>
                            @error('es_description_short')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        <div class="form-group">
                            <label for="esDescriptionInput">Descripción</label>
                            <textarea name="es_description" class="form-control {{ $errors->get('es_description') ? 'is-invalid' : '' }} ckeditor" id="esDescriptionInput">{{ old('es_description', optional($store)->es_description) }}</textarea>
                            <small class="text-muted">
                                Aparecerá en el detalle del local
                            </small>
                            @error('es_description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        <div class="form-group">
                            <label for="esLocationInput">Ubicación</label>
                            <input name="es_location" value="{{ old('es_location', optional($store)->es_location) }}" type="text" class="form-control {{ $errors->get('es_location') ? 'is-invalid' : '' }}" id="esLocationInput" placeholder="Ej: Planta Alta, Local 37">
                            @error('es_location')
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
                            <label for="enDescriptionShortInput">Descripción breve</label>
                            <input name="en_description_short" value="{{ old('en_description_short', optional($store)->en_description_short) }}" type="text" class="form-control {{ $errors->get('en_description_short') ? 'is-invalid' : '' }}" id="enDescriptionShortInput" placeholder="">
                            <small class="text-muted">
                                Aparecerá en el listado de locales
                            </small>
                            @error('en_description_short')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        <div class="form-group">
                            <label for="enDescriptionInput">Descripción</label>
                            <textarea name="en_description" class="form-control {{ $errors->get('en_description') ? 'is-invalid' : '' }} ckeditor" id="enDescriptionInput">{{ old('en_description', optional($store)->en_description) }}</textarea>
                            <small class="text-muted">
                                Aparecerá en el detalle del local
                            </small>
                            @error('en_description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        <div class="form-group">
                            <label for="enLocationInput">Ubicación</label>
                            <input name="en_location" value="{{ old('en_location', optional($store)->en_location) }}" type="text" class="form-control {{ $errors->get('en_location') ? 'is-invalid' : '' }}" id="enLocationInput" placeholder="Ej: Top Floor, Store 37">
                            @error('en_location')
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
                                    <label for="nameInput">Nombre</label>
                                    <input name="name" value="{{ old('name', optional($store)->name) }}" type="text" class="form-control {{ $errors->get('name') ? 'is-invalid' : '' }}" id="nameInput" placeholder="Ej: Starbucks">
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hourInput">Horario</label>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Desde</span>
                                                </div>
                                                <input name="hour_from" value="{{ old('hour_from', optional($store)->hour_from) }}" type="text" class="form-control" id="hourInput" placeholder="" data-inputmask="'mask': '99:99'">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Hasta</span>
                                                </div>
                                                <input name="hour_to" value="{{ old('hour_to', optional($store)->hour_to) }}" type="text" class="form-control" placeholder="" data-inputmask="'mask': '99:99'">
                                            </div>
                                        </div>
                                    </div>
                                </div><!--form-group-->
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="categoryInput">Categoría</label>
                                    <select name="category_id" class="form-control {{ $errors->get('category_id') ? 'is-invalid' : '' }}" id="categoryInput">
                                        <option readonly disabled {{ !optional($store)->category ? 'selected' : '' }}>Selecciona</option>
                                        @foreach($extra_data['categories'] as $category)
                                            <option value="{{ $category['id'] }}" {{ optional(optional($store)->category)->id == $category['id'] ? 'selected' : '' }}>{{ $category['es_title'] }}</option>            
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="phoneInput">Teléfono</label>
                                    <input name="phone_number" value="{{ old('phone_number', optional($store)->phone_number) }}" type="text" class="form-control" id="phoneInput" placeholder="">
                                </div><!--form-group-->
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="urlInput">Website</label>
                                    <input name="url" value="{{ old('url', optional($store)->url) }}" type="text" class="form-control" id="urlInput" placeholder="">
                                </div><!--form-group-->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="shareUrlInput">URL Compartir</label>
                                    <input name="share_url" value="{{ old('share_url', optional($store)->share_url) }}" type="text" class="form-control" id="shareUrlInput" placeholder="">
                                    @error('share_url')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div><!--form-group-->
                            </div>
                        </div>

                        <div class="form-group {{ !empty($store['logo']) ? 'd-none' : '' }}" id="logoLoader">
                            <label>Logo</label>
                            <div class="custom-file">
                                <input type="file" name="logo" class="custom-file-input" id="customFile2">
                                <label class="custom-file-label" for="customFile2">Elegir archivo</label>
                            </div>
                            @error('logo')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        @if (!empty($store['logo']))
                        <div class="form-group" on-remove-display="#logoLoader">
                            <label>Logo</label>
                            <ul class="mailbox-attachments">
                                <li id="{{ $store['logo']->hash }}">
                                    <span class="mailbox-attachment-icon has-img"><img src="{{ Storage::url($store['logo']->path) }}" alt="Attachment"></span>
                                    <div class="mailbox-attachment-info">
                                        <a href="#" class="mailbox-attachment-name">{{ Str::limit($store['logo']->name, 18, $end='...') }}</a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                                            <span>{{ number_format($store['logo']->size / 1024, 2) }} KB</span>

                                            <div class="btn-group float-right" role="group">
                                                <button type="button" 
                                                data-toggle="modal" 
                                                data-target="#modal-remove"
                                                data-title="Atención"
                                                data-body="<p>El logo será eliminado.<br>Esta acción no se puede deshacer. ¿Estás seguro?</p>"
                                                data-callback="callDelete('#{{ $store['logo']->hash }}', '/stores/{{ $store['id'] }}/logo', '{{ csrf_token() }}')"
                                                class="btn btn-default btn-sm float-right"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </span>
                                    </div>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div><!--form-group-->
                        @endif

                        <div class="form-group">
                            <label for="inputFile">Fotos</label>
                            <!-- <input type="file" class="form-control-file" id="exampleFormControlFile1" multiple> -->
                            <div class="custom-file">
                                <input type="file" name="images[]" class="custom-file-input" id="customFile" multiple>
                                <label class="custom-file-label" for="customFile">Elegir archivos</label>
                            </div>
                            @error('images.*')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div><!--form-group-->
                        @if (!empty($store['images']))
                        <div class="form-group">
                            <label for="images">Fotos subidas</label>
                            <ul class="mailbox-attachments sortable" data-sortable-url="/stores/{{ $store['id'] }}/sort-images/" data-token="{{ csrf_token() }}">
                                @foreach($store['images'] as $image)
                                <li id="{{ $image->hash }}">
                                    <span class="mailbox-attachment-icon has-img"><img src="{{ Storage::url($image->path) }}" alt="Attachment"></span>
                                    <div class="mailbox-attachment-info">
                                        <a href="#" class="mailbox-attachment-name">{{ Str::limit($image->name, 18, $end='...') }}</a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                                            <span>{{ number_format($image->size / 1024, 2) }} KB</span>

                                            <div class="btn-group float-right" role="group" aria-label="Basic example">
                                                <div class="handle btn btn-default btn-sm"><i class="fas fa-arrows-alt"></i></div>
                                                <button type="button" 
                                                data-toggle="modal" 
                                                data-target="#modal-remove"
                                                data-title="Atención"
                                                data-body="<p>La foto será eliminada.<br>Esta acción no se puede deshacer. ¿Estás seguro?</p>"
                                                data-callback="callDelete('#{{ $image->hash }}', '/stores/{{ $store['id'] }}/images/{{ $image->hash }}', '{{ csrf_token() }}')"
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
                <a class="btn btn-lg btn-danger" href="/stores">Cancelar</a>
            </div>
            <div class="col text-right">
                <button type="submit" class="btn btn-lg btn-primary">{{ $store ? 'Modificar' : 'Agregar' }}</button>
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
