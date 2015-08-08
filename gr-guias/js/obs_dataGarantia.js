function dataGarantia()
{
    if(document.getElementById("garantia").style.visibility == "hidden")
    {
        document.getElementById("garantia").style.display = "";
        document.getElementById("garantia").style.visibility = "";
    }else{
        document.getElementById("garantia").style.display = "none";
        document.getElementById("garantia").style.visibility = "hidden";
    }    
}
