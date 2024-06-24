<div class="container">
    <div class="row">
        <div class="col-3 d-flex">
            <button type="button" id="btn-add-badge" class="btn btn-success btn-add" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Добавить бейджик
            </button>
          </div>
    </div>
  </div>

<table class="table table-hover">
    <thead>
  <tr>
    <th scope="col">id</th>
    <th scope="col">Название</th>
    <th scope="col">Цвет</th>
    <th scope="col">Действие</th>
  </tr>
</thead>
<tbody>

    @foreach ($badges as $badge)
    <tr>
        <th scope="row">{{$badge->id}}</th>
        <td>{{$badge->name}}</td>
        <td style="color:{{$badge->color}};">{{$badge->color}}</td>
        <td><button type="button" class="btn btn-sm btn-success" id="btneditbadge" edit="{{$badge->id}}" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-pen-to-square"></i></button></td>
    </tr>
    @endforeach

</tbody>

</table>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Добавить бейдж</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
        </div>
        <div class="modal-body" id="modal-body">
        </div>
      </div>
    </div>
  </div>
