<?php
include('security.php');

if (isset($_GET['tour_num']) && !empty($_GET['tour_num'])) {
    $tour_num = $_GET['tour_num'];

    // Validate that $tour_num is an integer
    if (!is_numeric($tour_num)) {
        echo "<div class='text-danger'>Invalid Tour Number</div>";
        exit;
    }

    $query = "
        SELECT 
            t.Tour_Number,
            tg.Name AS TourGuideName,
            t.Blood_Pressure AS BP,
            CONCAT(ts.FirstName, ' ', ts.LastName) AS Tourist_Name
        FROM 
            tour t
        INNER JOIN 
            tour_guide tg ON t.TourGuideID = tg.TourGuideID
        INNER JOIN 
            tourist ts ON t.TouristID = ts.TouristID
        WHERE 
            t.Tour_Number = ?
    ";
    
    
    if ($stmt = $connection->prepare($query)) {
        $stmt->bind_param("i", $tour_num);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<style>
                .text-dark-custom {
                    color: #000000 !important; /* Darker black color */
                }
                </style>";
            echo "<table class='table table-bordered'>";
            echo "<thead class='text-dark-custom'><tr><th>Tour Number</th><th>Tour Guide</th><th>Tourist Name</th><th>Blood Pressure</th></tr></thead>";
            echo "<tbody class='text-dark-custom'>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['Tour_Number']) . "</td>";
                echo "<td>" . htmlspecialchars($row['TourGuideName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Tourist_Name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['BP']) . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<div class='text-center text-warning'>No tourists found for this tour number.</div>";
        }

        $stmt->close();
    } else {
        echo "<div class='text-danger'>Error preparing the statement: " . htmlspecialchars($connection->error) . "</div>";
    }
} else {
    echo "<div class='text-danger'>Invalid request: Tour number is missing.</div>";
}
?>
