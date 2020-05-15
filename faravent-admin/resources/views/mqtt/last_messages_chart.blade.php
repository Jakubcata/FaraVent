<h5 class="card-title">Last messages</h5>
<div class="widget-chart p-3">
    <div style="height: 200px">
        <canvas id="{{$lastMessagesChart->id}}"></canvas>
    </div>
</div>
@include('charts.default',["chart"=>$lastMessagesChart])
