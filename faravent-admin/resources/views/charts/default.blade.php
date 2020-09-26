<script>
$(function(){
    options = {
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
      		intersect: true,
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


var canvas = document.getElementById('{{$chart->id}}');
var ctx = canvas.getContext('2d');
{{$chart->id}} = new Chart(ctx, options);
var chart = {{$chart->id}};
// var overlay = document.getElementById('{{$chart->id}}-overlay');
// var startIndex = 0;
// overlay.width = canvas.width;
// overlay.height = canvas.height;
// var selectionContext = overlay.getContext('2d');
// var selectionRect = {
//   w: 0,
//   startX: 0,
//   startY: 0
// };
// var drag = false;
// canvas.addEventListener('pointerdown', evt => {
//   const points = chart.getElementsAtEventForMode(evt, 'index', {
//     intersect: false
//   });
//   startIndex = points[0]._index;
//   const rect = canvas.getBoundingClientRect();
//   selectionRect.startX = evt.clientX - rect.left;
//   selectionRect.startY = chart.chartArea.top;
//   drag = true;
//   // save points[0]._index for filtering
// });
// canvas.addEventListener('pointermove', evt => {
//
//   const rect = canvas.getBoundingClientRect();
//   if (drag) {
//     const rect = canvas.getBoundingClientRect();
//     selectionRect.w = (evt.clientX - rect.left) - selectionRect.startX;
//     selectionContext.globalAlpha = 0.5;
//     selectionContext.clearRect(0, 0, canvas.width, canvas.height);
//     selectionContext.fillRect(selectionRect.startX,
//       selectionRect.startY,
//       selectionRect.w,
//       chart.chartArea.bottom - chart.chartArea.top);
//   } else {
//     selectionContext.clearRect(0, 0, canvas.width, canvas.height);
//     var x = evt.clientX - rect.left;
//     if (x > chart.chartArea.left) {
//       selectionContext.fillRect(x,
//         chart.chartArea.top,
//         1,
//         chart.chartArea.bottom - chart.chartArea.top);
//     }
//   }
// });
// canvas.addEventListener('pointerup', evt => {
//
//   const points = chart.getElementsAtEventForMode(evt, 'index', {
//     intersect: false
//   });
//   drag = false;
//
//   update_{{$chart->id}}(chart.data.labels[startIndex],chart.data.labels[points[0]._index]);
// });
});
</script>
