<div class="card">
   <canvas id="lineChart" width="800" height="400"></canvas>

   <script type="application/javascript">
       const data = @json($graphdata);
       const labels = data.map(entry => entry.month);

       console.log(data);
       const preOrderCounts = data.map(entry => entry.preOrderCount);
       const deliveryCounts = data.map(entry => entry.deliveryCount);

       const ctx = document.getElementById('lineChart').getContext('2d');
       new Chart(ctx, {
           type: 'line',
           data: {
               labels: labels,
               datasets: [{
                       label: 'Deliveries',
                       data: preOrderCounts,
                       borderColor: 'rgb(139,0,0)',
                       borderWidth: 1, // Set the line thickness here
                       fill: false
                   },
                   {
                       label: 'Pre Orders',
                       data: deliveryCounts,
                       borderColor: 'rgb(0, 153, 204)',
                       borderWidth: 1, // Set the line thickness here
                       fill: false
                   }
               ]
           },
           options: {
               responsive: true,
               scales: {
                   x: {
                       display: true,
                       title: {
                           display: true,
                           text: 'Months'
                       }
                   },
                   y: {
                       beginAtZero: true,
                       min: 50,
                       max: Math.ceil(Math.max(...preOrderCounts, ...deliveryCounts) / 50) * 50,
                       ticks: {
                           stepSize: 50
                       },
                       display: true,
                       title: {
                           display: true,
                           text: 'Count'
                       }
                   }
               }
           }
       });
   </script>
</div>
