@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Records CRUD</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('records.create') }}"> Create New Record</a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered" id="records">
        <tr>
            <th>Action</th>
            <th>Date</th>
            <th>Details</th>
            <th>Concept</th>
            <th>Value</th>
            <th>Balance</th>
        </tr>
        <tr class="search">
            <td></td>
            <td><input name="made_at" /></td>
            <td></td>
            <td><input name="explanation" /></td>
            <td class="money"><input name="value" /></td>
            <td class="money balance">{{$balance}}</td>
        </tr>
        @foreach ($records as $record)
            <tr id="{{$record->id}}" class="{{($record->isvalid == 1)?'valid':''}}">
                <td>
                    {{ ++$i }}
                    <span class="btn-group">
                        <a name="clone" class="btn btn-warning btn-xs">C</a>
                        <button name="validate" class="btn btn-default btn-xs" value="{{$record->isvalid}}">{{($record->isvalid == 1)?'I':'V'}}</button>
                        <!--a class="btn btn-info btn-xs" href="{{ route('records.show',$record->id) }}">S</a/-->
                        <!--a class="btn btn-primary btn-xs" href="{{ route('records.edit',$record->id) }}">E</a/-->
                        <a name="delete" class="btn btn-danger btn-xs">D</a>
                    </span>
                </td>
                <td data-name="made_at">{{$record->made_at}}</td>
                @if($view=='method')
                    <td><a href=href="{{route('concepts.{concept}.records.index',['concept'=>$record->concept_id])}}"
                           target="concept">{{$record->concept->name}}</a></td>
                @endif
                @if($view=='concept')
                    <td><a href=href="{{route('methods.{method}.records.index',['method'=>$record->method_id])}}"
                           target="method">{{$record->method->name}}</a></td>
                @endif
                <td data-name="explanation">{{$record->explanation}}</td>
                <td class="money" data-name="value">{{$record->value}}</td>
                <td class="money balance"></td>
            </tr>
        @endforeach
    </table>
    <div class="text-center">{!! $records->links() !!}</div>

@endsection
@section('scripts')
    <script type="application/javascript">
        !function ($) {
            $(function () {
                function updateBalance() {
                    var total;
                    $('.balance').each(function (i, elem) {
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

                updateBalance();

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

                $('a[name=clone]').on('click', function () {
                    var $tr = $(this).parent().parent().parent();
                    var $clone = $tr.clone();
                    $.post("{{route('records.clone')}}", {
                            id: $tr.attr('id')
                        }
                    ).done(function (data) {
                        console.log("Data Loaded: " + JSON.stringify(data));
                        $clone.attr('id',data.id);
                        $clone.removeClass('valid');
                        $tr.after($clone);
                        // location.reload();
                    });
                });
                $('button[name=validate]').on('click', function () {
                    var $tr = $(this).parent().parent().parent();
                    var isvalid = 1-$(this).val();
                    var $elem = $(this);
                    $.post("{{route('records.partialupdate')}}", {
                            id: $tr.attr('id'),
                            isvalid: isvalid
                        }
                    ).done(function (data) {
                        console.log("Data after update: " + JSON.stringify(data));
                        if (data.isvalid != isvalid) return;
                        $tr.toggleClass('valid');
                        $elem.text((isvalid==1)?'I':'V');
                    });
                });
                $('a[name=delete]').on('click', function () {
                    var $tr = $(this).parent().parent().parent();
                    $.ajax({
                        url: '/records/' + $tr.attr('id'),
                        type: 'DELETE',
                        success: function () {
                            $tr.remove();
                        }
                    }).done(function (data) {
                        console.log("Deleted record: " + JSON.stringify(data));
                    });
                });
                $('table#records').on('click', 'td[data-name]', function () {
                    if ($(this).parent().hasClass('active')) return;
                    hideForm();
                    $(this).parent().addClass('active').find('td').each(function () {
                        var attr = $(this).attr('data-name');
                        if (attr) {
                            $(this).html('<input name="' + attr + '" value="' + $(this).text() + '" />');
                            $('input').change(function () {
                                var $tr = $(this).parent().parent();
                                var params = {'id': $tr.attr('id')};
                                params[$(this).attr('name')] = $(this).val();
                                $.post("{{route('records.partialupdate')}}", params)
                                    .done(function (data) {
                                        console.log("Data Loaded: " + JSON.stringify(data));
                                        hideForm();
                                        updateBalance();
                                    });
                            });
                        }
                    });
                });
            });
        }(jQuery);
    </script>
@endsection