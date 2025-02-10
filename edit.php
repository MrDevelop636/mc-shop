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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    <script src="editor.js"></script>
</body>
</html>
