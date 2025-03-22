// script.js
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
  
    if (form) {
      form.addEventListener('submit', (event) => {
        const applicantName = document.getElementById('applicant_name').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();
  
        // Basic validation
        if (!applicantName || !email || !phone) {
          event.preventDefault();
          alert('Please fill out all fields before submitting.');
        } else if (!/^\S+@\S+\.\S+$/.test(email)) {
          event.preventDefault();
          alert('Please enter a valid email address.');
        } else if (!/^\d{10}$/.test(phone)) {
          event.preventDefault();
          alert('Please enter a valid 10-digit phone number.');
        }
      });
    }
  });
  