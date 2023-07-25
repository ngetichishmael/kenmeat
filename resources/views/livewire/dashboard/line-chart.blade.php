<div class="card">
    <canvas id="lineChartTotalOrderSale" width="800" height="400"></canvas>

    <script type="application/javascript">
        const data = @json($graphdata);
        const labels = data.map(entry => entry.month);
        const totalOrderSale = data.map(entry => entry.totalSale);

        const ctx = document.getElementById('lineChartTotalOrderSale').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Sales',
                        data: totalOrderSale,
                        borderColor: 'rgb(0, 153, 204)',
                        borderWidth: 1, // Set the line thickness here
                        fill: false,
                        tension: 0, // Set tension to zero for a straight line
                    },
                ],
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Months',
                        },
                    },
                    y: {
                        beginAtZero: true,
                        display: true,
                        title: {
                            display: true,
                            text: 'Total Sale',
                        },
                    },
                },
            },
        });
    </script>
</div>
