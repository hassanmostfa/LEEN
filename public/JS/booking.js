// Start check employee availability
document.addEventListener("DOMContentLoaded", function () {
    const dateField = document.getElementById("date");
    const startTimeField = document.getElementById("start_time");
    const employeeSelect = document.querySelector("select[name='employee_id']");
    const sellerId = document.querySelector("input[name='seller_id']").value;

    function checkAvailability() {
        const date = dateField.value;
        const startTime = startTimeField.value;

        if (date && startTime) {
            fetch("/check-employee-availability", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    date,
                    start_time: startTime,
                    seller_id: sellerId
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Enable all options initially and remove any previous unavailability messages
                Array.from(employeeSelect.options).forEach(option => {
                    option.disabled = false;
                    option.textContent = option.textContent.replace(" (غير متاح في الوقت المحدد)", "");
                });

                if (data.busyEmployees && data.busyEmployees.length > 0) {
                    // Disable busy employees and append a badge text
                    data.busyEmployees.forEach(id => {
                        const option = employeeSelect.querySelector(`option[value='${id}']`);
                        if (option) {
                            option.disabled = true;
                            option.textContent += " (غير متاح في الوقت المحدد)";
                        }
                    });
                } else {
                    console.log("No employees are busy at this time.");
                }
            })
            .catch(error => console.error("Error checking availability:", error));
        } else {
            console.warn("Date or Start Time is missing.");
        }
    }

    // Event listeners for the fields
    dateField.addEventListener("change", checkAvailability);
    startTimeField.addEventListener("change", checkAvailability);
});
// End check employee availability


// get work days 
document.addEventListener("DOMContentLoaded", function () {
    const sellerId = document.querySelector("input[name='seller_id']").value;
    const dateField = document.getElementById("date");

    // Fetch the seller's active weekdays
    fetch(`/seller/${sellerId}/active-weekdays`)
        .then(response => response.json())
        .then(data => {
            const activeDays = data.activeDays;

            // Map active days to day indices
            const dayIndices = activeDays.map(day => {
                switch (day) {
                    case 'Sunday': return 0;
                    case 'Monday': return 1;
                    case 'Tuesday': return 2;
                    case 'Wednesday': return 3;
                    case 'Thursday': return 4;
                    case 'Friday': return 5;
                    case 'Saturday': return 6;
                    default: return null;
                }
            }).filter(index => index !== null);

            // Initialize Flatpickr with the enabled weekdays
            flatpickr(dateField, {
                dateFormat: "Y-m-d", // Ensure the format matches your date field format
                disable: [
                    function(date) {
                        // Disable all dates that don't match the active weekdays
                        return !dayIndices.includes(date.getDay());
                    }
                ]
            });
        })
        .catch(error => console.error('Error fetching active weekdays:', error));
});


// check availabe times
document.addEventListener("DOMContentLoaded", function () {
    const dateField = document.getElementById("date");
    const startTimeField = document.getElementById("start_time");
    const sellerId = document.querySelector("input[name='seller_id']").value;

    function checkTimeAvailability() {
        const date = dateField.value;
        
        if (date) {
            fetch("/check-available-times", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    date,
                    seller_id: sellerId
                })
            })
            .then(response => response.json())
            .then(data => {
                // Clear the existing options
                startTimeField.innerHTML = '';

                if (data.availableTimes.length === 0) {
                    const option = document.createElement('option');
                    option.textContent = 'لا يوجد أوقات متاحة لهذا اليوم';
                    startTimeField.appendChild(option);
                } else {
                    // Populate the available times based on the timetable
                    data.availableTimes.forEach(time => {
                        const option = document.createElement('option');
                        option.value = time;
                        option.textContent = time;
                        startTimeField.appendChild(option);
                    });
                }
            })
            .catch(error => console.error("Error checking availability:", error));
        }
    }

    // Event listener for date change
    dateField.addEventListener("change", checkTimeAvailability);
});
