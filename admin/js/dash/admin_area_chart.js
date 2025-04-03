$(document).ready(function () {
    // Function to fetch tourist arrivals and update the chart
    function fetchTouristArrivals() {
        $.ajax({
            url: '../fetch_area_chart.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log("Tourist arrivals: ", data); // Log the arrivals data

                // Prepare data for the chart
                const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                const counts = Object.values(data);

                // Create the chart
                const ctx = document.getElementById('myAreaChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Tourist Arrivals',
                            data: counts,
                            backgroundColor: "rgba(78, 115, 223, 0.05)",
                            borderColor: "rgba(78, 115, 223, 1)",
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointBorderColor: "rgba(78, 115, 223, 1)",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0
                            }
                        },
                        scales: {
                            x: {
                                time: {
                                    unit: 'month'
                                },
                                grid: {
                                    display: false,
                                    drawBorder: false
                                }
                            },
                            y: {
                                ticks: {
                                    beginAtZero: true,
                                    max: 100
                                },
                                grid: {
                                    color: 'rgb(234, 236, 244)',
                                    zeroLineColor: 'rgb(234, 236, 244)',
                                    drawBorder: false
                                }
                            }
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            backgroundColor: 'rgb(255, 255, 255)',
                            bodyColor: '#858796',
                            titleColor: '#6e707e',
                            borderColor: '#dddfeb',
                            borderWidth: 1
                        }
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching tourist arrivals:', status, error);
            }
        });
    }

    // Fetch tourist arrivals on page load
    fetchTouristArrivals();
});
