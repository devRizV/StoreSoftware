var num = 0;
        var tblId = "test"; 


        function create(){ 

            var num = num+1; 

            var val = "".concat(num);     
            var row = document.createElement("tr");
            var col1 = document.createElement("td");
            var col2 = document.createElement("td");    
            var table = document.getElementById("test");

            row.appendChild(col1);
            row.appendChild(col2);


            col1.innerHTML ="";
            col2.innerHTML = "br";

            table.appendChild(row);
            }