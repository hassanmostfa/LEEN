// Handle drag and drop event
function handleDrop(event) {
    event.preventDefault();
    const file = event.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        previewImage(file);
        $('#seller_logo')[0].files = event.dataTransfer.files; // Assign the dropped file to the input
    }
}

// Handle file input change (when user selects file through the browse button)
function handleFileSelect(input) {
    const file = input.files[0];
    if (file && file.type.startsWith('image/')) {
        previewImage(file);
    }
}

// Preview image in the drop area
function previewImage(file) {
    const reader = new FileReader();
    reader.onload = function(event) {
        const previewContainer = $('#preview-logo');
        previewContainer.empty(); // Clear any existing content
        const imgElement = $('<img>', {
            src: event.target.result,
            class: 'img-fluid',
            style: 'max-height: 150px; max-width: 100%;'
        });
        previewContainer.append(imgElement);
    };
    reader.readAsDataURL(file);
}