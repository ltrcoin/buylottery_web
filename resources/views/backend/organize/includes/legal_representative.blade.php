<style>
    .delete_representative{
        cursor: pointer;
    }
</style>
<div id="legal_representative_area_{{$item}}" class="panel panel-default item_legal_representative_area">
    <div class="panel-heading" role="tab" id="heading_{{$item}}">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_legal_representative_{{$item}}" aria-expanded="true" aria-controls="collapse_legal_representative_{{$item}}">
                @if(isset($isAdd) && $isAdd)
                    {{ __('label.organize.cofounder') }}
                @else
                    {{ __('label.organize.representative') }}
                @endif
               
            </a>
            <span class="glyphicon glyphicon-minus delete_representative" onclick="deleteRepresentative('legal_representative_area_{{$item}}')" style="float: right; display: none;"></span>
        </h4>
    </div>
    <div id="collapse_legal_representative_{{$item}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_{{ $item }}">
        <div class="panel-body">
            <div class="form-group">
                <label>
                    @if(isset($isAdd) && $isAdd)
                        {{ __('label.organize.cofounder_name') }}
                    @else
                        {{ __('label.organize.legal_representative_name') }}
                    @endif
                    <span style="color: #f00">*</span></label>
                <input class="form-control"   value="{{ isset($organize->legal_representative_name) ? $organize->legal_representative_name : '' }}"
                 name="legal_representative[{{$item}}][legal_representative_name]" type="text" required>
            </div>

            <div class="form-group">
                <label>{{ __('label.organize.dob') }}<span style="color: #f00">*</span></label>
                <div class="input-group date">
                    <input value="{{ isset($organize->dob) ? $organize->dob : '' }}" class="form-control pull-right datepicker" name="legal_representative[{{$item}}][dob]" type="date" required>
                    <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                    </div>
                </div>
                <!-- /.input group -->
            </div>

            <div class="form-group">
                <label class="radio-inline">
                    <input type="radio"  {{ (isset($organize->sex) && $organize->sex =='1') ? 'checked' : '' }} checked="checked" value="1" name="legal_representative[{{$item}}][sex]">
                    {{ __('label.organize.male') }}</label>
                <label class="radio-inline"><input type="radio" {{ (isset($organize->sex) && $organize->sex =='0') ? 'checked' : '' }} value="0" name="legal_representative[{{$item}}][sex]">{{ __('label.organize.female') }}</label>
                <label class="radio-inline"><input type="radio" {{ (isset($organize->sex) && $organize->sex =='2') ? 'checked' : '' }} value="2" name="legal_representative[{{$item}}][sex]">{{ __('label.organize.other') }}</label> 
            </div>

            <div class="form-group">
                <label class="checkbox-inline">
                    <input type="checkbox" {{ (isset($organize->study_abroad ) && $organize->study_abroad =='study_abroad') ? 'checked' : '' }} value="study_abroad" name="legal_representative[{{$item}}][study_abroad]">{{ __('label.organize.study_abroad') }}
                </label>
            </div> 

            <div class="form-group">
                <label>{{ __('label.organize.diploma') }}<span style="color: #f00">*</span></label>
                <select name="legal_representative[{{$item}}][diploma]" class="form-control select2" style="width: 100%;" required>
                    @foreach($lstDiploma as $data)
                        <option value="{{$data->code}}" {{ (isset($organize->diploma) && strpos($organize->diploma, $data->code) !== false) ? 'selected' : '' }} >
                            {{$data->name}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
