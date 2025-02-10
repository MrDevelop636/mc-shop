<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytor Strony - Wix-like</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Toolbar -->
    <div class="toolbar">
        <button id="editText">Edytuj Tekst</button>
        <button id="changeBgColor">Zmień Kolor Tła</button>
        <button id="changeTextColor">Zmień Kolor Tekstu</button>
        <input type="file" id="uploadImage" />
    </div>

    <!-- Edytowalna zawartość -->
    <div contenteditable="true" class="editable-area" id="editableContent">
        <div class="editable-box">
            <h1>Witaj w moim Edytorze!</h1>
            <p>Edytuj tę stronę, zmieniając tekst, kolory lub obrazy.</p>
        </div>
    </div>

    <!-- Sekcja wyboru bloków -->
    <div class="block-selection" id="blockSelection">
        <!-- Bloki będą dodawane dynamicznie -->
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>
    <script>
        $(document).ready(function() {
            // Wczytanie bloków z JSON
            $.getJSON('./core/data/blocks.json', function(data) {
                var blocks = data.blocks;

                // Dodanie przycisków wyboru bloków
                blocks.forEach(function(block) {
                    var button = $('<button></button>')
                        .text(block.name)
                        .attr('data-template', block.template)
                        .addClass('block-button');

                    var tooltip = $('<span></span>')
                        .text(block.description)
                        .addClass('block-tooltip');

                    button.append(tooltip);
                    $('#blockSelection').append(button);
                });

                // Funkcja dodawania wybranego bloku do edytora
                $('.block-button').click(function() {
                    var template = $(this).attr('data-template');
                    $('#editableContent').append(template);
                });
            });

            // Edycja tekstu w divie z contenteditable
            $('#editText').click(function() {
                var contentArea = $('#editableContent');
                contentArea.attr("contenteditable", contentArea.attr("contenteditable") === "true" ? "false" : "true");
            });

            // Zmiana kolorów tła
            $('#changeBgColor').click(function() {
                $(this).spectrum({
                    color: "#ffffff",
                    showInput: true,
                    preferredFormat: "hex",
                    change: function(color) {
                        $(".editable-area").css("background-color", color.toString());
                    }
                });
            });

            // Zmiana kolorów tekstu
            $('#changeTextColor').click(function() {
                $(this).spectrum({
                    color: "#000000",
                    showInput: true,
                    preferredFormat: "hex",
                    change: function(color) {
                        $(".editable-area").css("color", color.toString());
                    }
                });
            });

            // Ładowanie obrazka
            $('#uploadImage').on('change', function(e) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('.image-container img').attr('src', event.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            });
        });
    </script>
</body>
</html>
