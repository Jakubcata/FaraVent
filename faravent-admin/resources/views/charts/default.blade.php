<script>
$(function(){
    new Chart($('#{{$chart->id}}'), {
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
    });
});
</script>
