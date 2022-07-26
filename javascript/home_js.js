

let openBtn = document.querySelector('.fa-bars');
let closeBtn = document.querySelector('.fa-times');
let sideBar = document.querySelector('#sidebar');


openBtn.addEventListener('click', function() {
    sideBar.classList.remove('show');
   
})

closeBtn.addEventListener('click', function(){
    sideBar.classList.add('show');
})