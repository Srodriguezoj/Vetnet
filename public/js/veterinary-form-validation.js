document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('form[data-validate]');

    forms.forEach(form => {
        form.addEventListener('submit', function (event) {
            let valid = true;
            const inputs = form.querySelectorAll('input, select, textarea');

            inputs.forEach(input => {
                const value = input.value.trim();
                const errorContainer = input.parentElement.querySelector('.invalid-feedback');
                input.classList.remove('is-invalid');
                if (errorContainer) {
                    errorContainer.textContent = '';
                }
                if (input.hasAttribute('required') && value === '') {
                    setError(input, 'Este campo es obligatorio');
                    valid = false;
                    return;
                }
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

                    case 'collegiate_num':
                        if (value.length > 10 || !/^\d+$/.test(value)) {
                            setError(input, 'Debe ser un número de hasta 10 dígitos');
                            valid = false;
                        }
                        break;
                }
            });

            if (!valid) event.preventDefault();
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
