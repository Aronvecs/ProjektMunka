$('#Gameaccept').click(function(){ 
    var $error = true;

    if ( $.trim($("#game_name").val()) === "") {
        $("#game_name").addClass( "error" );
        $error = false;
    }
    else{
        $("#game_name").removeClass( "error" );
    }

    let gameTrailer = $.trim($("#game_trailer").val()); 
    if ( $.trim($("#game_trailer").val()) === "") {
        $("#game_trailer").addClass( "error" );
        $error = false;
    }
    else{
        
        if(gameTrailer.length == 41 && gameTrailer.includes("https://www.youtube.com/embed/", 0)){
            $("#game_trailer").removeClass( "error" );
        }
        else{
            $("#game_trailer").addClass( "error" );
            $error = false;
        }
    }

    if ( $.trim($("#game_description").val()) === "") {
        $("#game_description").addClass( "error" );
        $error = false;
    }
    else{
        $("#game_description").removeClass( "error" );
    }

    if ( $.trim($("#game_cover_image").val()) === "") {
        $("#game_cover_image").addClass( "error" );
        $error = false;
    }
    else{
        $("#game_cover_image").removeClass( "error" );
    }

    if ( $( "#game_status option:selected" ).text() != "Not out yet" && $( "#game_status option:selected" ).text() != "Canceled" && $.trim($("#game_release_date").val()) === "") {
        $("#game_release_date").addClass( "error" );
        $error = false;
    }
    else{
        if ( $( "#game_status option:selected" ).text() == "Not out yet" && $.trim($("#game_release_date").val()) != "" || $( "#game_status option:selected" ).text() == "Canceled" && $.trim($("#game_release_date").val()) != "") {
            $("#game_release_date").addClass( "error" );
            $error = false;
        }
        else{
            $("#game_release_date").removeClass( "error" );
        }
    }


    return $error;
});
$('#Gamereject').click(function(){ 
    return true;
});

$('#AcceptCharacter').click(function(){ 
    $error = true;
    if ( $.trim($("#character_name").val()) === "") {
        $("#character_name").addClass( "error" );
        $error = false;
    }
    else{
        $("#character_name").removeClass( "error" );
    }

    if ( $.trim($("#character_description").val()) === "") {
        $("#character_description").addClass( "error" );
        $error = false;
    }
    else{
        $("#character_description").removeClass( "error" );
    }

    if ( $.trim($("#character_picture").val()) === "") {
        $("#character_picture").addClass( "error" );
        $error = false;
    }
    else{
        $("#character_picture").removeClass( "error" );
    }
    return $error;
});
$('#RejectCharacter').click(function(){ 
    return true;
});

$('#AcceptVoiceActor').click(function(){ 
    $error = true;
    if ( $.trim($("#voice_actor_name").val()) === "") {
        $("#voice_actor_name").addClass( "error" );
        $error = false;
    }
    else{
        $("#voice_actor_name").removeClass( "error" );
    }

    if ( $.trim($("#voice_actor_description").val()) === "") {
        $("#voice_actor_description").addClass( "error" );
        $error = false;
    }
    else{
        $("#voice_actor_description").removeClass( "error" );
    }

    if ( $.trim($("#voice_actor_picture").val()) === "") {
        $("#voice_actor_picture").addClass( "error" );
        $error = false;
    }
    else{
        $("#voice_actor_picture").removeClass( "error" );
    }
    return $error;
});
$('#RejectVoiceActor').click(function(){ 
    return true;
});

$('#AcceptPublisher').click(function(){ 
    $error = true;
    if ( $.trim($("#publisher_name").val()) === "") {
        $("#publisher_name").addClass( "error" );
        $error = false;
    }
    else{
        $("#publisher_name").removeClass( "error" );
    }

    if ( $.trim($("#publisher_description").val()) === "") {
        $("#publisher_description").addClass( "error" );
        $error = false;
    }
    else{
        $("#publisher_description").removeClass( "error" );
    }

    if ( $.trim($("#publisher_logo").val()) === "") {
        $("#publisher_logo").addClass( "error" );
        $error = false;
    }
    else{
        $("#publisher_logo").removeClass( "error" );
    }
    return $error;
});
$('#RejectPublisher').click(function(){ 
    return true;
});

$('#AcceptDeveloper').click(function(){ 
    $error = true;
    if ( $.trim($("#developer_name").val()) === "") {
        $("#developer_name").addClass( "error" );
        $error = false;
    }
    else{
        $("#developer_name").removeClass( "error" );
    }

    if ( $.trim($("#developer_description").val()) === "") {
        $("#developer_description").addClass( "error" );
        $error = false;
    }
    else{
        $("#developer_description").removeClass( "error" );
    }

    if ( $.trim($("#developer_logo").val()) === "") {
        $("#developer_logo").addClass( "error" );
        $error = false;
    }
    else{
        $("#developer_logo").removeClass( "error" );
    }
    return $error;
});
$('#RejectDeveloper').click(function(){ 
    return true;
});