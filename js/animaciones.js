const wrapper = document.querySelector('.wrapper');
const registrolink = document.querySelector('.registro-link');
const registerlink = document.querySelector('.register-link');
const btnregistro = document.querySelector('.btn-registro');
const iconClose = document.querySelector('.icon-close');
const guestlink = document.querySelector('.guest-link');
const invitadolink = document.querySelector('.invitado-link');


registerlink.addEventListener('click', () => {
    wrapper.classList.add('active');
});

registrolink.addEventListener('click', () => {
    wrapper.classList.remove('active');
});

btnregistro.addEventListener('click', () => {
    wrapper.classList.add('active-registro');
});

iconClose.addEventListener('click', () => {
    wrapper.classList.remove('active-registro');
});