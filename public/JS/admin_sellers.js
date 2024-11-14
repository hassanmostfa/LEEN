 // Function to preview the logo when selected
 function previewLogo(event) {
    const logoPreview = document.getElementById('logo-preview');
    logoPreview.src = URL.createObjectURL(event.target.files[0]);
}

// Function to preview the banner when selected
function previewBanner(event) {
    const bannerPreview = document.getElementById('banner-preview');
    bannerPreview.src = URL.createObjectURL(event.target.files[0]);
}