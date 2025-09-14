const navBar = document.querySelector('.header')

function observe(entries){
    if(entries[0].isIntersecting){
        navBar.classList.add('sticky')
    }
    if(!entries[0].isIntersecting){
        navBar.classList.remove('sticky')
    }
}

const observer = new IntersectionObserver(observe,{
    threshold:[0],
    rootMargin:'100px'
})
observer.observe(navBar)



