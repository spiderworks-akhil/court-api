@extends('spiderworks.webadmin.app')

@section('head')
    <style>
        .slot-title{
            font-size: 16px;
            border-bottom: 1px solid grey;
        }
        .slots{
            list-style: none;
            padding: 0px;
        }
        .slots li{
            cursor: pointer;
        }
        .slots li:nth-child(even){
            background: #ebebeb;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- START card -->
        <div class="col-lg-12">

            <h3>Slots added for {{$court->name}}</h3>
            <hr>
            <div class="row">
                <div class="alert alert-warning">Note : Please click on amount to change amounts</div>
            </div>
            <div class="row">
                @php
                    $f = Carbon\Carbon::parse('00:00:00 1-1-2020');
                    $t = Carbon\Carbon::parse('00:30:00 1-1-2020');
                @endphp

                <div style="width: 12.5%;text-align: center">
                    <span class="slot-title">Timings </span><br>
                    <ul class="slots">
                        @for($i=0;$i<48;$i++)
                           <li>{{$f->addMinutes(30)->format('H:i')}}  - {{$t->addMinutes(30)->format('H:i')}}</li>
                        @endfor
                    </ul>

                </div>
                @foreach($days as $obj)

                    <div style="width: 12.5%;text-align: center">
                        <span class="slot-title">{{$obj->name}} </span><br>

                        <ul class="slots">
                            @foreach($obj->slots($court->id) as $ob)
                                <li class="slot-data" data-slot-id="{{$ob->id}}"> ₹ {{$ob->price}}</li>
                            @endforeach
                        </ul>


                    </div>

                @endforeach
            </div>

        </div>
        <!-- END card -->
    </div>
@endsection
@section('bottom')
    <script>
        $('.slot-data').on('click', function () {
            var slot_id = $(this).data('slot-id');
            $.confirm({
                title: 'Change price for the slot!',
                content: '' +
                '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<label>Enter the amount for this slot</label>' +
                '<input type="text" placeholder="Your amount" class="slot-amount form-control" required />' +
                '<label>Should we set this amount to all days ?</label>' +
                '<input type="checkbox" placeholder="Your amount" class="slot-check-box " style="width: 50px" />' +
                '</div>' +
                '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Change',
                        btnClass: 'btn-blue',
                        action: function () {
                            var amount = this.$content.find('.slot-amount').val();
                            var check = this.$content.find('.slot-check-box').prop('checked');
                            if(!amount){
                                $.alert('provide a valid amount');
                                return false;
                            }

                            var data = {
                                amount : amount,
                                check : check,
                                _token : '{{csrf_token()}}',
                                count_id : '{{$court->id}}',
                                slot_id : slot_id
                            }

                            $.post('{{route('change-slot-amount')}}', data).done(function (data) {
                                console.log('response',data);
                                if(data.status){
                                    $.alert('Amount updated');
                                    setTimeout(function () {
                                        window.location.reload()
                                    },500)
                                }else{
                                    $.alert('Failed, '+data.message);
                                }

                            })
                        }
                    },
                    cancel: function () {
                        //close
                    },
                },
                onContentReady: function () {
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });

        })
    </script>
    @parent
@endsection