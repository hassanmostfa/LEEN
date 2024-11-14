// Multi Step Form

let currentStep = 1;

function nextStep() {
    if (currentStep < 3) {
        document.getElementById(`step-${currentStep}`).style.display = 'none';
        currentStep++;
        document.getElementById(`step-${currentStep}`).style.display = 'block';
    }
}

function prevStep() {
    if (currentStep > 1) {
        document.getElementById(`step-${currentStep}`).style.display = 'none';
        currentStep--;
        document.getElementById(`step-${currentStep}`).style.display = 'block';
    }
}


let map;
let marker;
let geocoder;

// Ensure the map initializes only after the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function () {
    initMap(); // Call initMap only when the DOM is ready
});

function initMap() {
    const initialLocation = { lat: 24.7136, lng: 46.6753 }; // Default location (Riyadh, Saudi Arabia)

    // Ensure the map container exists
    const mapContainer = document.getElementById('map');
    if (!mapContainer) {
        console.warn('Map container not found!');
        return;
    }

    // Initialize the map
    map = new google.maps.Map(mapContainer, {
        center: initialLocation,
        zoom: 10
    });

    // Initialize the geocoder for geocoding and reverse geocoding
    geocoder = new google.maps.Geocoder();

    // Add a click event listener on the map
    map.addListener('click', (event) => {
        const clickedLocation = event.latLng;
        setMarker(clickedLocation);
        geocodeLatLng(clickedLocation);
    });

    // Handle user input for location search
    document.getElementById('find-location').addEventListener('click', () => {
        const address = document.getElementById('address').value;
        if (address) {
            geocodeAddress(address);
        } else {
            alert("يرجى إدخال عنوان.");
        }
    });

    // Add current location button functionality
    document.getElementById('get-current-location').addEventListener('click', () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                const currentLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                setMarker(currentLocation);
                map.setCenter(currentLocation);
                geocodeLatLng(currentLocation);
            }, () => {
                alert("فشل الحصول على الموقع الحالي.");
            });
        } else {
            alert("جيودير غير مدعوم من قبل هذا المتصفح.");
        }
    });
}

// Function to set a marker on the map
function setMarker(location) {
    if (marker) {
        marker.setPosition(location);
    } else {
        marker = new google.maps.Marker({
            position: location,
            map: map
        });
    }
}

// Function to get the address from the clicked location
function geocodeLatLng(location) {
    geocoder.geocode({ location: location }, (results, status) => {
        if (status === "OK") {
            if (results[0]) {
                // Set the address value to the input field
                document.getElementById('address').value = results[0].formatted_address;
            } else {
                window.alert("لا توجد نتائج");
            }
        } else {
            window.alert("فشل الجيودير بسبب: " + status);
        }
    });
}

// Function to geocode the user input address
function geocodeAddress(address) {
    geocoder.geocode({ address: address }, (results, status) => {
        if (status === "OK") {
            const location = results[0].geometry.location;
            map.setCenter(location);
            setMarker(location);
            document.getElementById('address').value = results[0].formatted_address;
        } else {
            window.alert("فشل الجيودير للسبب التالي: " + status);
        }
    });
}


    // <!-- Add jQuery for AJAX requests -->

    $(document).ready(function () {
        $('#category').change(function () {
            var categoryId = $(this).val();
            if (categoryId) {
                $.ajax({
                    url: '/get-subcategories/' + categoryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#subcategory').empty();
                        $('#subcategory').append('<option value="">Select Subcategory</option>');
                        $.each(data, function (key, value) {
                            $('#subcategory').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#subcategory').empty();
                $('#subcategory').append('<option value="">Select Subcategory</option>');
            }
        });
    });