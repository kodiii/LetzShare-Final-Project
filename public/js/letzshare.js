$(function() {
    /* Registration password validation*/

    $("#password").on("focus", function() {
        $("#pswd_info").css("display", "block");
    });
    $("#password").on("blur", function() {
        $("#pswd_info").css("display", "none");
    });

    $("#password").on("keyup", checkAllCases);
    function checkAllCases() {
        // Gathering : checked the password value
        const thePass = $("#password").val();
        const lengthValid = thePass.length >= 8;
        // at least one letter str.match(/[A-z]/)
        const letterValid = !!thePass.match(/[A-z]/);
        // at least one Capital letter str.match(/[A-Z]/)
        const upperValid = thePass.match(/[A-Z]/); //null or smth
        // at least one number str.match(/\d/)
        const numberValid = thePass.match(/\d/);
        //display *4
        displayValid("#letter", letterValid);
        displayValid("#length", lengthValid);
        displayValid("#capital", upperValid);
        displayValid("#number", numberValid);

        //prettier-ignore
        if(letterValid && lengthValid && upperValid && numberValid)
            $('#pswd_info').hide(250);
    }

    function displayValid(selector, condition) {
        if (condition) {
            $(selector)
                .addClass("valid")
                .removeClass("invalid");
        } else {
            $(selector)
                .addClass("invalid")
                .removeClass("valid");
        }
    }
    /* End of the Registration password validation*/

    /* Start of the Like-click listener */

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $(".liked").on("click", function(e) {
        event.preventDefault();
        let $targetDivId = this.id;
        let like = true;
        $.ajax({
            method: "POST",
            url: "/like",
            data: { isLiked: like, photoId: this.id }
        }).done(function(count) {
            // Change the page
            $("#" + $targetDivId).toggleClass("not-liked");
            $("#" + $targetDivId).toggleClass("liked");
            $("#" + $targetDivId + "> .fa-heart").toggleClass("fas");
            $("#" + $targetDivId + "> .fa-heart").toggleClass("far");
            $("#" + $targetDivId + "> .likes-number").text(count);
        });
    });
    $(".not-liked").on("click", function(e) {
        event.preventDefault();
        let $targetDivId = this.id;
        let like = true;
        $.ajax({
            method: "POST",
            url: "/like",
            data: { isLiked: like, photoId: this.id }
        }).done(function(count) {
            // Change the page
            $("#" + $targetDivId).toggleClass("liked");
            $("#" + $targetDivId).toggleClass("not-liked");
            $("#" + $targetDivId + "> .fa-heart").toggleClass("far");
            $("#" + $targetDivId + "> .fa-heart").toggleClass("fas");
            $("#" + $targetDivId + "> .likes-number").text(count);
        });
    });

    /* End of the Like-click listener */

    /* Start of the Report-click listener */

    $(".reported").on("click", function(e) {
        event.preventDefault();
        let $targetDivId = this.id;
        let like = false;
        $.ajax({
            method: "POST",
            url: "/like",
            data: { isLiked: like, photoId: this.id }
        }).done(function() {
            console.log("done unreporting");
            console.log($targetDivId);
            // Change the page
            $("#" + $targetDivId).toggleClass("not-reported");
            $("#" + $targetDivId).toggleClass("reported");
            $("#" + $targetDivId + "> .fa-flag").toggleClass("fas");
            $("#" + $targetDivId + "> .fa-flag").toggleClass("far");
            $("#" + $targetDivId + "> .rep-text").toggleClass("hide");
        });
    });
    $(".not-reported").on("click", function(e) {
        event.preventDefault();
        let $targetDivId = this.id;
        let like = false;
        $.ajax({
            method: "POST",
            url: "/like",
            data: { isLiked: like, photoId: this.id }
        }).done(function() {
            console.log("done reporting");
            console.log($targetDivId);
            // Change the page
            $("#" + $targetDivId).toggleClass("reported");
            $("#" + $targetDivId).toggleClass("not-reported");
            $("#" + $targetDivId + "> .fa-flag").toggleClass("far");
            $("#" + $targetDivId + "> .fa-flag").toggleClass("fas");
            //  $('#' + $targetDivId + '> .rep-text').text('Reported');
            $("#" + $targetDivId + "> .rep-text").toggleClass("hide");
        });
    });

    /* End of the Report-click listener */

    /* Upload file field --> show selected name */
    $("#foto").on("change", function() {
        //replace the "Choose a file" label
        var newFileName = $(this)[0].files[0].name;
        $(this)
            .next(".custom-file-label")
            .html(newFileName);
    });
    /* END of Upload file field --> show selected name */

    /*Edit User Profile Name */
    $("#editName").on("click", function() {
        $(".old-name").addClass("hide");
        $("#editName").addClass("hide");
        $(".div-edit-name").removeClass("hide");
    });

    $(".cancel-edit").on("click", function() {
        $(".old-name").removeClass("hide");
        $("#editName").removeClass("hide");
        $(".div-edit-name").addClass("hide");
    });
    /*Ajax call to edit NAME profil*/
    $(".edit-name").on("submit", function(event) {
        event.preventDefault();
        let id = $(".user_id").val();
        $.ajax({
            url: "/userprofile/" + id,
            type: "post",
            data: $("form").serialize(),
            success: function(result) {
                if (result.success) {
                    $(".success-profile").removeClass("hide");
                    $(".successMsg").text(result.success);
                    $(".old-name").removeClass("hide");
                    $("#editName").removeClass("hide");
                    $(".div-edit-name").addClass("hide");
                    $(".older-name").text(result.name);
                    $(".nav-name").text(result.name);
                    setTimeout(function() {
                        $(".success-profile").hide(500);
                    }, 2000);
                } else {
                    $(".errors-profile").removeClass("hide");
                    $.each(result.errors, function(key, value) {
                        $(".errorMsg").text(value);
                    });
                    setTimeout(function() {
                        $(".errors-profile").hide(500);
                    }, 3500);
                }
            },
            error: function(err) {
                $(".errors-profile").removeClass("hide");
                $(".errorMsg").text(
                    "An unexpected error has occurred! Please try again."
                );
                setTimeout(function() {
                    $(".errors-profile").hide(500);
                }, 3500);
                // IF an Ajax error happens
            }
        }); /*end ajax call*/
    }); /*End of the Edit User Profile Name */

    /*Edit User Profile -> DESCRIPTION */

    $(".linkEditDescription").on("click", function() {
        $(".old-description").addClass("hide");
        $(".linkEditDescription").addClass("hide");
        $(".div-edit-description").removeClass("hide");
    });

    $(".cancel-edit-description").on("click", function() {
        $(".old-description").removeClass("hide");
        $(".linkEditDescription").removeClass("hide");
        $(".div-edit-description").addClass("hide");
    });

    /*Ajax call to edit description profil*/
    $(".edit-description").on("submit", function(event) {
        event.preventDefault();
        let id = $(".user_id").val();
        $.ajax({
            url: "/userprofile/description/" + id,
            type: "post",
            data: $("form").serialize(),
            success: function(result) {
                if (result.success) {
                    $(".success-profile").removeClass("hide");
                    $(".successMsg").text(result.success);
                    $(".old-description").removeClass("hide");
                    $(".linkEditDescription").removeClass("hide");
                    $(".div-edit-description").addClass("hide");
                    $(".older-description").text(result.description);
                    setTimeout(function() {
                        $(".success-profile").hide(500);
                    }, 2000);
                } else {
                    $(".errors-profile").removeClass("hide");
                    $.each(result.errors, function(key, value) {
                        $(".errorMsg").text(value);
                    });
                    setTimeout(function() {
                        $(".errors-profile").hide(500);
                    }, 3500);
                }
            },
            error: function(err) {
                $(".errors-profile").removeClass("hide");
                $(".errorMsg").text(
                    "An unexpected error has occurred! Please try again."
                );
                setTimeout(function() {
                    $(".errors-profile").hide(500);
                }, 3500);
            }
        });
    }); /*end ajax call*/
    /*END of edit DESCRIPTION */

    /*Send msg to a user*/
    $(".send-msg-link").on("click", function() {
        $(".send-msg-card").removeClass("hide");
        $(".shadow-div").removeClass("hide");
    });

    $(".close-card").on("click", function() {
        $(".send-msg-card").addClass("hide");
        $(".shadow-div").addClass("hide");
    });

    /*Ajax call to send message*/
    $(".send-message-to").on("submit", function(event) {
        event.preventDefault();
        let id = $("#idToSend").val();
        $.ajax({
            url: "/sendmessage/" + id,
            type: "post",
            data: $("form").serialize(),
            success: function(result) {
                if (result.success) {
                    $(".success-profile").removeClass("hide");
                    $(".success-profile").css({
                        position: "absolute",
                        "z-index": "1"
                    });
                    $(".successMsg").text(result.success);
                    $(".send-msg-card").addClass("hide");
                    $(".shadow-div").addClass("hide");
                    setTimeout(function() {
                        $(".success-profile").hide(500);
                    }, 2000);
                    console.log(result.success);
                } else {
                    $(".errors-profile").removeClass("hide");
                    $(".errors-profile").css({
                        position: "absolute",
                        "z-index": "1"
                    });
                    $.each(result.errors, function(key, value) {
                        $(".errorMsg").text(value);
                    });
                    setTimeout(function() {
                        $(".errors-profile").hide(500);
                    }, 3500);
                }
            },
            error: function(err) {
                $(".errors-profile").removeClass("hide");
                $(".errorMsg").text(
                    "An unexpected error has occurred! Please try again."
                );
                setTimeout(function() {
                    $(".errors-profile").hide(500);
                }, 3500);
            }
        });
    }); /*end ajax call to send message*/
    /*end of send message to a user*/

    /*Ajax call to upload photo*/
    $("#uploadform").on("submit", function(event) {
        event.preventDefault();
        $.ajax({
            type: "post",
            url: "/uploadphoto",
            data: new FormData($("#uploadform")[0]),
            processData: false,
            contentType: false,
            success: function(result) {
                if (result.success) {
                    $("input").val("");
                    $("textarea").val("");
                    $("#foto")
                        .next(".custom-file-label")
                        .text("");
                    $(".success-profile").removeClass("hide");
                    $(".success-profile").css({
                        position: "absolute",
                        "z-index": "1"
                    });
                    $(".successMsg").text(result.success);
                    $("#showNewPhoto").append(
                        "<img class='img-thumbnail' src='" + result.url + "' >"
                    );
                    setTimeout(function() {
                        $(".success-profile").hide(500);
                        $(".success-profile").addClass("hide");
                    }, 5000);
                    setTimeout(function() {
                        $(".success-profile").css("display", "initial");
                    }, 5001);
                } else {
                    $(".errors-profile").removeClass("hide");
                    $(".errors-profile").css({
                        position: "absolute",
                        "z-index": "1"
                    });
                    $.each(result.errors, function(key, value) {
                        $(".errorMsg").append("<span>" + value + "</span><br>");
                    });
                    setTimeout(function() {
                        $(".errors-profile").hide(500);
                    }, 5000);
                }
            },
            error: function(err) {
                $(".errors-profile").removeClass("hide");
                $(".errorMsg").text(
                    "An unexpected error has occurred! Please try again."
                );
                setTimeout(function() {
                    $(".errors-profile").hide(500);
                }, 3500);
            }
        });
    }); /*end ajax call to upload photo*/

    /*Change photo profil*/
    $("#exampleModal").on("show.bs.modal", function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var user = button.data("whatever"); // Extract info from data-* attributes
        var modal = $(this);
        modal.find(".modal-title").text(user + " choose a new photo");
    });
    /*Change photo profil*/

    /*edit location*/
    $(".linkEditLocation").on("click", function() {
        $(".old-location").addClass("hide");
        $(".linkEditLocation").addClass("hide");
        $(".div-edit-location").removeClass("hide");
    });

    $(".cancel-edit-location").on("click", function() {
        $(".old-location").removeClass("hide");
        $(".linkEditLocation").removeClass("hide");
        $(".div-edit-location").addClass("hide");
    });

    /*Ajax call to edit Location profil*/
    $(".edit-location").on("submit", function(event) {
        event.preventDefault();
        let id = $(".user_id").val();
        $.ajax({
            url: "/userprofile/location/" + id,
            type: "post",
            data: $(".edit-location").serialize(),
            success: function(result) {
                console.log("ok");
                if (result.success) {
                    $(".success-profile").removeClass("hide");
                    $(".successMsg").text(result.success);
                    $(".old-location").removeClass("hide");
                    $(".linkEditLocation").removeClass("hide");
                    $(".div-edit-location").addClass("hide");
                    $(".older-location").text(result.location);
                    setTimeout(function() {
                        $(".success-profile").hide(500);
                    }, 2000);
                } else {
                    $(".errors-profile").removeClass("hide");
                    $.each(result.errors, function(key, value) {
                        $(".errorMsg").text(value);
                    });
                    setTimeout(function() {
                        $(".errors-profile").hide(500);
                    }, 3500);
                }
            },
            error: function(err) {
                console.log(err);
                $(".errors-profile").removeClass("hide");
                $(".errorMsg").text(
                    "An unexpected error has occurred! Please try again."
                );
                setTimeout(function() {
                    $(".errors-profile").hide(500);
                }, 3500);
            }
        });
    }); /*end ajax call*/
    /*END of edit Location */

    /*Edit photo details - user profile*/
$("a.edit-photo-button").on("click", function(e){
    e.preventDefault();
    let Id = this.id;
    let photoId= Id.substring(5);
    $("h6."+photoId).addClass("hide");
    $(".buttons-photo-"+photoId).removeClass("hide");
    $(".edit-photo-"+photoId).removeClass("hide");
    $(".old-fields-"+photoId).addClass("hide");
})
$(".cancel-edit-photo").on("click", function(e){
    e.preventDefault();
    let Id = this.id;
let photoId= Id.substring(7);
    $("h6."+photoId).removeClass("hide");
    $(".buttons-photo-"+photoId).addClass("hide");
    $(".edit-photo-"+photoId).addClass("hide");
    $(".old-fields-"+photoId).removeClass("hide");
})
    /*end of edit photo details - user profile*/
}); //LAST JQuery DO NOT DELETE
