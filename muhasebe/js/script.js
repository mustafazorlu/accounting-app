// let tbody = document.querySelector('tbody');
// let tr = tbody.getElementsByTagName('tr');
// let select = document.querySelector('select');

// let trArray = [];
// for(let i = 0; i < tr.length; i++){
//     trArray.push(tr[i]);
// }

// select.onchange = rowCount;
// function rowCount(e){
//     let limit = parseInt(e.target.value);
//     displayPage(limit);
// }
// function displayPage(limit){
//     tbody.innerHTML = '';
//     for(let i = 0; i < limit; i++){
//         tbody.appendChild(trArray[i]);
//     }
// }



let reset = document.getElementById('reset');
let adet_input = document.getElementById('urun_adet_input');

const overlay = document.getElementById('overlay');
const times = document.getElementById('times');
const importBattery = document.getElementById('battery-data-import');

const addBrandBtn = document.getElementById('brand-overlay-btn');
const x_isareti = document.getElementById('x');
const brand_overlay = document.getElementById('brand-overlay');

const storageAllDeleteBtn = document.getElementById('storage_all_delete');
const carpi = document.getElementById('carpi');
const allDeleteOverlay = document.getElementById('all_delete_overlay');

const productPercentBtn = document.getElementById('product_percent');
const xisareti = document.getElementById('xisareti');
const product_price_box = document.getElementById('product_price_box');

const zekatbuton = document.getElementById('zekatbuton');

const xIsareti = document.getElementById('xIsareti');
const zekatBox = document.getElementById('zekatBox');

const search = document.querySelector('.search');
const rows = document.querySelectorAll('tbody tr');

const buton1 = document.getElementById('buton1');
const buton2 = document.getElementById('buton2');
const div1 = document.getElementById('main');
const div2 = document.getElementById('side');


// window.onload = function(){
//     reset.onclick = function() {
//         adet_input.value = '0';
//     }
// }

function tableSearch() {
    let input, filter, table, tr, td, txtValue;

    //Intialising Variables
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.querySelectorAll("tbody tr");

    for (let i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }

}






times.onclick = () =>{
    overlay.classList.remove('open')
}
importBattery.onclick = () =>{
    overlay.classList.add('open')
}

//------------------------------------------------------------



x_isareti.onclick = () =>{
    brand_overlay.classList.remove('open')
}
addBrandBtn.onclick = () =>{
    brand_overlay.classList.add('open')
}

//------------------------------------------------------------



carpi.onclick = () =>{
    allDeleteOverlay.classList.remove('open')
}
storageAllDeleteBtn.onclick = () =>{
    allDeleteOverlay.classList.add('open')
}

//------------------------------------------------------------



xisareti.onclick = () =>{
    product_price_box.classList.remove('open')
}
productPercentBtn.onclick = () =>{
    product_price_box.classList.add('open')
}


xIsareti.onclick = () =>{
    zekatBox.classList.remove('open')
}
zekatbuton.onclick = () =>{
    zekatBox.classList.add('open')
}



buton1.addEventListener('click',() => {
    div1.classList.toggle('tggle');
})
buton2.addEventListener('click',() => {
    div2.classList.toggle('tggle');
})









