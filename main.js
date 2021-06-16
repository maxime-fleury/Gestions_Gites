var view = document.querySelector('.view');
var rond = document.querySelector('.rond');
let test = document.getElementById('test');

test.addEventListener('click', changeDiv);


function changeDiv(){
    view.setAttribute ("style" , "display:flex");
    

}

rond.addEventListener('click', closeWindow);

function closeWindow(){
    view.setAttribute ("style" , "display:none; animation:out 3s ease 0s 1 normal forwards");
}

