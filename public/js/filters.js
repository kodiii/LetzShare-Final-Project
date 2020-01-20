/* $(function() {
    // Get the form
    var form = $(".form-filters");

    // Get the messages div.
    var formMessages = $("#form-messages");

    // Get the fields
    var formUsers = $(".users");
    var formLocations = $(".locations");
    var formCategories = $(".categories");
    var formFirstDate = $("#firstdate");
    var formLastDAte = $("#lastdate");

    $(form).submit(function(event) {
        event.preventDefault();

        // Serialize form data
        var formData = $(form).serialize();
        // Submit form with ajax
        $.ajax({
            type: "POST",
            url: "/gallery",
            data: 'json'
        })
            .done(function(response) {
                // Make sure that the formMessages div has the 'success' class.
                $(formMessages).removeClass("error");
                $(formMessages).addClass("success");

                // Set the message text.
                $(formMessages).text(response);

                // Clear the form.
                $(".users").val("");
                $(".locations").val("");
                $(".categories").val("");
                $("#firstdate").val("");
                $("#lastdate").val("");
            })
            .fail(function(data) {
                // Make sure that the formMessages div has the 'error' class.
                $(formMessages).removeClass("success");
                $(formMessages).addClass("error");

                // Set the message text.
                if (data.responseText !== "") {
                    $(formMessages).text(data.responseText);
                } else {
                    $(formMessages).text("Oops! An error occured");
                }
            });
    });
}); */


$(document).ready(function() {

    // process the form
    $('form').on('submit', function(event) {
        console.log('hello Working');
        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
        /* var formData = {
            'users': $('.users').val(),
            'locations': $('.locations').val(),
            'categories': $('.categories').val(),
            'firstdate': $('#firstdate').val(),
            'lastdate': $('#lastdate').val()
        }; */

        // process the form
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : '/gallery', // the url where we want to POST
            data        : $('form').serialize(), // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode: true
        })
            // using the done promise callback
            .done(function(data) {

                // log data to the console so we can see
                console.log(data);

                // here we will handle errors and validation messages
            });
    });

});


