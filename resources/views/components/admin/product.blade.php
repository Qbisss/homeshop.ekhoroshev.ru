<div class="container">
    <div class="row">
        <div class="col-2 d-flex">
            <button type="button" id="btn-add-product" class="btn btn-success d-flex btn-add" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Добавить товар
            </button>
          </div>

      <div class="col-5">
        <form class="d-flex">
          <input class="form-control" type="search" placeholder="ID | Название | Артикул" aria-label="Search" name="param" id="search"/>
          <button class="btn btn-success" id="searchproduct" type="submit">Поиск</button>
        </form>
      </div>
    </div>
  </div>

<table class="table table-hover">
    <thead>
  <tr>
    <th scope="col">id</th>
    <th scope="col">Название</th>
    <th scope="col">Артикул</th>
    <th scope="col">Цена</th>
    <th scope="col">айдиКатегории</th>
    <th scope="col">Действие</th>
  </tr>
</thead>
<tbody>

    @foreach ($products as $product)
    <tr>
        <th scope="row">{{$product->id}}</th>
        <td>{{$product->name}}</td>
        <td>{{$product->article}}</td>
        <td>{{$product->price}}</td>
        <td>{{$product->categoryID}}</td>
        <td><button type="button" class="btn btn-sm btn-success" id="btneditproduct" edit="{{$product->id}}" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-pen-to-square"></i></button></td>
    </tr>
    @endforeach

</tbody>

</table>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Добавить товар</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
        </div>
        <div class="modal-body" id="modal-body">
        </div>
      </div>
    </div>
  </div>
