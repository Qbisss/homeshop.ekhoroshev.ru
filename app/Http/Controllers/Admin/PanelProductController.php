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
use App\Models\Badge;

class PanelProductController extends Controller
{
    public function show_product()
    {
        $data = Product::take(50)->orderBy('id', 'desc')->get();
        return $view = view('components.admin.product', ['products' => $data])->render();
    }

    public function modaladdproduct()
    {
        $cat = Category::all();
        $options = '';
        foreach($cat as $c)
        {
            $options .= '<option value="'.$c->id.'">'.$c->name.'</option>';
        }

        $data = '
            <form style="width: 22rem;" data-action="/addproduct" id="addproduct">

            <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="form5Example1">Название</label>
            <input type="text" id="form5Example1" class="form-control no-effect" name="name" />
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="form5Example2">Артикул</label>
            <input type="text" id="form5Example2" class="form-control no-effect" name="article"/>
            </div>

            <div class="mb-3">
            <label for="formFile" class="form-label">Главная картинка</label>
            <input class="form-control" type="file" id="formFile" name="image" value="not">
            </div>

            <div class="mb-3">
            <label for="formFileMultiple" class="form-label">Галерея</label>
            <input class="form-control" type="file" id="formFileMultiple" name="images" multiple>
            </div>

            <p>Оставляйте пустым и свойство не отобразиться</p>
            <select name="categoryID" id="selectCategory" class="form-select mb-4">

            <option selected disabled>Выберите категорию</option>
            '.$options.'
            </select>


            <div data-mdb-input-init class="form-outline mb-4" id="properties">

            </div>


            <div class="form-outline mb-4">
            <label for="exampleFormControlTextarea1" class="form-label">Описание</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="desc" rows="3"></textarea>
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="form5Example5">Цена</label>
            <input type="text" id="form5Example5" class="form-control no-effect" name="price" />
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="form5Example6">Приоритет</label>
            <input type="text" id="form5Example6" class="form-control no-effect" name="priority" value="1" />
            </div>
            </form><button type="button" id="btnaddproduct" class="btn btn-success">Добавить</button>';

        return $data;
    }

    public function modaladdproperties(Request $request)
    {
        $id = $request->id;

        $properties = Property::all();
        $data = '';
        $i = 0;

        foreach($properties as $prop)
        {
            $ids = explode(',', $prop->categories);

            if(in_array($id, $ids))
            {
                $i++;

                $data .= '

                <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="formProp'.$i.'"><strong>'.$prop->name.'</strong></label>
                <input type="text" id="formProp'.$i.'" class="form-control no-effect" name="'.$prop->id.'"/>
                </div>

                ';
            }
        }

        return $data;

    }

