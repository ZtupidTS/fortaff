function dataGarantia()
{
    if(!document.getElementById("garantia").disabled)
    {
        document.getElementById("garantia").disabled = true;
        document.getElementById("art_orcamento").checked = "checked";
    }else{
        document.getElementById("garantia").disabled = false;
        document.getElementById("art_orcamento").checked = "";
    }    
}