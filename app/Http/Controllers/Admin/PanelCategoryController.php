<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Category;

class PanelCategoryController extends Controller
{
    public function show_category()
    {
        $data = Category::take(50)->orderBy('id', 'desc')->get();
        return $view = view('components.admin.category', ['categories' => $data])->render();
    }

    public function addcategory(Request $request)
    {
        $name = $request->data[0]['value'];
        $priority = $request->data[1]['value'];

        if(empty($name))
            return response()->json(['error' => "Название не может быть пустым"]);

        if(empty($priority))
            return response()->json(['error' => "Приоритет не может быть пустым"]);

        if(!ctype_digit($priority))
            return response()->json(['error' => "Приоритет не может быть строкой"]);

        $category = new Category;
        $category->catalogID = 1;
        $category->name = $name;
        $category->priority = $priority;
        $category->active = 1;
        $category->image = "/storage/category/not.jpg";
        $category->save();

        return response()->json(['succes' => "успешно"]);
    }

    public function editcategory(Request $request)
    {
        $category = Category::find($request->id);

        if(!$category)
            return response()->json(['error' => "Категория не найдена!"]);

        $data = '
        <form style="width: 22rem;" data-action="/editcategory" id="editcategory">

        <div data-mdb-input-init class="form-outline mb-4">
        <label class="form-label" for="form5Example1">Название</label>
        <input type="text" id="form5Example1" class="form-control no-effect" name="name" value="'.$category->name.'" />
        </div>

        <div data-mdb-input-init class="form-outline mb-4">
        <label class="form-label" for="form5Example2">Приоритет</label>
        <input type="text" id="form5Example2" class="form-control no-effect" name="priority" value="'.$category->priority.'" />
        </div>


        <div class="form-check mb-4">
        '.($category->active ? '<input class="form-check-input" type="checkbox" name="active" id="flexCheckChecked" checked/>' : '<input class="form-check-input" type="checkbox" name="active" id="flexCheckChecked"/>').'
        <label class="form-check-label" for="flexCheckChecked">Активная</label>
        </div>

        <img src="'.asset($category->image).'" class="category-image mb-4" alt="...">

        <div class="mb-3">
        <input class="form-control" type="file" id="formFile" name="image" value="not">
        </div>

        <input type="hidden" name="id" id="catid" value="'.$category->id.'" />

        </form>

        <button type="button" class="btn btn-success" id="btnsavecategory">Сохранить</button>
        <button type="button" class="btn btn-danger" id="btndeletecategory">Удалить</button>
        ';

        return $data;
    }

    public function deletecategory(Request $request)
    {
        Category::destroy($request->id);
    }

    public function editcategory_process(Request $request)
    {

        $name = $request->name;
        $priority = $request->priority;

        $active = 1;
        if(!$request->active)
            $active = 0;

        $image = $request->image;
        $id = $request->id;


        if(empty($name))
            return response()->json(['error' => "Название не может быть пустым"]);

        if(empty($priority))
            return response()->json(['error' => "Приоритет не может быть пустым"]);

        if(!ctype_digit($priority))
            return response()->json(['error' => "Приоритет не может быть строкой"]);

        $category = Category::find($id);

            if($request->hasFile('image'))
            {
                $validator = Validator::make($request->all(), ['image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',]);

                if($validator->fails())
                    return response()->json(['error' => "Неправильная картинка"]);

                $extension = $request->image->extension();
                $imgaeId = Str::random(15);
                $image_name = $imgaeId . '.' . $extension;

                $path = $request->image->storeAs('category', $image_name, 'public');
                $image = '/storage/'.$path;

                $category->image = $image;
            }

        if(!$category)
            return response()->json(['error' => "Не найдена категория"]);

        $category->name = $name;
        $category->priority = $priority;
        $category->active =$active;
        $category->save();


        return response()->json(['succes' => "успешно"]);
    }
}
