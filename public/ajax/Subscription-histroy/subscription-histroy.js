$(document).ready(function () {
    function loadSubscriptions(){
        $.ajax({
            type: "GET",
            url: url + "admin/getAllSubscription",
            success: function (response) {
                $(".table-data").html(response);
            },
            error : function(err){
                console.log(err);
            }
        });
    }
    loadSubscriptions();
});