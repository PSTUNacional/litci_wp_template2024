/*========================================

    Nav Menu

========================================*/

window.addEventListener('scroll', ()=>{
   var scroll = window.pageYOffset;
   const nav = document.querySelector('section.menu-area')
   if(scroll> 120){
    nav.classList.add("active");
   } else {
    nav.classList.remove("active");
   }
})

// Adds chevron icon to Nav menu
menuitems = document.querySelectorAll('.sub-menu')
menuitems.forEach((s) => { s.parentElement.querySelector('a').innerHTML += '<i class="fa fa-caret-right"></i>' })