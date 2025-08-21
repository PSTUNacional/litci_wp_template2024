/*========================================

    Nav Menu

========================================*/

function openMobileMenu() {
    document.querySelector('.main-menu').classList.toggle('active');
    document.querySelector('.backdrop').classList.toggle('active');
}

function openSearch() {
    document.querySelector('.menu-search-bar').classList.toggle('active');
    document.getElementById('s').focus() 
}

window.addEventListener('scroll', ()=>{
   var scroll = window.pageYOffset;
   const nav = document.querySelector('section.menu-area')
   if(scroll> 120){
    nav.classList.add("active");
   } else {
    nav.classList.remove("active");
   }
})

function openSubitem(){
    event.stopPropagation();
    e = event.currentTarget
    console.log( e.querySelector('ul'))
    e.querySelector('ul.sub-menu').classList.toggle('active')
}

document.querySelectorAll('.menu-item-has-children').forEach(el=>{
    el.addEventListener('click', openSubitem)
})

// Adds chevron icon to Nav menu
menuitems = document.querySelectorAll('.sub-menu')
menuitems.forEach((s) => { s.parentElement.querySelector('a').innerHTML += '<i class="fa fa-caret-right"></i>' })