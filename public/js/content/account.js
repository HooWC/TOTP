$(function () {

    var user_id = document.getElementById('user_id_disabled').innerText;

    function executeCode() {
        $.ajax({
            type: "POST",
            url: `/api/ajax/account/getNewAuthenticator`,
            dataType: "json",
            data: {
                user_id: user_id
            },
            success: function (data) {

                $("#verification_code_tbody").empty();

                var num = 0;
                $.each(data, function (x, y) {
                    num++;
                    $("#verification_code_tbody").append(`
				        <tr>
				            <td>${num}</td>
                            <td>${y.authenticatorCode.account_name}</td>
                            <td>${y.authenticatorCode.authenticator_code}</td>
                            <td>
                                <i class="fas fa-trash-alt trash_verification" id="${y.authenticatorCode.id}"></i>
                            </td>
                        </tr>
                    `)
                })

                $(".trash_verification").click(function () {
                    var authenticatorID = $(this).attr('id');

                    $.ajax({
                        type: "POST",
                        url: `/api/ajax/account/deleteAuthenticatorFunction`,
                        dataType: "json",
                        data: {
                            authenticatorID: authenticatorID
                        },
                        success: function (data) {
                            if (data == true) {
                                getSelectAccountName()
                                executeCode();
                            }
                        }
                    })
                })

            }
        })
    }

    function executeAtNextMinute() {
        const currentSeconds = new Date().getSeconds();
        const nextMinuteSeconds = currentSeconds >= 30 ? 60 - currentSeconds : 30 - currentSeconds;
        setTimeout(function () {
            executeCode();
            setInterval(executeCode, 30000); // 每30秒执行一次
        }, nextMinuteSeconds * 1000);
    }

    function getSelectAccountName() {
        $.ajax({
            type: "POST",
            url: `/api/ajax/account/filterProjectName`,
            data: {
                user_id: user_id
            },
            dataType: "json",
            success: function (data) {

                if (data.length === 0) {
                    $('.Click-here_authenticator').hidden(); // 隐藏按钮
                } else {
                    $('.Click-here_authenticator').show(); // 显示按钮

                    $("#select_account_name").empty();

                    $.each(data, function (x, y) {
                        $("#select_account_name").append(`
                        <option>${y}</option>
                    `)
                    })
                }



            }
        })
    }

    getSelectAccountName()
    executeCode();
    executeAtNextMinute();
    setInterval(executeAtNextMinute, 60000);

    // 需要删除的代码 （获取虚拟的key）
    $('.Click-here_authenticator').click(function () {
        $.ajax({
            type: "GET",
            url: `/api/ajax/account/getKeyCode`,
            dataType: "json",
            success: function (data) {

                $("#authenticator_input").empty();

                $("#authenticator_input").append(`
                    <input name="secret_key" value="${data}" readonly type="text" class="card-input__input" placeholder="Your Key" v-on:focus="focusInput" v-on:blur="blurInput" autocomplete="off" required>
                `)
            }
        })
    })

    $(".Click-here_authenticator").on('click', function () {
        $(".custom-model-main-verification").addClass('model-open');
    });
    $(".close-btn, .bg-overlay").click(function () {
        $(".custom-model-main-verification").removeClass('model-open');
        $(".edit-model-main-verification").removeClass('model-open');
    });

})
