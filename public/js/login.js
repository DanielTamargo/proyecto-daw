let form1 = document.querySelector('#form1');
let form2 = document.querySelector('#form2');
let form1Content = form1.innerHTML;
let form2Content = form2.innerHTML;
form2.style.display = 'flex';
form2.style.justifyContent = 'center';
form2.style.alignItems = 'center';
form2.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left" viewBox="0 0 16 16">
<path d="M10 12.796V3.204L4.519 8 10 12.796zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753z"/>
</svg>`;
form2.style.cursor = 'pointer';
form2.style.filter = 'brightness(0.9)';

form2.addEventListener('click', toggleForm);
form2.addEventListener('mouseenter', hover);
form2.addEventListener('mouseleave', stopHover);

function hover(evt) {
    evt.target.style.width = '15%';
    evt.target.style.filter = 'brightness(1)';
    if(evt.target.id=='form2') {
        form1.style.filter = 'brightness(0.95)';
    } else {
        form2.style.filter = 'brightness(0.95)';
    }
}

function stopHover(evt) {
    evt.target.style.width = '10%';
    evt.target.style.filter = 'brightness(0.95)';
    if(evt.target.id=='form2') {
        form1.style.filter = 'brightness(1)';
    } else {
        form2.style.filter = 'brightness(1)';
    }
}

function toggleForm(evt) {
    form1.classList.toggle('inactiveForm');
    form2.classList.toggle('inactiveForm');
    if(evt.target.id == 'form2' || evt.target.parentElement.id == 'form2' || evt.target.parentElement.parentElement.id == 'form2') {
        
        form2.removeEventListener('click', toggleForm);
        form1.addEventListener('click', toggleForm);

        form2.removeEventListener('mouseenter', hover);
        form2.removeEventListener('mouseleave', stopHover);

        form1.addEventListener('mouseenter', hover);
        form1.addEventListener('mouseleave', stopHover);

        form2.style.cursor = null;
        form1.style.cursor = 'pointer';
        form1.style.filter = 'brightness(0.8)';
        form2.style.width = '90%';
        form1.style.width = '10%';

        form1.innerHTML = ` <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right" viewBox="0 0 16 16">
                                <path d="M6 12.796V3.204L11.481 8 6 12.796zm.659.753 5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z"/>
                            </svg>`;
        form1.style.justifyContent = 'center';
        form1.style.alignItems = 'center';

        form2.innerHTML = form2Content;

        form2.style.justifyContent = 'normal';
        form2.style.alignItems = 'normal';

        // Añadir evento comprobarDNI
        document.getElementById('dni').addEventListener('change', comprobarDNI);
        
        // Añadir eventos comprobarContrasenyas
        document.getElementById('password').addEventListener('change', comprobarContrasenyas);
        document.getElementById('password-confirm').addEventListener('change', comprobarContrasenyas);
    } else {
        form1.removeEventListener('click', toggleForm);
        form2.addEventListener('click', toggleForm);

        form1.removeEventListener('mouseenter', hover);
        form1.removeEventListener('mouseleave', stopHover);

        form2.addEventListener('mouseenter', hover);
        form2.addEventListener('mouseleave', stopHover);
        form1.style.cursor = null;
        form2.style.cursor = 'pointer';
        form2.style.filter = 'brightness(0.8)';
        form1.style.width = '90%';
        form2.style.width = '10%';

        form1.innerHTML = form1Content;
        form1.style.justifyContent = 'normal';
        form1.style.alignItems = 'normal';

        form2.innerHTML = ` <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left" viewBox="0 0 16 16">
                            <path d="M10 12.796V3.204L4.519 8 10 12.796zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753z"/>
                            </svg>`;
        form2.style.justifyContent = 'center';
        form2.style.alignItems = 'center';
    }
}