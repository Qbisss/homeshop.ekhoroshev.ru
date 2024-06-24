@php ($orders = App\Models\Order::take(100)->orderBy('id', 'desc')->get())

<div class="container">
      <div class="col-5">
        <form class="d-flex">
          <input class="form-control" type="search" placeholder="ID | Номер" aria-label="Search" name="param" id="search"/>
          <button class="btn btn-success" id="searchorder" type="submit">Поиск</button>
        </form>
      </div>
    </div>

<table class="table table-hover" id="orderstable">
    <thead>
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
    @foreach ($orders as $order)
    <tr>
        <th scope="row">{{$order->id}}</th>
        <td>{{$order->name}} {{($order->userid ? "(".$order->userid.")" : "")}}</td>
        <td>{{$order->phone}}</td>
        <td>{{$order->checkid}}</td>
        <td>{{$order->created_at}}</td>
        <td>{{$order->status}}</td>
        <td>{{$order->delivery}}</td>
        <td>{{$order->address}}</td>
        <td>
            <button type="button" class="btn btn-sm btn-success" id="btneditorder" edit="{{$order->id}}" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-pen-to-square"></i></button>
        </td>
    </tr>
    @endforeach
</tbody>

</table>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Редактирование заказа</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
        </div>
        <div class="modal-body" id="modal-body">
        </div>
      </div>
    </div>
  </div>
