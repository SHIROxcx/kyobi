document.addEventListener("DOMContentLoaded", function() {
    const closeButton = document.querySelectorAll(".fa-times");
    const modal = document.querySelector(".products-preview");
 
    closeButton.forEach(button => {
       button.addEventListener("click", function() {
          modal.classList.toggle("active");
       });
    });
 
    const container = document.getElementById('container');
    const registerBtn = document.getElementById('register');
    const loginBtn = document.getElementById('login');
 
    registerBtn.addEventListener('click', () => {
       container.classList.add("active");
    });
 
    loginBtn.addEventListener('click', () => {
       container.classList.remove("active");
    });
 });
 