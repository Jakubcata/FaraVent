<h5 class="card-title">{{$chartName}}</h5>
<div class="widget-chart p-3">
    <div style="height: 200px">
          <canvas id="{{$chart->id}}-overlay" width="600" height="200px" style="position:absolute;pointer-events:none;"></canvas>
        <canvas id="{{$chart->id}}"></canvas>
    </div>
</div>
<form id="{{$chart->id}}-form">
  <div class="input-group">
    Start<input name="start" type="datetime-local" value="{{date('Y-m-d H:i:s',$chart->start)}}" class="form-control">
    End<input name="end" type="datetime-local" value="{{date('Y-m-d H:i:s',$chart->end)}}" class="form-control">
    Interval<input type="text" name="interval" value="3600" class="form-control">
    <button class="btn btn-primary">Update</button>
  </div>
</form>
<script>

function update_{{$chart->id}}(start, end){
    console.log("update",start,end)
    $.get({
        url:"{{route('sensorChart')}}",
        data:{
            api_token:"{{$currentUser->api_token}}",
            type:'{{$chart->type}}',
            start:start,
            end:end,
            diff:$("#{{$chart->id}}-form input[name='interval']").val(),
        },
        success:function(data){
            {{$chart->id}}.data.labels = data.labels;
            {{$chart->id}}.data.datasets.forEach((dataset) => {
                dataset.data = data.datasets[0];
            });
            {{$chart->id}}.update();
            $("#{{$chart->id}}-form input[name='start']").val(start);
            $("#{{$chart->id}}-form input[name='end']").val(end);
            //$("#{{$chart->id}}-script").html(data);
        },
        error:function(data){
            showToast("toast-error","Chart update error<br/>"+data.responseText, 5000);
        }
    });
}

$(function(){
    $("#{{$chart->id}}-form button").click(function(e){
        e.preventDefault();
        update_{{$chart->id}}($("#{{$chart->id}}-form input[name='start']").val(),$("#{{$chart->id}}-form input[name='end']").val());
    });
});
</script>
<div id="{{$chart->id}}-script">
@include('charts.default',["chart"=>$chart])
</div>
