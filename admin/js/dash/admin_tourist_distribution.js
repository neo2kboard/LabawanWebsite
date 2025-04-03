$(document).ready(function () {
    // Define colors for different tourist types
    const colors = {
        'Local Mabini': 'bg-info',
        'Local Bohol': 'bg-primary',
        'International Asia': 'bg-danger',
        'Regional Cebu': 'bg-warning',
        'Regional Manila': 'bg-warning',
        'Foreign': 'bg-danger'
    };

    // Function to fetch tourist distribution
    function fetchTouristDistribution() {
        $.ajax({
            url: '../fetch_tourist_distribution.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log("Tourist distribution: ", data); // Log the distribution data

                // Clear existing progress bars
                $('#touristDistribution').empty();

                // Add new progress bars
                data.forEach(function (dist) {
                    const colorClass = colors[dist.tourist_type] || 'bg-secondary'; // Default color if no match found
                    var progressBarHtml = `
                        <h4 class="small font-weight-bold">${dist.tourist_type} <span class="float-right">${dist.percentage.toFixed(2)}%</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar ${colorClass}" role="progressbar" style="width: ${dist.percentage}%" aria-valuenow="${dist.percentage}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    `;
                    $('#touristDistribution').append(progressBarHtml);
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching tourist distribution:', status, error);
            }
        });
    }

    // Fetch tourist distribution on page load
    fetchTouristDistribution();
});