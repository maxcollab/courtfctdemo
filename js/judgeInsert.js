const {FactomObjectDB} = require('factom-objectdb');

const db = new FactomObjectDB({
    db_id: 'factomdbtest:0.0.1', //the ID of your database
    ec_address: 'Es3k4L7La1g7CY5zVLer21H3JFkXgCBCBx8eSM2q9hLbevbuoL6a',  //Public or private EC address
});

  $(document).ready(function() {
  $("#submit").click(function(e){
     var jsonData = {};

   var formData = $("#myform").serializeArray();
  // console.log(formData);

   $.each(formData, function() {
        if (jsonData[this.name]) {
           if (!jsonData[this.name].push) {
               jsonData[this.name] = [jsonData[this.name]];
           }
           jsonData[this.name].push(this.value || '');
       } else {
           jsonData[this.name] = this.value || '';
       }


   });
   console.log(jsonData);
    $.ajax(
    {
        url : "einsert.php",
        type: "POST",
        data : jsonData,

    });
    e.preventDefault(); 
});
});

db.commitObject(jsonData._id, jsonData).then(function(storedObject){
    
}).catch(function(err){
    throw err;
});
