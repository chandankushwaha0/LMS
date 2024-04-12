function previewImage(event) {
    var input = event.target;
    var preview = document.getElementById('preview');
    var imageName = document.getElementById('imageName');
    // Check if a file is selected
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            // Display selected image
            preview.src = e.target.result;
            preview.style.display = 'block';
            // Display image name
            imageName.innerText = input.files[0].name;
        }
        reader.readAsDataURL(input.files[0]); // Read the image file as a data URL
    } else {
        // Clear preview if no file is selected
        preview.src = '#';
        preview.style.display = 'none';
        imageName.innerText = '';
    }
}


function handleHideShowPassword() {
    const togglePassword = document
        .querySelector('#togglePassword');
    const password = document.querySelector('#password');
    togglePassword.addEventListener('click', () => {
        // Toggle the type attribute using
        // getAttribure() method
        const type = password
            .getAttribute('type') === 'password' ?
            'text' : 'password';
        password.setAttribute('type', type);
    });


    const togglePassword2 = document
        .querySelector('#togglePassword2');
    const password2 = document.querySelector('#password2');
    togglePassword2.addEventListener('click', () => {
        // Toggle the type attribute using
        // getAttribure() method
        const type = password2
            .getAttribute('type') === 'password' ?
            'text' : 'password';
        password2.setAttribute('type', type);
    });
}


function messagePopupHandle(msg) {
    const popups = document.querySelectorAll(".popup");
    popups.forEach(function( popup) {
            popup.classList.add('d-block');
            popup.classList.remove('d-none');
            document.getElementById('message').innerText = msg;
            const popupOks = document.querySelectorAll('.popupOk');
            popupOks.forEach(function( popupOk ) {
                popupOk.addEventListener('click', function() {
                    popup.classList.remove('d-block');
                    popup.classList.add('d-none');
                })
            })
        })
}

window.addEventListener("load", function() {
    // handleHideShowPassword();
    // messagePopupHandle(msg);
})
