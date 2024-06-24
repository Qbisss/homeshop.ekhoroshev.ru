<div class="container">
    <div class="row">
        <div class="col-3 d-flex">
            <button type="button" id="btn-add-property" class="btn btn-success btn-add" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Добавить свойство
            </button>
          </div>

          <div class="col-5">
            <form class="d-flex">
              <input class="form-control" type="search" placeholder="ID категории" aria-label="Search" name="param" id="search"/>
              <button class="btn btn-success" id="searchproperty" type="submit">Поиск</button>
            </form>
          </div>
    </div>
  </div>

<table class="table table-hover">
    <thead>
  <tr>
    <th scope="col">id</th>
    <th scope="col">Название</th>
    <th scope="col">Категории</th>
    <th scope="col">Действие</th>
  </tr>
</thead>
<tbody>

    @foreach ($properties as $property)
    <tr>
        <th scope="row">{{$property->id}}</th>
        <td>{{$property->name}}</td>
        <td>{{$property->categories}}</td>
        <td><button type="button" class="btn btn-sm btn-success" id="btneditproperty" edit="{{$property->id}}" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-pen-to-square"></i></button></td>
    </tr>
    @endforeach

</tbody>

</table>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Добавить свойство</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
        </div>
        <div class="modal-body" id="modal-body">
        </div>
      </div>
    </div>
  </div>
