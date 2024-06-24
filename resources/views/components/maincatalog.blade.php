<div class="container mt-5">
    <div class="row">
    @foreach ($catalog as $category)
    <div class="col-6 mb-4">
        <a href="/category/{{$category->id}}">
        <div class="img__wrap w-100">
            <img class="img__img w-100 object-fit-cover" src="{{asset($category->image)}}" />
            <p class="img__description">{{$category->name}}</p>
        </div>
        </a>
    </div>
    @endforeach
</div>
</div>
