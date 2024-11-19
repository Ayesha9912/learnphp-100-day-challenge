let navbar = document.querySelector('.header .flex .navbar');
document.querySelector('#menu-btn').onclick = ()=>{
    navbar.classList.toggle('active');
    profile.classList.remove('active');
    search_form.classList.remove('active');
}
let profile = document.querySelector('.header .flex .profile');
document.querySelector('#user-btn').onclick = ()=>{
    profile.classList.toggle('active');
    navbar.classList.remove('active');
    search_form.classList.remove('active');
}
let search_form = document.querySelector('.header .flex .search-form');
document.querySelector('#search-btn').onclick = ()=>{
    search_form.classList.toggle('active');
    navbar.classList.remove('active');
    profile.classList.remove('active');
}
window.onscroll = ()=>{
    navbar.classList.remove('active');
    profile.classList.remove('active');
    search_form.classList.remove('active');
}
document.querySelectorAll('.post-grid .box-container .box .content').forEach(content =>{
   if(content.innerHTML.length > 150) content.innerHTML = content.innerHTML.slice(0,150);
})
