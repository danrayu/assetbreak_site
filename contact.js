document.getElementById("contact-form").addEventListener("submit", function (e) {
    e.preventDefault(); // prevent page reload

    const formData = new FormData(this);
    
    // Get all form values as an object
    const formValues = {};
    formData.forEach((value, key) => {
        formValues[key] = value;
    });

    fetch("/contact.php", {
      method: "POST",
      body: JSON.stringify(formValues),
      headers: {
        "Content-Type": "application/json"
      },
    })
    .then((response) => {
      if (response.ok) {
        // Show success popup if the response is OK
        document.getElementById("success-popup").classList.remove("hidden");
      } else {
        console.error('Failed to send email');
      }
    })
    .catch((error) => {
      console.error('Error:', error);
    });

    // Log all the form values to the console (for debugging)
    console.log(formValues);
  });
  
// Close the popup when the user clicks the close button
document.getElementById("close-popup").addEventListener("click", function () {
    document.getElementById("success-popup").classList.add("hidden");
});
