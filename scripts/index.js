function gallery(){
    document.getElementById("gall").style.visibility = "visible";
    document.getElementById("about").style.visibility = "hidden";
}

function about(){
    document.getElementById("about").style.visibility = "visible";
    document.getElementById("gall").style.visibility = "hidden";
}
function edit(){
    setTimeout(function(){
    location = 'edit.php';
  },100)
}