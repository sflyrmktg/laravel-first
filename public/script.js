!function ($) {
    $(function () {
        function updateSaldo() {
            var total;
            $('.saldo').each(function (i, elem) {
                if (i == 0) {
                    total = parseFloat($(elem).text());
                } else {
                    total += parseFloat($(elem).parent().find('[data-name=value]').text());
                    $(this).text(total.toFixed(2));
                    if (total < 0.0) {
                        $(this).addClass('negative');
                    } else {
                        $(this).removeClass('negative');
                    }
                }
            });
        };

        function hideForm() {
            $('.active').removeClass('active').find('td').each(function () {
                var input = $(this).find('input');
                if (input.length === 0) return;

                if ($(this).hasClass('money')) {
                    value = parseFloat($(input).val());
                    if (value < 0.0) {
                        $(this).addClass('negative');
                    } else {
                        $(this).removeClass('negative');
                    }
                    $(this).html(value.toFixed(2));
                } else {
                    $(this).html($(input).val());
                }
            });
        };
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.money')
            .each(function () {
                if (parseFloat($(this).text()) < 0.0) {
                    $(this).addClass('negative');
                }
            })
            .on('change', function () {
                var value;
                if ($(this).find('input')) {
                    value = $(this).find('input').val();
                } else {
                    value = $(this).text();
                }
                if (parseFloat(value) < 0.0) {
                    $(this).addClass('negative');
                } else {
                    $(this).removeClass('negative');
                }
            });
        updateSaldo();
        $('button[name=duplica]').on('click', function () {
            $.post("/records", {
                id: $(this).parent().parent().attr('id'),
                field: '',
                value: '',
                    table: 'movimientos'
                }
            ).done(function () {
                location.reload();
            });
        });
        $('button[name=confirmado]').on('click', function () {
            switch ($(this).val()) {
                case '1':
                    $(this).val('0');
                    $(this).text('N');
                    $(this).parent().parent().removeClass('confirmado');
                    break;
                case '0':
                default:
                    $(this).val('1');
                    $(this).text('Y');
                    $(this).parent().parent().addClass('confirmado');
                    break;
            }
            $.post("/records", {
                id: $(this).parent().parent().attr('id'),
                    valid: $(this).val()
                }
            ).done(function () {
                hideForm();
            });
        });
        $('table#movimientos').on('click', 'td[data-name]', function () {
            if ($(this).parent().hasClass('active')) return;
            hideForm();
            $(this).parent().addClass('active').find('td').each(function () {
                var attr = $(this).attr('data-name');
                if (attr) {
                    $(this).html('<input name="' + attr + '" value="' + $(this).text() + '" />');
                    $('input').change(function () {
                        var params = {'id': $(this).parent().parent().attr('id')};
                        params[$(this).attr('name')] = $(this).val();
                        $.post("/records", params)
                            .done(function (data) {
                                console.log("Data Loaded: " + JSON.stringify(data));
                                hideForm();
                                updateSaldo();
                        });
                    });
                }
            });
        });
    });
}(jQuery);