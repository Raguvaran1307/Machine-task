/*This function for show entries box click event*/
$(document).ready(function() {
// 
});

function approve(id){}
    $.ajaxSetup({ 
        headers: { 'CsrfToken': $('meta[name="csrf-token"]').attr('content') } 
      }); 
      
      var formdata = {"id": id}; 
      $.ajax({
        type : 'GET', // Type of response and matches what we said in the route
        url: '/approve', // This is the url we gave in the routex1
        dataType: 'json', 
        data: formdata, // a JSON object to send back
        success: function(response){ // What to do if we succeed
          alert("User Approved");     
        },
        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
          console.log(JSON.stringify(jqXHR));
          console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
      });
}
function reject(id){}
    $.ajaxSetup({ 
        headers: { 'CsrfToken': $('meta[name="csrf-token"]').attr('content') } 
      }); 
      
      var formdata = {"id": id}; 
      $.ajax({
        type : 'GET', // Type of response and matches what we said in the route
        url: '/reject', // This is the url we gave in the routex1
        dataType: 'json', 
        data: formdata, // a JSON object to send back
        success: function(response){ // What to do if we succeed
          alert("User Rejected");     
        },
        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
          console.log(JSON.stringify(jqXHR));
          console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
      });
}