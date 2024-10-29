$(function () {

    $(".view_profile").on('click', function () {
        var clickHereId = $(this).attr('id');
        var customModelMain = $("#model" + clickHereId);
        customModelMain.addClass('model-open');
    });

    $(".close-btn, .bg-overlay").click(function () {
        $(".custom-model-main").removeClass('model-open');
    });

    $(".users_lock_open").click(function () {
        var clickedIcon = $(this);
        var clickedId = $(this).attr('id');
        var dataValue = $(this).data('value');

        $.ajax({
            type: "POST",
            url: `/api/ajax/admin/isDisabledUser`,
            dataType: "json",
            data: {
                accountid: clickedId
            },
            success: function (data) {

                if (data.message === "disabled update success") {
                    if (dataValue === "unlock") {
                        clickedIcon.removeClass('fa-unlock').addClass('fa-lock').css('color', 'red');
                        clickedIcon.data('value', 'lock');
                    } else {
                        clickedIcon.removeClass('fa-lock').addClass('fa-unlock').css('color', 'rgb(250, 159, 95)');
                        clickedIcon.data('value', 'unlock');
                    }
                }

            }
        })
    })

    const search = document.querySelector('.input-group input'),
        table_rows = document.querySelectorAll('tbody .tr_table'),
        table_headings = document.querySelectorAll('thead th');

    if (search) {
        search.addEventListener('input', searchTable);
    }

    function searchTable() {
        if (!search) {
            return;
        }

        tableHeadings = document.querySelectorAll('thead th');

        table_rows.forEach((row, i) => {
            let tableData = row.textContent.toLowerCase();
            let searchData = search.value.toLowerCase();

            row.classList.toggle('hide', tableData.indexOf(searchData) < 0);
            row.style.setProperty('--delay', i / 25 + 's');
        });

        document.querySelectorAll('tbody tr:not(.hide)').forEach((visibleRow, i) => {
            visibleRow.style.backgroundColor = (i % 2 == 0) ? 'transparent' : '#0000000b';
        });
    }

    // Sorting | Ordering data of HTML table
    table_headings.forEach((head, i) => {
        let sort_asc = true;
        head.onclick = () => {
            table_headings.forEach(head => head.classList.remove('active'));
            head.classList.add('active');

            document.querySelectorAll('.tr_table td').forEach(td => td.classList.remove('active'));
            table_rows.forEach(row => {
                const columns = row.querySelectorAll('.tr_table td');

                if (i < columns.length) {
                    columns[i].classList.add('active');
                }
            });

            head.classList.toggle('asc', sort_asc);
            sort_asc = head.classList.contains('asc') ? false : true;

            sortTable(i, sort_asc);
        }
    })

    function sortTable(column, sort_asc) {
        [...table_rows].sort((a, b) => {
            const aTd = a.querySelectorAll('.tr_table td')[column];
            const bTd = b.querySelectorAll('.tr_table td')[column];

            if (!aTd || !bTd) {
                return 0;
            }

            let first_row = aTd.textContent.toLowerCase(),
                second_row = bTd.textContent.toLowerCase();

            return sort_asc ? (first_row < second_row ? 1 : -1) : (first_row < second_row ? -1 : 1);
        })
            .map(sorted_row => document.querySelector('#tbody_table').appendChild(sorted_row));
    }

})





