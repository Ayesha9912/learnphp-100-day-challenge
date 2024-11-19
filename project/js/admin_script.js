let header = document.querySelector('.header');
console.log("Here is the js");
document.querySelector('#menu-btn').onclick = ()=>{
    console.log("click");
    header.classList.toggle('active');
}
window.onscroll = ()=>{
    header.classList.remove('active')
}
document.querySelector('.show-posts .box-container , .box , post-content').
forEach(content=>{
 if(content.innerHTML.length > 100)  content.innerHTML = content.innerHTML.slice(0, 100);
})