    public function addproduct(Request $request)
    {
        $categoryID = $request->categoryID;
        $name = $request->name;
        $article = $request->article;
        $imageMain = $request->image;
        $images = $request->images;
        $totalImages = $request->TotalImages;
        $desc = $request->desc;
        $price = $request->price;
        $priority = $request->priority;
        $properties = $request->properties;


        if(empty($name))
            return response()->json(['error' => "Название не может быть пустым"]);

        if(empty($priority))
            return response()->json(['error' => "Приоритет не может быть пустым"]);

        if(empty($article))
            return response()->json(['error' => "Артикул не может быть пустым"]);

        if(empty($desc))
            return response()->json(['error' => "Описание не может быть пустым"]);

        if(empty($price))
            return response()->json(['error' => "Цена не может быть пустой"]);

        if(empty($categoryID))
            return response()->json(['error' => "Категория не выбрана"]);

        if(!ctype_digit($priority))
            return response()->json(['error' => "Приоритет не может быть строкой"]);

        if(!ctype_digit($price))
            return response()->json(['error' => "Цена не может быть строкой"]);

        $product = new Product;
        $product->categoryID = $categoryID;
        $product->name = $name;
        $product->article = $article;
        $product->desc = $desc;
        $product->price = $price;
        $product->newprice = 0;
        $product->badgeID = 0;
        $product->priority = $priority;
        $product->active = 1;
        $product->save();



        if($request->hasFile('image'))
        {
            $validator = Validator::make($request->all(), ['image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',]);

            if($validator->fails())
                return response()->json(['error' => "Основная картинка не найдена или не верный формат"]);

                $extension = $request->image->extension();
                $imgaeId = Str::random(15);
                $image_name = $imgaeId . '.' . $extension;

                $path = $request->image->storeAs('product/'.$product->id, $image_name, 'public');
                $image = '/storage/'.$path;

                $product->image = $image;
        }

        if($totalImages > 0)
        {
            $imagesPath = [];

            for($i = 0; $i < $totalImages; $i++)
            {
                $validator = Validator::make($request->all(), ['images'.$i => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',]);

                if($validator->fails())
                    return response()->json(['error' => "Картинка галереи[".$i."] не найдена или не верный формат"]);

                $extension = $request['images'.$i]->extension();
                $imgaeId = Str::random(15);
                $image_name = $imgaeId . '.' . $extension;

                $path = $request['images'.$i]->storeAs('product/'.$product->id.'/galary', $image_name, 'public');
                $imagePath = '/storage/'.$path;
                array_push($imagesPath, $imagePath);
            }

            $product->galary = implode(',', $imagesPath);
        }
        $product->save();

        foreach($properties as $key => $value)
        {
            $productprop = new ProductProperty;
            $productprop->productID = $product->id;
            $productprop->propertyID = $key;
            $productprop->value = $value;
            $productprop->save();
        }

        return response()->json(['succes' => "успешно"]);
    }

    public function editproduct(Request $request)
    {
        $product = Product::find($request->id);
        if(!$product)
            return response()->json(['error' => "Товар не найден!"]);

        $category = Category::find($product->categoryID);
        $categories = Category::where('id', '!=', $product->categoryID)->get();
        $productProperty = ProductProperty::where('productID', $product->id)->get();

        $option = '';
        if(!$category)
            $option = '<option selected disabled>Выберите категорию</option>';
        else
            $option = '<option selected value="'.$category->id.'">'.$category->name.'</option>';

        $options = '';
        foreach($categories as $c)
        {
            $options .= '<option value="'.$c->id.'">'.$c->name.'</option>';
        }

        $imgs = '';
        $galary = $product->galary;
        if($galary)
        {
            $images = explode(',', $galary);
            foreach($images as $img)
            {
                $imgs .= '<img src="'.asset($img).'" class="category-image mb-4" alt="...">';
            }
        }

        $properties = '';
        $i = 0;
        foreach($productProperty as $prop)
        {
            $i++;
            $propInfo = Property::find($prop->propertyID);
            $properties .=
            '
            <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="formProp'.$i.'"><strong>'.$propInfo->name.'</strong></label>
            <input type="text" id="formProp'.$i.'" value="'.$prop->value.'" class="form-control no-effect" name="'.$prop->propertyID.'"/>
            </div>
            ';
        }

        $badges = '';
        $db_badge = Badge::find($product->badgeID);
        $db_badges = Badge::where('id', '!=', $product->badgeID)->get();

        if($product->badgeID == 0 || !$db_badge)
            $badges .= '<option selected value="0">Бейджик не выбран</option>';
        else
        {
            $badges .= '<option selected value="'.$db_badge->id.'" style="color:'.$db_badge->color.';">'.$db_badge->name.'</option>';
            $badges .= '<option value="0">Убрать бейджик</option>';
        }
        foreach($db_badges as $bg)
        {
            $badges .= '<option value="'.$bg->id.'" style="color:'.$bg->color.';">'.$bg->name.'</option>';
        }



        $data = '
        <form style="width: 22rem;" data-action="/editproduct" id="editproduct">

            <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="form5Example1">Название</label>
            <input type="text" id="form5Example1" class="form-control no-effect" value="'.$product->name.'" name="name" />
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="form5Example2">Артикул</label>
            <input type="text" id="form5Example2" class="form-control no-effect" value="'.$product->article.'" name="article"/>
            </div>

            <div class="mb-4">
            <label for="formFile" class="form-label">Главная картинка</label>
            <input class="form-control" type="file" id="formFile" name="image" value="not">
            </div>

            <img src="'.asset($product->image).'" class="category-image mb-4" alt="...">

            <div class="mb-4">
            <label for="formFileMultiple" class="form-label">Галерея</label>
            <input class="form-control" type="file" id="formFileMultiple" name="images" multiple>
            </div>

            '.$imgs.'

            <select name="categoryID" id="selectCategory" class="form-select mb-4">
            '.$option.'
            '.$options.'
            </select>

            <div data-mdb-input-init class="form-outline mb-4" id="properties">
            '.$properties.'
            </div>

            </div>

            <div class="form-outline mb-4">
            <label for="exampleFormControlTextarea1" class="form-label">Описание</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="desc" rows="3">'.$product->desc.'</textarea>
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="form5Example5">Цена</label>
            <input type="text" id="form5Example5" class="form-control no-effect" value="'.$product->price.'" name="price" />
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="form5Example5">Цена со скидкой</label>
            <input type="text" id="form5Example5" class="form-control no-effect" value="'.$product->newprice.'" name="newprice" />
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
            <label class="form-label" for="form5Example6">Приоритет</label>
            <input type="text" id="form5Example6" class="form-control no-effect" name="priority" value="'.$product->priority.'" />
            </div>

            <select name="badgeID" class="form-select mb-4">
            '.$badges.'
            </select>

            <div class="form-check mb-4">
            '.($product->active ? '<input class="form-check-input" type="checkbox" name="active" id="flexCheckChecked" checked/>' : '<input class="form-check-input" type="checkbox" name="active" id="flexCheckChecked"/>').'
            <label class="form-check-label" for="flexCheckChecked">Активный</label>
            </div>

            <input type="hidden" id="productID" name="productID" value="'.$product->id.'"/>

            </form>

            <button type="button" class="btn btn-success" id="btnsaveproduct">Сохранить</button>
            <button type="button" class="btn btn-danger" id="btndeleteproduct">Удалить</button>
        ';

        return $data;
    }

    public function deleteproduct(Request $request)
    {
        $id = $request->id;
        if(!$id)
            return response()->json(['error' => "Товар не существует!"]);

        $product = Product::find($id);
        if(!$product)
            return response()->json(['error' => "Товар не найден!"]);

        $image = explode('/', $product->image);
        $path = 'public/product/'.$product->id;
        $galary = [$path.'/'.array_pop($image)];

        $images = explode(',', $product->galary);
        foreach($images as $img)
        {
            $pathArr = explode('/', $img);
            array_push($galary, $path.'/galary/'.array_pop($pathArr));
        }

        Storage::delete($galary);
        Storage::deleteDirectory($path);
        ProductProperty::where('productID', $id)->delete();
        $product->delete();
    }

    public function saveproduct(Request $request)
    {

        $productID = $request->productID;
        $categoryID = $request->categoryID;
        $name = $request->name;
        $article = $request->article;
        $imageMain = $request->image;
        $images = $request->images;
        $totalImages = $request->TotalImages;
        $desc = $request->desc;
        $price = $request->price;
        $priority = $request->priority;
        $properties = $request->properties;
        $newprice = $request->newprice;
        $badgeID = $request->badgeID;
        $active = 1;
        if(!$request->active)
            $active = 0;

        $product = Product::find($productID);

        if(!$product)
            return response()->json(['error' => "Товар не найден"]);

        if(empty($name))
            return response()->json(['error' => "Название не может быть пустым"]);

        if(empty($priority))
            return response()->json(['error' => "Приоритет не может быть пустым"]);

        if(empty($article))
            return response()->json(['error' => "Артикул не может быть пустым"]);

        if(empty($desc))
            return response()->json(['error' => "Описание не может быть пустым"]);

        if(empty($price))
            return response()->json(['error' => "Цена не может быть пустой"]);

        if(empty($categoryID))
            return response()->json(['error' => "Категория не выбрана"]);

        if(!ctype_digit($priority))
            return response()->json(['error' => "Приоритет не может быть строкой"]);

        if(!ctype_digit($price))
            return response()->json(['error' => "Цена не может быть строкой"]);

        $product->categoryID = $categoryID;
        $product->name = $name;
        $product->article = $article;
        $product->desc = $desc;
        $product->price = $price;
        $product->newprice = $newprice;
        $product->badgeID = $badgeID;
        $product->priority = $priority;
        $product->active = $active;


        $galary = [];
        $path = 'public/product/'.$product->id;

        if($request->hasFile('image'))
        {
            $validator = Validator::make($request->all(), ['image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',]);

            if($validator->fails())
            {
                $product->delete();
                return response()->json(['error' => "Основная картинка не найдена или не верный формат"]);
            }

            $image = explode('/', $product->image);
            $galary = [$path.'/'.array_pop($image)];

            $extension = $request->image->extension();
            $imgaeId = Str::random(15);
            $image_name = $imgaeId . '.' . $extension;

            $path = $request->image->storeAs('product/'.$product->id, $image_name, 'public');
            $image = '/storage/'.$path;

            $product->image = $image;
        }



        if($totalImages > 0)
        {
            $imagesPath = [];

            $images = explode(',', $product->galary);
            foreach($images as $img)
            {
                $pathArr = explode('/', $img);
                array_push($galary, $path.'/galary/'.array_pop($pathArr));
            }

            for($i = 0; $i < $totalImages; $i++)
            {
                $validator = Validator::make($request->all(), ['images'.$i => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',]);

                if($validator->fails())
                {
                    $product->delete();
                    return response()->json(['error' => "Картинка галереи[".$i."] не найдена или не верный формат"]);
                }

                $extension = $request['images'.$i]->extension();
                $imgaeId = Str::random(15);
                $image_name = $imgaeId . '.' . $extension;

                $path = $request['images'.$i]->storeAs('product/'.$product->id.'/galary', $image_name, 'public');
                $imagePath = '/storage/'.$path;
                array_push($imagesPath, $imagePath);
            }

            $product->galary = implode(',', $imagesPath);
        }

        if(count($galary) > 0)
            Storage::delete($galary);

        $product->save();

        ProductProperty::where('productID', $product->id)->delete();
        foreach($properties as $key => $value)
        {
            $productprop = new ProductProperty;
            $productprop->productID = $product->id;
            $productprop->propertyID = $key;
            $productprop->value = $value;
            $productprop->save();
        }
    }

    public function searchproduct($param)
    {
        if((empty($param)))
            return response()->json(['error' => "Товаров не найдено!"]);

        $products = Product::where('id', $param)
                            ->orWhere('article', $param)
                            ->orWhere('name', 'LIKE', "%{$param}%")
                            ->orderBy('id', 'desc')
                            ->get();

        if(count($products) == 0)
            return response()->json(['error' => "Товаров не найдено!"]);

        if(count($products) > 50)
            return response()->json(['error' => "Слишком много товаров, уточните"]);

        return $view = view('components.admin.product', ['products' => $products])->render();
    }
}
