function creerChampsAutre(){
    if(document.getElementById('ModifStatut').options[document.getElementById('ModifStatut').selectedIndex].id==="autre") {
        const champSup = document.createElement("input");
        champSup.type="text";
        champSup.name = "champsAutre";
        champSup.id = "champsAutre";
        champSup.placeholder = "Autre statut";
        champSup.required = true;
        document.getElementById("statut").appendChild(champSup);
    }else{
        if (document.getElementById("champsAutre")!== null){
            document.getElementById("statut").removeChild(document.getElementById("champsAutre"));
        }
    }

}