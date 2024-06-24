@php( $categories = App\Models\Category::where('active', 1)->orderBy('priority')->get())

<div class="d-none d-md-block col-2 left">
<ul class="left-menu">

    @foreach ($categories as $category)
    <a href="/category/{{$category->id}}"><li>{{$category->name}}</li></a>
    @endforeach
  </ul>
</div>
