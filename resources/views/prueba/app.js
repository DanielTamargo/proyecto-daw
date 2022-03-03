let form1 = document.querySelector('#form1');
let form2 = document.querySelector('#form2');
form2.style.cursor = 'pointer';
form2.style.filter = 'brightness(0.6)';

form2.addEventListener('click', toggleForm);
form2.addEventListener('mouseenter', hover);
form2.addEventListener('mouseleave', stopHover);

function hover(evt) {
    evt.target.style.width = '10%';
    evt.target.style.filter = 'brightness(1)';
    if(evt.target.id=='form2') {
        form1.style.filter = 'brightness(0.6)';
    } else {
        form2.style.filter = 'brightness(0.6)';
    }
}

function stopHover(evt) {
    evt.target.style.width = '5%';
    evt.target.style.filter = 'brightness(0.6)';
    if(evt.target.id=='form2') {
        form1.style.filter = 'brightness(1)';
    } else {
        form2.style.filter = 'brightness(1)';
    }
}

function toggleForm(evt) {
    if(evt.target.id == 'form2') {
        form2.removeEventListener('click', toggleForm);
        form1.addEventListener('click', toggleForm);

        form2.removeEventListener('mouseenter', hover);
        form2.removeEventListener('mouseleave', stopHover);

        form1.addEventListener('mouseenter', hover);
        form1.addEventListener('mouseleave', stopHover);

        form2.style.cursor = null;
        form1.style.cursor = 'pointer';
        form1.style.filter = 'brightness(0.6)';
        form2.style.width = '95%';
        form1.style.width = '5%';
    } else {
        form1.removeEventListener('click', toggleForm);
        form2.addEventListener('click', toggleForm);

        form1.removeEventListener('mouseenter', hover);
        form1.removeEventListener('mouseleave', stopHover);

        form2.addEventListener('mouseenter', hover);
        form2.addEventListener('mouseleave', stopHover);
        form1.style.cursor = null;
        form2.style.cursor = 'pointer';
        form2.style.filter = 'brightness(0.6)';
        form1.style.width = '95%';
        form2.style.width = '5%';
    }
}