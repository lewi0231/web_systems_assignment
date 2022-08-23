function toggle(divID){
    var di = document.getElementById(divID);
    if (di.style.opacity == 0) {
        di.style.opacity = 100;
    }else{
      di.style.opacity = 0;
    }
}