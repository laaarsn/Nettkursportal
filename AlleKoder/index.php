<?php 
include "funksjoner.inc.php";
color();


?>
<html>
<body style="background-color:white;">
<head><title>Hovedside Laarsn Nettkursportal</title>
<link rel="stylesheet" href="styling.css">
</head> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hovedside</title>

    <link rel="stylesheet" href="static/css/chat.css">
    <link rel="stylesheet" href="static/css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<style>
.topnav {
    margin-top: -2px;
    font-family: 'Times New Roman';
    margin-left: 8px;
    left: -10px;
}
</style>
<body>
    <!-- CHAT BAR BLOCK -->
    <div class="chat-bar-collapsible">
        <button id="chat-button" type="button" class="collapsible">Snakk med oss!
            <i id="chat-icon" style="color: #fff;" class="fa fa-fw fa-comments-o"></i>
        </button>

        <div class="content">
            <div class="full-chat-block">
                <!-- Message Container -->
                <div class="outer-container">
                    <div class="chat-container">
                        <!-- Messages -->
                        <div id="chatbox">
                            <h5 id="chat-timestamp"></h5>
                            <p id="botStarterMessage" class="botText"><span>Loading...</span></p>
                        </div>

                        <!-- User input box -->
                        <div class="chat-bar-input-block">
                            <div id="userInput">
                                <input id="textInput" class="input-box" type="text" name="msg"
                                    placeholder="Trykk 'Enter' for å skrive en beskjed...">
                                <p></p>
                            </div>

                            <div class="chat-bar-icons">
                                <i id="chat-icon" style="color: crimson;" class="fa fa-fw fa-heart"
                                    onclick="heartButton()"></i>
                                <i id="chat-icon" style="color: #333;" class="fa fa-fw fa-send"
                                    onclick="sendButton()"></i>
                            </div>
                        </div>

                        <div id="chat-bar-bottom">
                            <p></p>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="static/scripts/responses.js"></script>
<script src="static/scripts/chat.js"></script>

</html>

<div class="imgtest">
    <body>
        <div class="letterRight">
        <h3><I> velg mellom en  </h3></I>
        </div>
        <div class="letteralternativ"><h1> rekke varierte </h1>
        </div>
        <div class="letterRight"><h3><I>kurs i Nettkursportalen! </div></h3></I>
        <div class="letterLeft"><h3> <I>Ute etter en ny hobby? </h3></div>
        <div class="letteralternativLeft"><h3> ... eller kanskje et karriereløft? </h3></div></I>
</div>
</body>
</html>