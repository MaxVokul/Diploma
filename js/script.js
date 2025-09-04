const modalWindow = document.querySelector('.modal-window');
const modalWindow1 = document.getElementsByClassName('modal-window');
const modalbtn = document.getElementsByClassName('btn--show-modal-window');
const btns = document.querySelectorAll('.btn--show-modal-window')
const openModalWindow = function(e){
  e.preventDefault();
  modalWindow.classList.remove('hidden')
}
btns.forEach(element => {
    element.addEventListener('click',openModalWindow)
});

const btnsclose = document.querySelector ('.btn--close-modal-window');
const closeModalWindow = function(){
    modalWindow.classList.add('hidden')
}


btnsclose.addEventListener('click',closeModalWindow);

const closeModalWindow1 = function(e) {
    if (e.key == "Escape")(
        modalWindow.classList.add('hidden')
    )
}
document.addEventListener('keydown',closeModalWindow1);

const scrollto = document.querySelector('.btn--scroll-to');
const section1 = document.getElementById('section--1');

const body = document.querySelector('body');
scrollto.addEventListener('click',(e)=>{
    window.scrollTo({
        top: section1.getBoundingClientRect().top+window.pageYOffset,
        behavior:'smooth'
    })
})





