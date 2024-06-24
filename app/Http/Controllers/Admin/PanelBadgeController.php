<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Badge;

class PanelBadgeController extends Controller
{
    public function show_badge()
    {
        $data = Badge::take(50)->orderBy('id', 'desc')->get();
        return $view = view('components.admin.badge', ['badges' => $data])->render();
    }

    public function addbadge(Request $request)
    {
        $name = $request->name;
        $color = $request->color;

        if(empty($name))
            return response()->json(['error' => "Название не может быть пустым"]);

        $badge = new Badge;
        $badge->name = $name;
        $badge->color = $color;
        $badge->save();

        return response()->json(['succes' => "Успешно"]);
    }

    public function editbadge($id)
    {
        $badge = Badge::find($id);

        if(!$badge)
            return response()->json(['error' => "Бейджик не найден"]);

        $data = '
        <form style="width: 22rem;" data-action="/editbadge" id="editbadge">

        <div data-mdb-input-init class="form-outline mb-4">
        <label class="form-label" for="form5Example1">Название</label>
        <input type="text" id="form5Example1" class="form-control no-effect" name="name" value="'.$badge->name.'" />
        </div>

        <div data-mdb-input-init class="form-outline mb-4">
        <label for="exampleColorInput" class="form-label">Выберите цвет</label>
        <input type="color" name="color" class="form-control form-control-color" id="exampleColorInput" value="'.$badge->color.'" title="Выберите цвет"></div>

        <input type="hidden" name="badgeID" id="badgeID" value="'.$badge->id.'" />
        </form>

        <button type="button" class="btn btn-success" id="btnsavebadge">Сохранить</button>
        <button type="button" class="btn btn-danger" id="btndeletebadge">Удалить</button>
        ';

        return $data;
    }

    public function deletebadge(Request $request)
    {
        $badge = Badge::find($request->id);

        if(!$badge)
            return response()->json(['error' => "Бейджик не найден"]);

        $badge->delete();

        return;
    }

    public function savebadge(Request $request)
    {
        $badge = Badge::find($request->badgeID);

        if(!$badge)
            return response()->json(['error' => "Бейджик не найден"]);

        if(empty($request->name))
            return response()->json(['error' => "Название не может быть пустым"]);

        $badge->name = $request->name;
        $badge->color = $request->color;
        $badge->save();

        return;
    }
}
