// Ejecutando funciones al cargar
document.getElementById("btn__iniciar-sesion").addEventListener("click", iniciarSesion);
document.getElementById("btn__registrarse").addEventListener("click", register);
window.addEventListener("resize", anchoPage);

// Declarando variables
var formulario_login = document.querySelector(".formulario__login");
var formulario_register = document.querySelector(".formulario__register");
var contenedor_login_register = document.querySelector(".contenedor__login-register");
var caja_trasera_login = document.querySelector(".caja__trasera-login");
var caja_trasera_register = document.querySelector(".caja__trasera-register");

// Llamada inicial
anchoPage();
iniciarSesion(); // Corrige bug visual inicial

// FUNCIONES DE DISEÑO RESPONSIVO

function anchoPage() {
    if (window.innerWidth > 850) {
        caja_trasera_register.style.display = "block";
        caja_trasera_login.style.display = "block";
    } else {
        caja_trasera_register.style.display = "block";
        caja_trasera_register.style.opacity = "1";
        caja_trasera_login.style.display = "none";
        formulario_login.style.display = "block";
        contenedor_login_register.style.left = "0px";
        formulario_register.style.display = "none";
    }
}

function iniciarSesion() {
    if (window.innerWidth > 850) {
        formulario_login.style.display = "block";
        contenedor_login_register.style.left = "10px";
        formulario_register.style.display = "none";
        caja_trasera_register.style.opacity = "1";
        caja_trasera_login.style.opacity = "0";
    } else {
        formulario_login.style.display = "block";
        contenedor_login_register.style.left = "0px";
        formulario_register.style.display = "none";
        caja_trasera_register.style.display = "block";
        caja_trasera_login.style.display = "none";
    }
}

function register() {
    if (window.innerWidth > 850) {
        formulario_register.style.display = "block";
        contenedor_login_register.style.left = "410px";
        formulario_login.style.display = "none";
        caja_trasera_register.style.opacity = "0";
        caja_trasera_login.style.opacity = "1";
    } else {
        formulario_register.style.display = "block";
        contenedor_login_register.style.left = "0px";
        formulario_login.style.display = "none";
        caja_trasera_register.style.display = "none";
        caja_trasera_login.style.display = "block";
        caja_trasera_login.style.opacity = "1";
    }
}

// VALIDACIÓN FORMULARIO DE REGISTRO CON SWEETALERT
document.addEventListener("DOMContentLoaded", function () {
    const formRegister = document.getElementById("form-register");

    if (formRegister) {
        formRegister.addEventListener("submit", function (e) {
            e.preventDefault();

            const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            const email = formRegister.querySelector("input[name='email']").value.trim();
            const nombre = formRegister.querySelector("input[name='first_name']").value.trim();
            const username = formRegister.querySelector("input[name='username']").value.trim();
            const password = formRegister.querySelector("input[name='password']").value.trim();
            const confirmPassword = formRegister.querySelector("input[name='confirm_password']").value.trim();

            if (email === "" || !emailRegex.test(email)) {
                Swal.fire("¡Error!", "Por favor introduce un correo válido.", "error");
                return;
            }
            if (nombre === "") {
                Swal.fire("¡Error!", "Por favor introduce tu nombre completo.", "error");
                return;
            }
            if (username === "") {
                Swal.fire("¡Error!", "Por favor introduce un nombre de usuario.", "error");
                return;
            }
            if (password === "") {
                Swal.fire("¡Error!", "Por favor introduce una contraseña.", "error");
                return;
            }
            if (password !== confirmPassword) {
                Swal.fire("¡Error!", "Las contraseñas no coinciden.", "error");
                return;
            }

            // Confirmación con SweetAlert
            Swal.fire({
                title: "¿Registrar cuenta?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Registrar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    // ✅ Envía el formulario si confirmas
                    formRegister.submit();
                }
            });
        });
    }
});
