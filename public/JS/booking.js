// Start check employee availability
document.addEventListener("DOMContentLoaded", function () {
    const dateField = document.getElementById("date");
    const startTimeField = document.querySelector("input[name='start_time']");
    const endTimeField = document.querySelector("input[name='end_time']");
    const employeeSelect = document.querySelector("select[name='employee_id']");
    const sellerId = document.querySelector("input[name='seller_id']").value;

    function checkAvailability() {
        const date = dateField.value;
        const startTime = startTimeField.value;
        const endTime = endTimeField.value;

        if (date && startTime && endTime) {
            fetch("http://127.0.0.1:8000/check-employee-availability", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    date,
                    start_time: startTime,
                    end_time: endTime,
                    seller_id: sellerId
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Enable all options initially
                Array.from(employeeSelect.options).forEach(option => {
                    option.disabled = false;
                });

                // Disable busy employees and append a badge text
                data.busyEmployees.forEach(id => {
                    const option = employeeSelect.querySelector(`option[value='${id}']`);
                    if (option) {
                        option.disabled = true;

                        // Append the text indicating unavailability
                        option.innerHTML += '  (غير متاح في الوقت المحدد)';
                    }
                });
            })
            .catch(error => console.error("Error checking availability:", error));
        }
    }
    
    // Event listeners for the fields
    dateField.addEventListener("change", checkAvailability);
    startTimeField.addEventListener("change", checkAvailability);
    endTimeField.addEventListener("change", checkAvailability);
});
// End check employee availability
