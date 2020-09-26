<script>
$(function(){
    {{$chart->id}}options = {
      type: 'line',
      data: {
        labels: [{!! $chart->formatLabels() !!}],
        datasets: [
          @foreach($chart->datasets as $dataset)
          {
            label: '{{$dataset->name}}',
            borderColor: '{!! $dataset->color !!}',
            backgroundColor: 'rgba(255, 255, 255, 0)',
            data: [{!! $dataset->formatValues() !!}],
            pointRadius: 0,
          },
          @endforeach
        ]
      },
      options: {
      	responsive: true,
        maintainAspectRatio: false,
      	tooltips: {
      		mode: 'index',
      		intersect: false,
      	},
      	hover: {
      		mode: 'nearest',
      		intersect: true
      	},
      	scales: {
      		xAxes: [{
      			display: false,
      		}],
      		yAxes: [{
      			display: true,
      		}]
      	}
      }
    }


var {{$chart->id}}canvas = document.getElementById('{{$chart->id}}');
var {{$chart->id}}ctx = {{$chart->id}}canvas.getContext('2d');
{{$chart->id}} = new Chart({{$chart->id}}ctx, {{$chart->id}}options);
var {{$chart->id}}overlay = document.getElementById('{{$chart->id}}-overlay');
var {{$chart->id}}startIndex = 0;
{{$chart->id}}overlay.width = {{$chart->id}}canvas.width;
{{$chart->id}}overlay.height = {{$chart->id}}canvas.height;
var {{$chart->id}}selectionContext = {{$chart->id}}overlay.getContext('2d');
var {{$chart->id}}selectionRect = {
  w: 0,
  startX: 0,
  startY: 0
};
var {{$chart->id}}drag = false;
{{$chart->id}}canvas.addEventListener('pointerdown', evt => {
  const points = {{$chart->id}}.getElementsAtEventForMode(evt, 'index', {
    intersect: false
  });
  {{$chart->id}}startIndex = points[0]._index;
  const rect = {{$chart->id}}canvas.getBoundingClientRect();
  {{$chart->id}}selectionRect.startX = evt.clientX - rect.left;
  {{$chart->id}}selectionRect.startY = {{$chart->id}}.chartArea.top;
  {{$chart->id}}drag = true;
  // save points[0]._index for filtering
});
{{$chart->id}}canvas.addEventListener('pointermove', evt => {

  const rect = {{$chart->id}}canvas.getBoundingClientRect();
  if ({{$chart->id}}drag) {
    const rect = {{$chart->id}}canvas.getBoundingClientRect();
    {{$chart->id}}selectionRect.w = (evt.clientX - rect.left) - {{$chart->id}}selectionRect.startX;
    {{$chart->id}}selectionContext.globalAlpha = 0.5;
    {{$chart->id}}selectionContext.clearRect(0, 0, {{$chart->id}}canvas.width, {{$chart->id}}canvas.height);
    {{$chart->id}}selectionContext.fillRect({{$chart->id}}selectionRect.startX,
      {{$chart->id}}selectionRect.startY,
      {{$chart->id}}selectionRect.w,
      {{$chart->id}}.chartArea.bottom - {{$chart->id}}.chartArea.top);
  } else {
    {{$chart->id}}selectionContext.clearRect(0, 0, {{$chart->id}}canvas.width, {{$chart->id}}canvas.height);
    var x = evt.clientX - rect.left;
    if (x > {{$chart->id}}.chartArea.left) {
      {{$chart->id}}selectionContext.fillRect(x,
        {{$chart->id}}.chartArea.top,
        1,
        {{$chart->id}}.chartArea.bottom - {{$chart->id}}.chartArea.top);
    }
  }
});
{{$chart->id}}canvas.addEventListener('pointerup', evt => {

  const points = {{$chart->id}}.getElementsAtEventForMode(evt, 'index', {
    intersect: false
  });
  {{$chart->id}}drag = false;
  $("#{{$chart->id}}-form input[name='start']").val({{$chart->id}}options.data.labels[{{$chart->id}}startIndex]);
  $("#{{$chart->id}}-form input[name='end']").val({{$chart->id}}options.data.labels[points[0]._index]);
  update_{{$chart->id}}();
});
});
</script>
