<h5 class="card-title">{{$chartName}}</h5>
<div class="widget-chart p-3">
    <div style="height: 200px">
        <canvas id="{{$chart->id}}"></canvas>
    </div>
</div>
@include('charts.default',["chart"=>$chart])
