@php ($users = App\Models\User::take(100)->orderBy('id', 'desc')->get())

<div class="container">
      <div class="col-5">
        <form class="d-flex">
          <input class="form-control" type="search" placeholder="ID | Телефон | email" aria-label="Search" name="param" id="search"/>
          <button class="btn btn-success" id="searchuser" type="submit">Поиск</button>
        </form>
      </div>
    </div>

<table class="table table-hover" id="userstable">
    <thead>
  <tr>
    <th scope="col">id</th>
    <th scope="col">Телефон</th>
    <th scope="col">Mail</th>
  </tr>
</thead>
<tbody>
    @foreach ($users as $user)
    <tr>
        <th scope="row">{{$user->id}}</th>
        <td>{{$user->phone}}</td>
        <td>{{$user->email}}</td>
    </tr>
    @endforeach
</tbody>
</table>
