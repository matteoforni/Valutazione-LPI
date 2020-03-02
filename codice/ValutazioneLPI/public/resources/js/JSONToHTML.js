/**
 * Funzione che consente di generare una tabella da un array JSON
 * @param {string} id L'id da assegnare alla tabella
 * @param {array} data I dati da utilizzare per creare la tabella
 * @returns La tabella HTML completa
 */
function JSONToHTML(id, data, controls){
    let table = "<table id='" + id + "' class='table text-center table-hover table-bordered'>";
    var keys = [];
    if(data.length > 0){
        table += "<thead><tr>";
        for(var k in data[0]){
            keys.push(k);
        } 
        for(var i in keys){
            if(keys[i] != 'password' ){
                table += "<th scope='col' class='font-weight-bold'>" + keys[i].charAt(0).toUpperCase() + keys[i].slice(1) + "</th>";
            }
        }
        if(controls){
            table += "<th scope='col' class='font-weight-bold'>Modifica</th>";
            table += "<th scope='col' class='font-weight-bold'>Elimina</th>";
        }
        
        table += "</tr></thead><tbody>";
        for(var i in data){
            let count = 0;
            table += "<tr id='" + data[i].id + "'>";
            for(var j in data[i]){
                if(keys[count] != 'password'){
                    table += "<td>" + data[i][keys[count]] + "</td>";
                }
                count++;
            }
            if(!data[i][keys[0]]){
                table += "<td></td><td></td>"
            }else{
                if(controls){
                    table += "<td><a class='updateField" + id + "'><i class='far fa-edit'></i></a></td>";
                    table += "<td><a class='deleteField" + id + "'><i class='far fa-trash-alt'></i></a></td>";
                }
            }
            table += "</tr>";
        }
    }
    table += "</table>";
    return table;
}