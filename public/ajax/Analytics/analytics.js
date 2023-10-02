function loadAnalytics(){
    $.ajax({
        type: "GET",
        url: url + "admin/getAnalyticsRecords",
        success: function (response) {
            $(".table-data").html(response);
        }
    });
}

loadAnalytics();