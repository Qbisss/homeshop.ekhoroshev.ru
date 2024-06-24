
<div class="container">
    <div class="row">
        <div class="col-6">

                    <h1>{{ $chartUsers->options['chart_title'] }}</h1>
                    {!! $chartUsers->renderHtml() !!}



        </div>
        <div class="col-6">

            <h1>{{ $chartOrders->options['chart_title'] }}</h1>
            {!! $chartOrders->renderHtml() !!}



        </div>
        <div class="col-6">

            <h1>{{ $chartProducts->options['chart_title'] }}</h1>
            {!! $chartProducts->renderHtml() !!}



        </div>

    </div>
</div>



{!! $chartUsers->renderChartJsLibrary() !!}
{!! $chartUsers->renderJs() !!}
{!! $chartOrders->renderJs() !!}
{!! $chartProducts->renderJs() !!}
