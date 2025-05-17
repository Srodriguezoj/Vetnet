document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        form.addEventListener('submit', function (event) {
            let valid = true;
            const inputs = form.querySelectorAll('input');
            inputs.forEach(input => {
                input.classList.remove('is-invalid');
                const errorContainer = input.parentElement.querySelector('.invalid-feedback');
                if (errorContainer) {
                    errorContainer.textContent = '';
                }
            });
            inputs.forEach(input => {
                const value = input.value.trim();

                switch (input.id) {
                    case 'name':
                    case 'surname':
                        if (value.length > (input.id === 'name' ? 100 : 250)) {
                            setError(input, 'Máximo 250 caracteres');
                            valid = false;
                        } else if (!/^[\p{L}\s\-]+$/u.test(value)) {
                            setError(input, 'Solo debe contener letras');
                            valid = false;
                        }
                        break;

                    case 'email':
                        if (value.length > 200) {
                            setError(input, 'Máximo 200 caracteres');
                            valid = false;
                        } else if (!/^[^@\s]+@[^@\s]+\.(com|es|org|net|edu|gov|info)$/i.test(value)) {
                            setError(input, 'El correo debe tener un formato válido');
                            valid = false;
                        }
                        break;

                    case 'dni':
                        if (value.length !== 9 || !/^[0-9]{8}[A-Za-z]$/.test(value)) {
                            setError(input, 'El DNI debe tener 8 números y una letra');
                            valid = false;
                        }
                        break;

                    case 'phone':
                        if (value && !/^\d{9}$/.test(value)) {
                            setError(input, 'El teléfono debe tener exactamente 9 dígitos.');
                            valid = false;
                        }
                        break;

                    case 'postcode':
                        if (value && !/^\d{1,5}$/.test(value)) {
                            setError(input, 'El código postal debe tener hasta 5 dígitos.');
                            valid = false;
                        }
                        break;

                    case 'password':
                        if (value.length < 8 || value.length > 200) {
                            setError(input, 'La contraseña debe tener al menos 8 caracteres');
                            valid = false;
                        } else if (!/[a-z]/.test(value) || !/[A-Z]/.test(value) || !/[0-9]/.test(value)) {
                            setError(input, 'Debe contener al menos una minúscula, una mayúscula y un número');
                            valid = false;
                        }
                        break;

                    case 'password_confirmation':
                        const pass = form.querySelector('#password');
                        if (pass && pass.value !== value) {
                            setError(input, 'Las contraseñas no coinciden');
                            valid = false;
                        }
                        break;
                }
            });

            if (!valid) {
                event.preventDefault();
            }
        });
    });

    function setError(input, message) {
        input.classList.add('is-invalid');
        let error = input.parentElement.querySelector('.invalid-feedback');
        if (!error) {
            error = document.createElement('div');
            error.className = 'invalid-feedback';
            input.parentElement.appendChild(error);
        }
        error.textContent = message;
    }
});
