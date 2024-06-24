<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\Order;
use App\Models\OrderProducts;

class PanelOrderController extends Controller
{
    public function editorder($id)
    {
        $order = Order::find($id);

        if(!$order  )
            return response()->json(['error' => "Заказ не найден"]);

        $products = OrderProducts::where('orderid', $order->id)->get();
        $strproducts = "";

        foreach ($products as $product) {
            $strproducts .= '<tr id="trprod'.$product->id.'">
                <td class="align-middle">'.$product->name.' <a href="#" id="delorderproduct" product="'.$product->id.'"><i class="fa-solid fa-delete-left delproduct"></i></a></td>
                <td class="align-middle">'.$product->price.'</tb>
                <td class="align-middle">'.$product->amount.'</td>
            </tr>';
        }

        $data = '
        <form style="width: 22rem;" data-action="/editorder" id="editorder">

        <select name="orderStatus" class="form-select mb-4">
         <option selected value="'.$order->status.'">'.$order->status.'</option>
         <option value="Ожидает оплаты">Ожидает оплаты</option>
         <option value="Собран">Собран</option>
         <option value="Передан в доставку">Передан в доставку</option>
         <option value="Ожидает в магазине">Ожидает в магазине</option>
        </select>

         <table class="table table-hover">
        <thead>
      <tr>
        <th scope="col">Название товара</th>
        <th scope="col">Стоимость</th>
        <th scope="col">Количество</th>
      </tr>
    </thead>
    <tbody>
      '.$strproducts.'
    </tbody>
    </table>
        </form>

        <button type="button" class="btn btn-success" order="'.$order->id.'" id="btnsaveorder">Сохранить</button>
        <button type="button" class="btn btn-danger" order="'.$order->id.'" id="btndeleteorder">Удалить</button>
        ';

        return $data;
    }

    public function deletefromorder(Request $request)
    {

        if(!$request->id)
            return response()->json(['error' => "Заказ не найден"]);


        $product = OrderProducts::where('id', $request->id)->first();

        if(!$product)
            return response()->json(['error' => "Заказ не найден"]);

        OrderProducts::destroy($request->id);

        $count = OrderProducts::where('orderid', $product->orderid)->count();
        if($count <= 0)
        {
            Order::destroy($product->orderid);
            return response()->json(['noorder' => "В заказе не осталось товаров и он тоже удален"]);
        }


        return response()->json(['success' => "Успешно"]);
    }

    public function deleteorder(Request $request)
    {
        if(!$request->id)
            return response()->json(['error' => "Заказ не найден"]);

        $order = Order::find($request->id);

        if(!$order)
            return response()->json(['error' => "Заказ не найден"]);

        Order::destroy($order->id);
        OrderProducts::where('orderid', $order->id)->delete();

        return response()->json(['success' => "Успешно"]);
    }

    public function saveorder(Request $request)
    {
        if(!$request->id)
            return response()->json(['error' => "Заказ не найден"]);

        if(!$request->orderStatus)
            return response()->json(['error' => "Заказ не найден"]);

        $order = Order::find($request->id);

        $order->status = $request->orderStatus;
        $order->save();

        return response()->json(['success' => "Успешно"]);
    }

    public function searchorder(Request $request)
    {
        if(!$request->search)
            return response()->json(['error' => "Заказ не найден"]);

        $order = Order::where('id', $request->search)->orWhere('checkid', $request->search)->first();
        if(!$order)
            return response()->json(['error' => "Заказ не найден"]);

            $data = '<thead>
            <tr>
              <th scope="col">id</th>
              <th scope="col">ФИО (id)</th>
              <th scope="col">Телефон</th>
              <th scope="col">Номер</th>
              <th scope="col">Дата заказа</th>
              <th scope="col">Статус</th>
              <th scope="col">Доставка</th>
              <th scope="col">Адрес</th>
              <th scope="col">Действие</th>
            </tr>
          </thead>
          <tbody id="orders">
              <tr>
                  <th scope="row">'.$order->id.'</th>
                  <td>'.$order->name.' '.($order->userid ? "(".$order->userid.")" : "").'</td>
                  <td>'.$order->phone.'</td>
                  <td>'.$order->checkid.'</td>
                  <td>'.$order->created_at.'</td>
                  <td>'.$order->status.'</td>
                  <td>'.$order->delivery.'</td>
                  <td>'.$order->address.'</td>
                  <td>
                      <button type="button" class="btn btn-sm btn-success" id="btneditorder" edit="'.$order->id.'" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-pen-to-square"></i></button>
                  </td>
              </tr>';

              return response()->json(['data' => $data]);
    }
}
