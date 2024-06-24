<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use App\Models\ProductProperty;

class PanelPropertyController extends Controller
{
    public function show_property()
    {
        $data = Property::take(50)->orderBy('id', 'desc')->get();
        return $view = view('components.admin.property', ['properties' => $data])->render();
    }

    public function modaladdproperty()
    {
        $cat = Category::all();
        $options = '';
        foreach($cat as $c)
        {
            $options .= '
            <div class="form-check form-switch mb-4">
            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="'.$c->id.'">
            <label class="form-check-label" for="flexSwitchCheckDefault">'.$c->name.'</label>
            </div>
          ';
        }


        $data = '
            <form style="width: 22rem;" data-action="/addproperty_process" id="addproperty">

            <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="form5Example1">Название</label>
            <input type="text" id="form5Example1" class="form-control no-effect" name="name" />
            </div>

            <div data-mdb-input-init class="form-outline mb-4" id="categories">
            '.$options.'
            </div>

            </form><button type="button" id="btnaddprop" class="btn btn-success">Добавить</button>';

        return $data;
    }

    public function addproperty_process(Request $request)
    {
        $name = $request->name;
        $categories = $request->categories;


        if(empty($name))
            return response()->json(['error' => "Название не может быть пустым"]);

        $property = new Property;
        $property->name = $name;
        $property->type = 'string';
        if($categories && count($categories) > 0)
            $property->categories = implode(',', $categories);
        else
            $property->categories = null;

        $property->save();
        return response()->json(['succes' => ""]);
    }

    public function editproperty(Request $request)
    {
        $property = Property::find($request->id);
        if(!$property)
            return response()->json(['error' => "Свойство не найдено"]);

        $cat = Category::all();
        $propertyCategs = $property->categories;

        $options = '';
        if($propertyCategs != null)
        {
            $propertyCategs = explode(',', $propertyCategs);
            foreach($cat as $c)
            {
                $options .= '
                <div class="form-check form-switch mb-4">'
                .(in_array($c->id, $propertyCategs) ? '<input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="'.$c->id.'" checked>': '<input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="'.$c->id.'">').
                '<label class="form-check-label" for="flexSwitchCheckDefault">'.$c->name.'</label>
                </div>
            ';
            }
        }
        else
        {
            foreach($cat as $c)
            {
                $options .= '
                <div class="form-check form-switch mb-4">
                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="'.$c->id.'">
                <label class="form-check-label" for="flexSwitchCheckDefault">'.$c->name.'</label>
                </div>
            ';
            }
        }


        $data = '
            <form style="width: 22rem;" data-action="/editproperty" id="editproperty">

            <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="form5Example1">Название</label>
            <input type="text" id="form5Example1" class="form-control no-effect" name="name" value="'.$property->name.'" />
            </div>

            <div data-mdb-input-init class="form-outline mb-4" id="categories">
            '.$options.'
            </div>

            <input type="hidden" id="propertyID" name="propertyID" value="'.$property->id.'"/>

            </form>
            <button type="button" class="btn btn-success" id="btnsaveproperty">Сохранить</button>
            <button type="button" class="btn btn-danger" id="btndeleteproperty">Удалить</button>
            ';

        return $data;
    }

    public function saveproperty(Request $request)
    {
        $name = $request->name;
        $categories = $request->categories;
        $propertyID = $request->propertyID;

        if(empty($name))
            return response()->json(['error' => "Название не может быть пустым"]);

        $property = Property::find($propertyID);
        if(!$property)
            return response()->json(['error' => "Свойство не найдено"]);

        $property->name = $name;
        if($categories && count($categories) > 0)
            $property->categories = implode(',', $categories);
        else
            $property->categories = null;
        $property->save();
        return response()->json(['succes' => ""]);
    }

    public function deleteproperty(Request $request)
    {
        $propertyID = $request->id;

        $property = Property::find($propertyID);
        if(!$property)
            return response()->json(['error' => "Свойство не найдено"]);


        ProductProperty::where('propertyID', $propertyID)->delete();
        $property->delete();
    }

    public function searchproperty($param)
    {
        if((empty($param)))
            return response()->json(['error' => "Свойств не найдено!"]);

        $properties = Property::where('categories', 'LIKE', "%{$param}%")
                                ->orderBy('id', 'desc')
                                ->get();

        if(count($properties) == 0)
            return response()->json(['error' => "Свойств не найдено!"]);

        return $view = view('components.admin.property', ['properties' => $properties])->render();
    }
}
