$(document).on('click', '#confirmStartTour', function () {
    $('#mainForm').submit(); // Submit form on confirmation
});


$(document).ready(function() {
    // Initialize Select2 with `dropdownParent` to ensure it displays properly in the modal
    $('#touristSelect').select2({
        placeholder: "Select a tourist",
        width: '100%',
        dropdownParent: $('#addTouristModal') // Attach dropdown to the modal
    });

    // Initialize Select2 with `dropdownParent` to ensure it displays properly in the modal
    $('#nationalitySelect').select2({
        placeholder: "Select a nationality",
        width: '100%',
        dropdownParent: $('#addtourist') // Attach dropdown to the modal
    });


    // Initialize Select2 for the Tour Guide dropdown
    $('select[name="tourguide_id"]').select2({
        placeholder: "Select a tour guide",
        width: '100%',
        dropdownParent: $('body') // Attach dropdown to the body (adjust if it's inside a modal)
    });

    // Track added tourist IDs to prevent duplicates
    let touristCount = 0;
    const maxTourists = 5;
    let addedTourists = []; // Array to track added tourist IDs

    $('#addTouristButton').click(function() {
        // Check tourist count at the start to prevent adding if the max is already reached
        if (touristCount >= maxTourists) {
            $('#limitMessage').show(); // Show the limit message
            alert("You have reached the maximum number of tourists.");
            return; // Exit early if maximum is reached
        }

        var touristSelect = $('#touristSelect');
        var touristID = touristSelect.val();
        var touristName = touristSelect.find('option:selected').text();
        var touristBP = $('#touristBP').val();

        if (touristID && touristBP) {
            // Check if the tourist is already added
            if (addedTourists.includes(touristID)) {
                alert('This tourist is already added.');
                return; // Exit if tourist is already added
            }

            // Add hidden inputs to the main form
            var mainForm = $('#mainForm');

            var hiddenTouristID = $('<input>').attr({
                type: 'hidden',
                name: 'tourist_ids[]',
                value: touristID
            });
            mainForm.append(hiddenTouristID);

            var hiddenTouristBP = $('<input>').attr({
                type: 'hidden',
                name: 'blood_pressure[]',
                value: touristBP
            });
            mainForm.append(hiddenTouristBP);

            // Add tourist information to the table
            var touristTableBody = $('#touristTableBody');
            var touristRow = $('<tr>');

            var touristNameCell = $('<td>').text(touristName);
            var touristBPCell = $('<td>').text(touristBP);

            // Remove Button
            var removeButton = $('<button>').addClass('btn btn-danger').text('Remove');
            var actionCell = $('<td>').append(removeButton);
            removeButton.click(function() {
                touristRow.remove();
                hiddenTouristID.remove();
                hiddenTouristBP.remove();
                touristCount--;
                addedTourists = addedTourists.filter(id => id !== touristID); // Remove from addedTourists
                // Show the "Save Tourist" button and hide limit message if below max limit
                if (touristCount < maxTourists) {
                    $('#addTouristButton').show();
                    $('#limitMessage').hide(); // Hide the limit message when under the max
                }
            });

            touristRow.append(touristNameCell, touristBPCell, actionCell);
            touristTableBody.append(touristRow);

            // Add the tourist ID to the addedTourists array to track it
            addedTourists.push(touristID);

            // Increment the tourist count
            touristCount++;

            // Hide the "Save Tourist" button and show limit message if max limit is reached
            if (touristCount >= maxTourists) {
                $('#addTouristButton').hide();
                $('#limitMessage').show(); // Show the limit message
            }

            // Hide the modal and reset fields
            $('#addTouristModal').modal('hide');
            touristSelect.val('').trigger('change');
            $('#touristBP').val('');
        } else {
            alert('Please select a tourist and enter their blood pressure.');
        }
    });

    $('#mainForm').on('submit', function(e) {
        var hasTourists = $('input[name="tourist_ids[]"]').length > 0;
        if (!hasTourists) {
            e.preventDefault(); // Prevent form submission
            alert('Please add at least one tourist before starting the tour.');
        } else {
            console.log("Form submitted with data:", $(this).serializeArray()); // Debugging output
        }
    });
    
});


