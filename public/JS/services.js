document.addEventListener('DOMContentLoaded', function() {
    const steps = document.querySelectorAll('.step');
    let currentStep = 0;

    const nextStepButton = document.getElementById('nextStep');
    const prevStepButton = document.getElementById('prevStep');

    // Check if the buttons exist before adding event listeners
    if (nextStepButton) {
        nextStepButton.addEventListener('click', function() {
            if (currentStep < steps.length - 1) {
                steps[currentStep].classList.add('d-none');
                steps[++currentStep].classList.remove('d-none');
                updateButtons();
            }
        });
    }

    if (prevStepButton) {
        prevStepButton.addEventListener('click', function() {
            if (currentStep > 0) {
                steps[currentStep].classList.add('d-none');
                steps[--currentStep].classList.remove('d-none');
                updateButtons();
            }
        });
    }

    function updateButtons() {
        // Disable the "Previous" button if it's the first step
        if (prevStepButton) {
            prevStepButton.disabled = (currentStep === 0);
        }

        // Update the text and button type for the "Next" button
        if (nextStepButton) {
            if (currentStep === steps.length - 1) {
                nextStepButton.innerText = 'تأكيد'; // Change text to "تأكيد"
                nextStepButton.type = 'submit'; // Change type to "submit" for last step
            } else {
                nextStepButton.innerText = 'التالي'; // Change text to "التالي"
                nextStepButton.type = 'button'; // Change type back to "button" for intermediate steps
            }
        }
    }
});



// Gender Script
function selectOption(option) {
    // Remove 'selected' class from both cards
    document.getElementById('option-men').classList.remove('selected');
    document.getElementById('option-women').classList.remove('selected');

    // Add 'selected' class to the chosen card
    document.getElementById(`option-${option}`).classList.add('selected');

    // Update hidden input value
    document.getElementById('selectedGender').value = option;
}


// get Related Sub category
function loadSubcategories(categoryId) {
    const subcategorySelect = document.getElementById('subcategory');
    subcategorySelect.innerHTML = '<option value="" disabled selected>اختر التصنيف الفرعي</option>'; // Clear existing options

    if (!categoryId) {
        console.log('No category selected');
        return; // Exit if no category is selected
    }

    // Fetch request to get subcategories based on the selected category
    fetch(`/subcategories/${categoryId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.length === 0) {
                const option = document.createElement('option');
                option.textContent = 'لا توجد تصنيفات فرعية متاحة';
                option.disabled = true;
                subcategorySelect.appendChild(option);
            } else {
                data.forEach(subcategory => {
                    const option = document.createElement('option');
                    option.value = subcategory.id;
                    option.textContent = subcategory.name;
                    subcategorySelect.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error fetching subcategories:', error);
            alert('خطأ في تحميل التصنيفات الفرعية. الرجاء المحاولة مرة أخرى.');
        });
}

// Service Details Script
// Function to add a new item input
document.addEventListener('DOMContentLoaded', function () {
    const addItemButton = document.getElementById('add-item');
    const container = document.getElementById('array-items-container');

    if (addItemButton && container) {
        addItemButton.addEventListener('click', function() {
            const newItem = document.createElement('div');
            newItem.classList.add('array-item', 'd-flex', 'align-items-center', 'my-2');
            newItem.innerHTML = `
                <input type="text" class="form-control" name="service_details[]" placeholder="أدخل عنصر" required>
                <button type="button" class="btn btn-danger btn-sm ms-2 remove-item">ازالة</button>
            `;
            container.appendChild(newItem);
        });
    }
});


// Event delegation to handle the remove button on dynamically added items
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('array-items-container');
    
    if (container) {
        container.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-item')) {
                event.target.closest('.array-item').remove();
            }
        });
    }
});




// Handle form submission for 
document.querySelector('form').addEventListener('submit', function(event) {
    const items = [];
    const itemInputs = document.querySelectorAll('.array-item input');

    itemInputs.forEach(input => {
        const value = input.value.trim(); // Get the input value and trim whitespace
        if (value) { // Only add non-empty values to the array
            items.push(value); // Add the item to the array
        }
    });

    // At this point, 'items' contains the normal array of values
    console.log(items); // You can send this array to the server or process it further
});

// Add Employees Script
document.querySelector('form').addEventListener('submit', function(event) {
    const selectedEmployees = [];
    const checkboxes = document.querySelectorAll('#employees-container input[type="checkbox"]:checked');

    checkboxes.forEach(checkbox => {
        selectedEmployees.push(checkbox.value); // Push the selected employee name to the array
    });

    console.log(selectedEmployees); // This will output the array of selected employee names
    // You can send this array to the server or process it further
});
