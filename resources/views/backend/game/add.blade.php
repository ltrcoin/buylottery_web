@extends('backend.layouts.main')
@section('title', __('label.game.add'))
@section('content')
    <link rel="stylesheet" href="{{asset('backend/plugins/iCheck/square/blue.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/datepicker/datepicker3.css')}}">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="{{ asset('backend/plugins/croppic/css/croppic.css') }}">
    <style type="text/css">
        .select2-container {
            display: block;
        }

        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            width: 100%;
            height: 34px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-image: none;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        }
    </style>
    <section class="content-header">
        <h1>@if(empty($item)){{__('label.add_new')}}@else{{ __('label.edit') }}@endif
            <small>{{ __('label.game.list_title') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('backend.site.index')}}"><i class="fa fa-dashboard"></i> {{ __('label.dashboard') }}
                </a></li>
            <li><a href="{{route('backend.game.index')}}">{{__('label.game.list_title')}}</a></li>
            <li class="active">@if(empty($item)){{__('label.add_new')}}@else{{ __('label.edit') }}@endif</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form role="form" action="" method="POST" enctype="multipart/form-data" id="game-form">
                    {{csrf_field()}}
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            @if(!empty($buttons))
                                @include('backend.component.button_bar')
                            @endif
                            <h3 class="help">{!!__('label.note_required')!!}</h3>
                            <p style="color: #f00;">
                                {{$errors->first()}}
                            </p>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="name">{{__('label.game.name')}} <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   value="{{ old('name') ?? $item->name ?? '' }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="numbers">{{ __('label.game.numbers') }} <span class="text-danger">*</span> </label>
                                            <input class="form-control" type="number" id="numbers" name="numbers"
                                                   value="{{ old('numbers') ?? $item->numbers ?? '' }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="ticket_price">{{ __('label.game.ticket_price') }} <span class="text-danger">*</span> </label>
                                            <input class="form-control" type="number" id="ticket_price"
                                                   name="ticket_price"
                                                   value="{{ old('ticket_price') ?? $item->ticket_price ?? '' }}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input id="has_special_number" class="icheck-input" type="checkbox"
                                                   name="has_special_number"
                                                   value="1" @if(!empty($item) && $item->has_special_number){{ 'checked' }}@endif>
                                            <label for="has_special_number">{{ __('label.game.has_special_number') }}</label>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="min_number">{{ __('label.game.min_number') }}</label>
                                            <input class="form-control" type="number" min="1" name="min_number"
                                                   id="min_number"
                                                   value="{{ old('min_number') ?? $item->min_number ?? null }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="max_number">{{ __('label.game.max_number') }}</label>
                                            <input class="form-control" type="number" min="1" name="max_number"
                                                   id="max_number"
                                                   value="{{ old('max_number') ?? $item->max_number ?? null }}">
                                        </div>
                                        <div class="special-info"
                                             @if(empty($item) || !$item->has_special_number)style="display: none"@endif>
                                            <div class="form-group col-md-6">
                                                <label for="min_special">{{ __('label.game.min_special') }}</label>
                                                <input class="form-control" type="number" min="1" name="min_special"
                                                       id="min_special"
                                                       value="{{ old('min_special') ?? $item->min_special ?? null }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="max_special">{{ __('label.game.max_special') }}</label>
                                                <input class="form-control" type="number" min="1" name="max_special"
                                                       id="max_special"
                                                       value="{{ old('max_special') ?? $item->max_special ?? null }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="special_numbers">{{ __('label.game.special_numbers') }}</label>
                                                <input type="number" min="0" name="special_numbers" class="form-control"
                                                       id="special_numbers"
                                                       value="{{ old('special_numbers') ?? $item->special_numbers ?? null }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="draw_day">{{ __('label.game.draw_day') }} <span class="text-danger">*</span> </label>
                                            <div class="row">
                                                @foreach(range(0, 6) as $weekDay)
                                                    <div class="col-md-4">
                                                        <label><input type="checkbox" class="icheck-input draw-day-input"
                                                                      name="draw_day[]"
                                                                      @if(!empty($drawDays) && in_array($weekDay, $drawDays)){{ 'checked' }}@endif
                                                                      value="{{ $weekDay }}"
                                                                      required> {{ __('label.week_day.' . $weekDay) }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="draw_time">{{ __('label.game.draw_time') }} <span class="text-danger">*</span> </label>
                                            <div class="input-group bootstrap-timepicker timepicker">
                                                <input id="draw_time"
                                                       value="{{ old('draw_time') ?? (!empty($item) ? ($item->draw_time != '24:00:00' ? $item->draw_time : '00:00:00') : '') }}"
                                                       name="draw_time" type="text" class="form-control input-small">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="id_game_api">{{ __('label.game.id_game_api') }}</label>
                                            <input type="text" class="form-control" id="id_game_api"
                                                   placeholder="{{ __('label.game.id_game_api_placeholder') }}"
                                                   name="id_game_api"
                                                   value="{{ old('id_game_api') ?? $item->id_game_api ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row internal-info">
                                        <div class="form-group col-md-12">
                                            <label for="image">{{ __('label.game.image') }}</label>
                                            <span class="help-block inline">({{ __('label.game.image_notice') }})</span>
                                            <input class="form-control" type="file" name="image" id="image">
                                        </div>
                                        @if(!empty($item) && !empty($item->image))
                                            <div class="form-group col-md-12">
                                                <img src="{{ asset('upload/' . $item->image) }}" alt="{{ $item->name }}" class="img img-responsive">
                                            </div>
                                        @endif

                                        <div class="form-group col-md-12">
                                            <label for="description">{{ __('label.game.description') }} <span class="text-danger">*</span> </label>
                                            <textarea name="description" id="description" cols="30" rows="10"
                                                      class="form-control">{{ old('description') ?? $item->description ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="hidden" id="json_prize" value='{{ $jsonPrize ?? '' }}'>
                                    <label for="">{{ __('label.prize.title') }}</label>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>{{ __('label.prize.name') }}</th>
                                            <th>{{ __('label.prize.match') }}</th>
                                            <th>{{ __('label.prize.match_special') }}</th>
                                            <th>{{ __('label.prize.value') }}</th>
                                            <th>{{ __('label.prize.unit') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody id="prize-table">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ractive/1.0.0-build-99/ractive.min.js"></script>
    <script src="{{ asset('backend/libout/js/ractive-transitions-fade.umd.js') }}"></script>
    <script src="{{asset('backend/plugins/iCheck/icheck.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
    <script src="{{ asset('backend/libout/js/uuid.js') }}"></script>
    <script src="{{ asset('backend/plugins/jquery-validate-1.17/jquery.validate.js') }}"></script>
    <script src="{{ asset('backend/plugins/jquery-validate-1.17/additional-methods.min.js') }}"></script>
    <script src="{{ asset('backend/pages/game/component/Prize.js') }}"></script>
    <script type="text/javascript">
      (function ($) {
        $(document).ready(function () {
          var iCheck = $('.icheck-input')
          iCheck.iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
          })

          var specialInfo = $('.special-info'),
            hasSpecialNumber = $('#has_special_number')
          if (hasSpecialNumber.prop('checked')) {
            specialInfo.css('display', 'block')
          }
          hasSpecialNumber.on('ifToggled', function () {
            specialInfo.slideToggle()
          });

          $('.draw-day-input').on('ifToggled', function () {
            $(this).valid();
          })

          $('#draw_time').timepicker({
            showMeridian: false
          })

          $('#game-form').validate({
            rules: {
              name: {
                required: true,
                minlength: 1
              },
              numbers: {
                required: true,
                number: true,
                min: 1
              },
              ticket_price: {
                required: true,
                number: true,
              },
              min_number: {
                required: true,
                number: true,
                min: 1
              },
              max_number: {
                required: true,
                number: true,
                min: 1
              },
              draw_time: {
                required: true,
                time: true
              },
              draw_day: 'required',
              description: 'required'
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
              // Add the `help-block` class to the error element
              error.addClass('help-block');

              // error.insertAfter(element)
              $(element).closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
              $(element).closest('.form-group').addClass('has-error').removeClass('has-success')
              $(element).closest('.form-group').find('label').eq(0).find('i').remove();
            },
            unhighlight: function (element, errorClass, validClass) {
              $(element).closest('.form-group').addClass('has-success').removeClass('has-error')
              $(element).closest('.form-group').find('label').eq(0).find('i').remove();
            }
          });
        })
      })(jQuery)
    </script>
    @include('backend.component.script.croppicScript')
@stop