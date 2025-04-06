<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Download Purposes Chart -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h2 class="text-2xl font-bold mb-6">Download Purposes</h2>
                <div class="w-full h-96">
                    <canvas id="purposeChart"></canvas>
                </div>
            </div>

            <!-- Most Downloaded Research Chart -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-6">Most Downloaded Research Papers</h2>
                <div class="w-full h-96">
                    <canvas id="researchChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Download Purposes Chart
        const purposeCtx = document.getElementById('purposeChart').getContext('2d');
        new Chart(purposeCtx, {
            type: 'pie',
            data: {
                labels: @json($purposeLabels),
                datasets: [{
                    data: @json($purposeData),
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });

        // Most Downloaded Research Chart
        const researchCtx = document.getElementById('researchChart').getContext('2d');
        new Chart(researchCtx, {
            type: 'bar',
            data: {
                labels: @json($researchLabels),
                datasets: [{
                    label: 'Number of Downloads',
                    data: @json($researchData),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>