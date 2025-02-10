<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytor Strony - Podobny do Wix</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .toolbar {
            background: #f4f4f4;
            padding: 10px;
            display: flex;
            gap: 10px;
        }

        .editable-area {
            width: 100%;
            height: 500px;
            border: 1px solid #ccc;
            padding: 10px;
            margin: 20px 0;
            overflow: auto;
        }

        .editable-box {
            width: 100%;
            text-align: center;
            padding: 50px 20px;
            background-color: #f4f4f4;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
        }

        .toolbar button, .toolbar input {
            padding: 5px 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <!-- Toolbar -->
    <div class="toolbar">
        <button id="editText">Edytuj Tekst</button>
        <button id="changeBgColor">Zmień Kolor Tła</button>
        <button id="changeTextColor">Zmień Kolor Tekstu</button>
        <input type="file" id="uploadImage" />
    </div>

    <!-- Edytowalna zawartość strony -->
    <div contenteditable="true" class="editable-area" id="editableContent">
        <div class="editable-box">
            <h1>Witaj w moim Edytorze!</h1>
            <p>Edytuj tę stronę, zmieniając tekst, kolory lub obrazy.</p>
        </div>
        <div class="image-container">
            <img src="https://via.placeholder.com/600x300" alt="Obrazek">
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inicjalizacja color pickera
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

            // Edycja tekstu w divie z contenteditable
            $('#editText').click(function() {
                var contentArea = $('#editableContent');
                contentArea.attr("contenteditable", contentArea.attr("contenteditable") === "true" ? "false" : "true");
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
