<div class="mb-3 card">
    <div class="card-header-tab card-header">
        <div class="card-header-title">
            <i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"> </i>
            MQTT štatistika správ
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade active show" id="tab-eg-55">
            <div class="widget-chart p-3">
                <div style="height: 200px">
                    <canvas id="messages-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var labels = [{!! implode(",",array_keys(Helper::formatChart($mqtt_sent_counts))) !!}];
var data = {
  labels: labels,
  datasets: [
    {
      label: 'Received messages',
      borderColor: 'rgb(255, 159, 64)',
      backgroundColor: 'rgba(255, 255, 255, 0)',
      data: [{!! implode(",",array_values(Helper::formatChart($mqtt_received_counts))) !!}],
    },
    {
      label: 'Sent messages',
      borderColor: 'rgb(54, 162, 235)',
      backgroundColor: 'rgba(255, 255, 255, 0)',
      data: [{!! implode(",",array_values(Helper::formatChart($mqtt_sent_counts))) !!}],
    },
  ]
};
var options= {
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
			scaleLabel: {
				display: false,
				labelString: 'Month'
			}
		}],
		yAxes: [{
			display: true,
			scaleLabel: {
				display: true,
				labelString: 'Value'
			}
		}]
	}
};

new Chart($('#messages-chart'), {
  type: 'line',
  data: data,
  options: options
});


</script>
