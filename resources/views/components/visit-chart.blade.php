<canvas id="visitChart"></canvas>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('visitChart').getContext('2d');
        var visitChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($visitLabels),
                datasets: [{
                    label: 'Pengunjung',
                    data: @json($visitData),
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: @json($filter === 'custom_range' ? 'Waktu' : ($filter === 'this_month' || $filter === 'monthly' ? 'Bulan' : 'Hari'))
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Jumlah Pengunjung'
                        },
                        ticks: {
                            callback: function(value, index, values) {
                                if (value >= 1000) {
                                    return value / 1000 + 'K';
                                } else if (value >= 1000000) {
                                    return value / 1000000 + 'Jt';
                                } else if (value >= 1000000000) {
                                    return value / 1000000000 + 'M';
                                } else {
                                    return value;
                                }
                            }
                        }
                    }
                }
            }
        });
    });
</script>
