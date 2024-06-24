<div class="container">
    <div class="row">
        <div class="col-5 d-flex">
            <button type="button" id="btn-add-category" class="btn btn-success btn-add" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Добавить категорию
            </button>
          </div>
    </div>
  </div>

<table class="table table-hover">
    <thead>
  <tr>
    <th scope="col">id</th>
    <th scope="col">Название</th>
    <th scope="col">Приоритет</th>
    <th scope="col">Действие</th>
  </tr>
</thead>
<tbody>

    @foreach ($categories as $category)
    <tr>
        <th scope="row">{{$category->id}}</th>
        <td>{{$category->name}}</td>
        <td>{{$category->priority}}</td>
        <td><button type="button" class="btn btn-sm btn-success" id="btnedit" edit="{{$category->id}}" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-pen-to-square"></i></button></td>
    </tr>
    @endforeach

</tbody>

</table>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Добавить категорию</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
        </div>
        <div class="modal-body" id="modal-body">
        </div>
      </div>
    </div>
  </div>
