function creerChampsAutre(){
    if(document.getElementById('ModifStatut').options[document.getElementById('ModifStatut').selectedIndex].id==="autre") {
        const champSup = document.createElement("input");
        champSup.type="text";
        champSup.name = "champsAutre";
        champSup.id = "champsAutre";
        champSup.placeholder = "Autre statut"
        document.getElementById("statut").appendChild(champSup);

        console.log("autre selectionner");
        console.log(champSup);
    }else{
        if (document.getElementById("champsAutre")!== null){
            document.getElementById("statut").removeChild(document.getElementById("champsAutre"));
        }
    }

}