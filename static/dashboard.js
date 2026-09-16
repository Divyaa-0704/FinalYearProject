$(document).ready(function () {
    $.getJSON("/get_tables", function (tables) {
        let dropdown = $("#tableDropdown");
        dropdown.append('<option value="">Select a Table</option>');
        tables.forEach(function (table) {
            dropdown.append('<option value="' + table + '">' + table + '</option>');
        });
    });

    $("#tableDropdown").change(function () {
        let table = $(this).val();
        if (table) {
            $.post("/get_columns", { table: table }, function (columns) {
                let columnsDiv = $("#columnsSelection");
                columnsDiv.empty();
                if (columns.length > 0) {
                    columns.forEach(function (col) {
                        columnsDiv.append(`
                            <label>
                                <input type="checkbox" name="columns" value="${col}"> ${col}
                            </label><br>
                        `);
                    });
                } else {
                    columnsDiv.append("<p>No columns available.</p>");
                }
            });
        }
    });
});
