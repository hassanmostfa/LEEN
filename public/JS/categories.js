document.addEventListener('DOMContentLoaded', function () {
    // Banner image setup
    setupFileUpload(
        'drop-area-banner',
        'browse-button-banner',
        'seller_banner',
        'preview-banner'
    );

    // Logo image setup
    setupFileUpload(
        'drop-area-logo',
        'browse-button-logo',
        'seller_logo',
        'preview-logo'
    );

    // Category image setup
    setupFileUpload(
        'drop-area',
        'browse-button',
        'category_image',
        'preview'
    );

    /**
     * Function to setup the file upload for different types of images
     */
    function setupFileUpload(dropAreaId, browseButtonId, fileInputId, previewId) {
        const dropArea = document.getElementById(dropAreaId);
        const fileInput = document.getElementById(fileInputId);
        const preview = document.getElementById(previewId);
        const browseButton = document.getElementById(browseButtonId);

        // Check if the required elements are present
        if (!dropArea || !fileInput || !preview || !browseButton) {
            console.warn(`One or more elements are missing: ${dropAreaId}, ${browseButtonId}, ${fileInputId}, ${previewId}`);
            return;
        }

        // When "Browse" is clicked, trigger the file input
        browseButton.addEventListener('click', () => {
            fileInput.click();
        });

        // Handle file selection through the input element
        fileInput.addEventListener('change', function () {
            handleFiles(this.files, preview);
        });

        // Prevent default behavior for drag-and-drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        // Highlight drop area when dragging over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => {
                dropArea.classList.add('highlight');
            });
        });

        // Remove highlight when drag leaves or files are dropped
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => {
                dropArea.classList.remove('highlight');
            });
        });

        // Handle dropped files and preview them
        dropArea.addEventListener('drop', function (e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files, preview);
        });
    }

    /**
     * Function to handle file selection and display image preview
     */
    function handleFiles(files, previewElement) {
        const file = files[0];
        previewElement.innerHTML = ''; // Clear any previous preview

        if (file && file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.style.maxWidth = '100%';
            img.onload = function () {
                URL.revokeObjectURL(this.src); // Release the object URL once the image is loaded
            };
            previewElement.appendChild(img);
        } else {
            previewElement.innerHTML = '<p class="text-danger">Invalid file type. Please select an image.</p>';
        }
    }

    /**
     * Prevent default behavior for drag-and-drop events
     */
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
});

// JavaScript for image preview script
function previewImage(event) {
    const reader = new FileReader();
    const imageField = document.getElementById('category_image_preview');

    reader.onload = function() {
        if (reader.readyState === 2) {
            imageField.src = reader.result; // Set the new image source
        }
    };

    reader.readAsDataURL(event.target.files[0]); // Convert the file to a data URL
}
