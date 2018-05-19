function fPNumberOnFocous() {
    var peronalNumber = document.getElementById('txtPersonalNumber');
    if(peronalNumber.value==='yyyymmdd-xxxx'){
    	peronalNumber.value='';
    }
}

function fPNumberOnFocousOut() {
    var peronalNumber = document.getElementById("txtPersonalNumber");
    if(peronalNumber.value===""){
    	peronalNumber.value="yyyymmdd-xxxx";
    }
}