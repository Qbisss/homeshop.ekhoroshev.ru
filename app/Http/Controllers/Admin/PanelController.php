<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

use Illuminate\Http\Request;

class PanelController extends Controller
{
    public function index()
    {

        return view("admin.panel", $this->charts());
    }

    public function change_page($page)
    {
        if($page == "stat")
        return view("admin.panel", $this->charts());
        else
        return view("admin.panel", ['page' => $page]);

    }


    public function charts()
    {
        $chart_options = [
            'chart_title' => 'Пользователи',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\User',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'line',
            'filter_field' => 'created_at',
            'filter_days' => 120
        ];

        $chartUsers = new LaravelChart($chart_options);

        $chart_options = [
            'chart_title' => 'Заказы',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Order',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'bar',
            'filter_field' => 'created_at',
            'filter_days' => 120
        ];

        $chartOrders = new LaravelChart($chart_options);

        $chart_options = [
            'chart_title' => 'Топ товаров',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\Product',
            'group_by_field' => 'name',
            'chart_type' => 'pie',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'views',
            'top_results' => 10
        ];

        $chartProducts = new LaravelChart($chart_options);


        $page = "stat";

        return compact('chartUsers','chartOrders', 'chartProducts', 'page');
    }
}
