$(document).ready(function() {
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
