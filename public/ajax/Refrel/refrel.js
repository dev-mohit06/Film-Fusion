$(document).ready(function() {
    function loadTable() {
        $.ajax({
            type: "GET",
            url: url + "admin/getAllRefrelHistroy",
            success: function(response) {
                $("#table-data").html(response);
            },
            error : function(err){
                console.log(err);
            }
        });
    }
    loadTable();
});