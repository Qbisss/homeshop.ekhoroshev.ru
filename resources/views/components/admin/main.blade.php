
<div class="col-10">
<div class="row">
<div id="main-content">

@switch($page)
    @case('catalog')
        <x-adminmenu.catalog/>
        @break
    @case('order')
        <x-adminmenu.order/>
        @break

    @case('user')
        <x-adminmenu.user/>
        @break

    @case('stat')
        <x-adminmenu.stat :chartUsers="$chartUsers" :chartOrders="$chartOrders" :chartProducts="$chartProducts"/>
        @break
@endswitch

<div class="col-12 content" id="content">
</div>


</div>
</div>
</div>
