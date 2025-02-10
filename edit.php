<?php
// Ścieżka do pliku HTML strony
$htmlFilePath = 'index.html';
$jsonFilePath = './core/data/config.json';

// Funkcja do wczytywania strony HTML
function loadPageContent($filePath) {
    if (file_exists($filePath)) {
        return file_get_contents($filePath);
    }
    return '';
}

// Funkcja do zapisywania danych w formacie JSON
function saveToJSON($filePath, $data) {
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filePath, $jsonData);
}

// Wczytanie zawartości strony
$pageContent = loadPageContent($htmlFilePath);

// Obsługuje zapis zmian do pliku JSON
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
    $data = json_decode($_POST['page_data'], true);
    saveToJSON($jsonFilePath, $data);
    echo 'Zapisano zmiany do pliku JSON!';
    exit;
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytor strony</title>
    <link rel="stylesheet" href="./includes/css/edit.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>\
    <script src="./includes/js/editor.js"></script>
    <script>$(document).ready(function() {
    // Funkcja otwierająca modal
    function openModal(title, content) {
        $('#modalTitle').text(title);
        $('#modalBody').html(content);
        $('#modal').addClass('active');
    }

    // Funkcja zamykająca modal
    $('#closeModal').click(function() {
        $('#modal').removeClass('active');
    });

    // Obsługa kliknięcia na element tekstowy
    $('body').on('click', '.editable-box', function() {
        const currentText = $(this).find('h1, h2, p').text();
        const content = `
            <div class="text-edit-form">
                <label for="textColor">Kolor tekstu:</label>
                <input type="color" id="textColor" value="#000000" />
                <label for="fontSize">Rozmiar czcionki:</label>
                <select id="fontSize">
                    <option value="14px">14px</option>
                    <option value="16px">16px</option>
                    <option value="18px">18px</option>
                    <option value="20px">20px</option>
                    <option value="24px">24px</option>
                </select>
                <label for="textContent">Treść tekstu:</label>
                <textarea id="textContent">${currentText}</textarea>
            </div>
        `;
        openModal('Edytuj tekst', content);

        // Ustawienie kolorów i rozmiaru czcionki
        $('#textColor').on('input', function() {
            $(this).closest('.editable-box').find('h1, h2, p').css('color', $(this).val());
        });

        $('#fontSize').on('change', function() {
            $(this).closest('.editable-box').find('h1, h2, p').css('font-size', $(this).val());
        });

        $('#textContent').on('input', function() {
            $(this).closest('.editable-box').find('h1, h2, p').text($(this).val());
        });
    });

    // Obsługa kliknięcia na element obrazkowy
    $('body').on('click', '.image-container img', function() {
        const currentSrc = $(this).attr('src');
        const content = `
            <div class="image-edit-form">
                <label for="imageSource">Źródło obrazu:</label>
                <input type="text" id="imageSource" value="${currentSrc}" />
            </div>
        `;
        openModal('Edytuj obraz', content);

        $('#imageSource').on('input', function() {
            $(this).closest('.image-container').find('img').attr('src', $(this).val());
        });
    });

    // Zapisywanie zmian do JSON
    $('#savePage').click(function() {
        const pageData = {
            content: $('#editableArea').html()
        };

        $.ajax({
            url: 'edit.php', 
            method: 'POST',
            data: {
                save: true,
                page_data: JSON.stringify(pageData)
            },
            success: function(response) {
                alert(response);
            }
        });
    });
});
</script>
</head>
<body>
    <div class="toolbar">
        <button id="addTextBlock">Dodaj tekst</button>
        <button id="addImageBlock">Dodaj obraz</button>
        <button id="savePage">Zapisz zmiany</button>
    </div>

    <!-- Edytowana strona będzie wczytana tutaj -->
    <div class="editable-area" id="editableArea">
        <?php echo $pageContent; ?>
    </div>

    <!-- Modal dla edycji elementów -->
    <div id="modal" class="modal">
        <div class="modal-header">
            <span id="modalTitle">Edytuj element</span>
        </div>
        <div id="modalBody" class="modal-body">
            <!-- Zawartość będzie dodawana dynamicznie -->
        </div>
        <div class="modal-footer">
            <button id="closeModal">Zamknij</button>
        </div>
    </div>

</body>
</html>
