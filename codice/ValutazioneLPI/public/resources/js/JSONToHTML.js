function JSONToHTML(id, data){
    let table = "<table id='" + id + "' class='table text-center table-hover table-bordered'><thead><tr>";
    var keys = [];
    if(data.length > 0){
        for(var k in data[0]){
            keys.push(k);
        } 
        for(var i in keys){
            if(keys[i] != 'password'){
                table += "<th scope='col' class='font-weight-bold'>" + keys[i].charAt(0).toUpperCase() + keys[i].slice(1) + "</th>";
            }
        }
        table += "</tr></thead><tbody>";
        for(var i in data){
            let count = 0;
            table += "<tr>";
            for(var j in data[i]){
                if(keys[count] != 'password'){
                    table += "<td>" + data[i][keys[count]] + "</td>";
                }
                count++;
            }
            table += "</tr>";
        }
    }
    
    return table;
}