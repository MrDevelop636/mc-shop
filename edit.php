<?php
// Wczytanie pliku JSON z dostępnych stron
$pagesFile = './core/data/config.json';
$pages = json_decode(file_get_contents($pagesFile), true);

// Obsługa edytowania strony
if (isset($_GET['page_id'])) {
    $pageId = $_GET['page_id'];
    $page = null;
    foreach ($pages['pages'] as $p) {
        if ($p['id'] == $pageId) {
            $page = $p;
            break;
        }
    }

    // Ładowanie zawartości wybranej strony
    if ($page && file_exists($page['path'])) {
        $fileContent = file_get_contents($page['path']);
    } else {
        die("Strona nie została znaleziona.");
    }

    // Zapisanie zmian (po POST)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $content = $_POST['content'];
        file_put_contents($page['path'], $content);
        header("Location: edit.php?page_id=$pageId");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytor Strony</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css">
    <style>
        .editable-area {
            width: 100%;
            height: 500px;
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 20px;
        }

        button {
            margin-top: 20px;
        }

        .toolbar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<h1>Wybierz stronę do edycji</h1>

<ul>
    <?php foreach ($pages['pages'] as $p): ?>
        <li><a href="edit.php?page_id=<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['title']); ?></a></li>
    <?php endforeach; ?>
</ul>

<?php if (isset($page)): ?>
    <h2>Edytuj stronę: <?php echo htmlspecialchars($page['title']); ?></h2>

    <form method="POST">
        <div class="toolbar">
            <label for="color">Kolor tekstu: </label>
            <input type="text" id="color" name="color" value="#000000">
            <label for="bg-color">Kolor tła: </label>
            <input type="text" id="bg-color" name="bg-color" value="#ffffff">
            <button type="button" onclick="changeFontColor()">Zmień kolor tekstu</button>
            <button type="button" onclick="changeBackgroundColor()">Zmień kolor tła</button>
        </div>

        <div contenteditable="true" class="editable-area" id="editable-content">
            <?php echo htmlspecialchars($fileContent); ?>
        </div>

        <button type="submit">Zapisz zmiany</button>
    </form>

<?php endif; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>
<script>
    $(document).ready(function() {
        // Inicjalizacja color pickera
        $("#color, #bg-color").spectrum({
            showInput: true,
            preferredFormat: "hex"
        });
    });

    // Funkcja do zmiany koloru tekstu
    function changeFontColor() {
        var color = $("#color").spectrum("get").toString();
        document.getElementById("editable-content").style.color = color;
    }

    // Funkcja do zmiany koloru tła
    function changeBackgroundColor() {
        var color = $("#bg-color").spectrum("get").toString();
        document.getElementById("editable-content").style.backgroundColor = color;
    }
</script>

</body>
</html>
