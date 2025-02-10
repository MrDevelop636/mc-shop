<?php
// Wczytanie pliku JSON z dostępnymi stronami
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
        .page-list {
            list-style: none;
            padding: 0;
        }

        .page-list li {
            margin-bottom: 10px;
        }

        .editable-area {
            width: 100%;
            height: 500px;
            border: 1px solid #ccc;
            padding: 10px;
        }

        button {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h1>Wybierz stronę do edycji</h1>

<ul class="page-list">
    <?php foreach ($pages['pages'] as $p): ?>
        <li>
            <a href="edit.php?page_id=<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['title']); ?></a>
        </li>
    <?php endforeach; ?>
</ul>

<?php if (isset($page)): ?>
    <h2>Edytuj stronę: <?php echo htmlspecialchars($page['title']); ?></h2>
    <form method="POST">
        <div contenteditable="true" class="editable-area"><?php echo htmlspecialchars($fileContent); ?></div>
        <button type="submit">Zapisz zmiany</button>
    </form>
<?php endif; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>
<script>
    $(document).ready(function() {
        // Inicjalizacja color pickera (opcjonalnie)
        $("#color").spectrum({
            color: "#f00",
            change: function(color) {
                $(".editable-area").css("background-color", color.toString());
            }
        });
    });
</script>

</body>
</html>
