<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class CrudController extends Controller
{
    protected $model;
    protected $attribute;
    protected $label;
    protected $form_validator_fields;
    protected $form_data;
    protected $image_size = 600;
    protected $extra_data;
    protected $list_blade;
    protected $form_blade;
    protected $url;

    public function index() {
        $view_data = [
            'title' => $this->label[1],
            'items' => $this->model->get()
        ];
        return view(!empty($this->list_blade) ? $this->list_blade : $this->attribute . 's-list', $view_data);
    }

    public function form(Request $request, $item_id = NULL) {
        if ($item_id) {
            $item = $this->model->where('id', $item_id)->firstOrFail();
            $title = 'Editar ' . $this->label[0];
        } else {
            $item = [];
            $title = (!empty($this->label[2]) ? $this->label[2] . ' ' : 'Nuevo ') . $this->label[0];
        }

        $view_data = [
            'title' => $title,
            $this->attribute => $item,
            'extra_data' => $this->extra_data
        ];

        return view(!empty($this->form_blade) ? $this->form_blade : $this->attribute . 's-form', $view_data);
    }

    public function store(Request $request, $item_id = NULL) {
        Validator::make($request->all(), $this->form_validator_fields, [
            'required' => 'Este campo es obligatorio',
            'max' => 'Este campo debe tener máximo de :max caracteres',
            'image' => 'Los archivos subidos deben ser imagenes',
            'date' => 'La fecha no es válida',
            'email' => 'El email debe ser una dirección de correo válida',
            'url' => 'El formato de URL es inválido',
        ])->validate();

        if (!empty($request->file('images'))) {
            $images = [];
            foreach($request->file('images') as $image) {
                if ($image->isValid()) {
                    $images[] = $this->resizeAndStore($image);
                }
            }
        }
        
        $data = $this->form_data;
        if (!empty($request->file('icon'))) {
            if ($request->file('icon')->isValid()) {
                $icon = $this->storeFile($request->file('icon'));
            }
            $data['icon'] = json_encode($icon);
        }
        
        if (!empty($request->file('image'))) {
            if ($request->file('image')->isValid()) {
                $image = $this->resizeAndStore($request->file('image'));
            }
            $data['image'] = json_encode($image);
        }
        
        if (!empty($request->file('logo'))) {
            if ($request->file('logo')->isValid()) {
                $logo = $this->resizeAndStore($request->file('logo'), 600);
            }
            $data['logo'] = json_encode($logo);
        }

        if ($item_id) {
            if (!empty($images)) {
                $item = $this->model->where('id', $item_id)->firstOrFail();
                if (!empty($item->images)) {
                    $data['images'] = json_encode(array_merge($item->images, $images));
                } else {
                    $data['images'] = json_encode($images);
                }
            }
            $this->model->where('id', $item_id)->update($data);
            $message = 'El registro ha sido actualizado correctamente';
        } else {
            if (!empty($images)) {
                $data['images'] = json_encode($images);
            }
            $this->model->create($data);
            $message = 'El registro ha sido creado correctamente';
        }

        return redirect('/' . (!empty($this->url) ? $this->url : $this->attribute . 's'))->with('success', $message);
    }

    public function deleteImage(Request $request, $item_id, $image_hash) {
        $item = $this->model->where('id', $item_id)->firstOrFail();
        $arr = $item->images;
        foreach($arr as $index => $image) {
            if ($image->hash == $image_hash) {
                Storage::delete('public/' . $image->path);
                unset($arr[$index]);
                break;
            }
        }
        $images = array_values($arr);
        $item->images = count($images) ? json_encode($images) : NULL;
        $item->save();

        return response()->json(NULL, 200);
    }

    public function deleteIcon(Request $request, $item_id) {
        $item = $this->model->where('id', $item_id)->firstOrFail();
        if ($item->icon) {
            Storage::delete('public/' . $item->icon->path);
            $item->icon = NULL;
            $item->save();
        }

        return response()->json(NULL, 200);
    }
    
    public function deleteLogo(Request $request, $item_id) {
        $item = $this->model->where('id', $item_id)->firstOrFail();
        if ($item->logo) {
            Storage::delete('public/' . $item->logo->path);
            $item->logo = NULL;
            $item->save();
        }

        return response()->json(NULL, 200);
    }
    
    public function deleteSingleImage(Request $request, $item_id) {
        $item = $this->model->where('id', $item_id)->firstOrFail();
        if ($item->image) {
            Storage::delete('public/' . $item->image->path);
            $item->image = NULL;
            $item->save();
        }

        return response()->json(NULL, 200);
    }

    public function sortImages(Request $request, $item_id) {
        $validator = Validator::make($request->all(), [
            'elements' => 'required|array'
        ]);
        if ($validator->fails()) return response()->json(NULL, 400);

        $item = $this->model->where('id', $item_id)->firstOrFail();
        $new_arrange = [];
        foreach($request->input('elements') as $element) {
            foreach($item->images as $image) {
                if ($image->hash == $element) {
                    $new_arrange[] = $image;
                }
            }
        }
        $item->images = json_encode($new_arrange);
        $item->save();

        return response()->json(NULL, 200);
    }

    public function delete(Request $request, $item_id) {
        $this->model->where('id', $item_id)->delete();

        return redirect('/' . (!empty($this->url) ? $this->url : $this->attribute . 's'))->with('success', 'El registro ha sido eliminado correctamente');
    }

    private function resizeAndStore($image, $image_size = NULL) {
        $t = array_sum(explode(" ", microtime())) * 10000;

        if (empty($image_size)) $image_size = $this->image_size;

        if (is_array($image_size)) {
            $resize = Image::make($image)->fit($image_size[0], $image_size[1])->encode('jpg');
        } else {
            $resize = Image::make($image)->fit($image_size)->encode('jpg');
        }
        $hash = md5($t);
        $path = "public/{$hash}.jpg";
        Storage::put($path, $resize);

        return [
            'hash' => $hash,
            'path' => basename($path),
            'name' => $image->getClientOriginalName(),
            'size' => $image->getSize()
        ];
    }

    private function storeFile($file) {
        $t = array_sum(explode(" ", microtime())) * 10000;
        $hash = md5($t);
        $path = "public/{$hash}." . $file->getClientOriginalExtension();
        Storage::put($path, file_get_contents($file));
        return [
            'hash' => $hash,
            'path' => basename($path),
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize()
        ];
    }
}
