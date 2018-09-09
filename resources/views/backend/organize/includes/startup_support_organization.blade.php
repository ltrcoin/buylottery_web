<div class="box-header with-border">
        <h3 class="box-title">{{ __('label.organize.support_organization') }}</h3>
    </div>
    
        <div class="box-body">
            <div class="form-group">
                <label for="">{{ __('label.organize.address') }}<span style="color: #f00">*</span></label>
                <input class="form-control" value="{{ isset($organize->address) ? $organize->address : '' }}" name="address" id="address_map"  type="text">
                <input type="hidden" id="lat" name="lat" />
                <input type="hidden" id="lng" name="lng" />
            </div>
            <div id="map"></div>
            <div class="form-group">
                    <label >{{ __('label.organize.certificate') }}<span style="color: #f00">*</span></label>
                    <input name="certificate" type="file" />
                    <p class="help-block">Upload files.</p>
                </div>
            <div class="form-group">
                <label>{{ __('label.organize.established_date') }}<span style="color: #f00">*</span></label>
                <div class="input-group date">
                    <input class="form-control pull-right datepicker" value="{{ isset($organize->established_date) ? $organize->established_date : '' }}" name="established_date" type="date">
                    <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                    </div>
                </div>
                <div id="established_date"></div>   
                <!-- /.input group -->
            </div>

            <div class="form-group">
                <label>{{ __('label.organize.support_type') }}<span style="color: #f00">*</span></label>
                <select name="support_type[]" class="form-control select2" multiple="multiple"
                        style="width: 100%;">
                    @foreach($lstSupportType as $data)
                        <option value="{{$data->code}}" {{ (isset($organize->support_type) && strpos($organize->support_type, $data->code) !== false) ? 'selected' : '' }} >
                            {{$data->name}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="radio-inline">
                    <input type="radio"  {{ (isset($organize->fee) && $organize->fee =='1') ? 'checked' : '' }} value="1" name="fee">{{ __('label.organize.fee_yes') }}</label>
                <label class="radio-inline">
                    <input type="radio"  {{ (isset($organize->fee) && $organize->fee =='0') ? 'checked' : '' }} value="0" name="fee">{{ __('label.organize.fee_no') }}</label>
            </div>

            <div class="form-group">
                <label for="comment">{{ __('label.organize.support_description') }}<span style="color: #f00">*</span></label>
                <textarea name="support_description"  class="form-control" rows="5" id="comment">{{ isset($organize->support_description) ? $organize->support_description : '' }}</textarea>
            </div> 

            <div class="form-group">
                <label>{{ __('label.organize.tel') }}<span style="color: #f00">*</span></label>
                <input class="form-control" value="{{ isset($organize->tel) ? $organize->tel : '' }}" name="tel" type="text">
            </div>
            <div class="form-group">
                <label>{{ __('label.organize.email') }}<span style="color: #f00">*</span></label>
                <input class="form-control" value="{{ isset($organize->email) ? $organize->email : '' }}" name="email" type="email">
            </div>
            <div class="form-group" id="properties">
                <label>{{ __('label.organize.properties') }}<span style="color: #f00">*</span></label>
                <label class="checkbox-inline">
                    <input type="checkbox" {{ (isset($organize->properties) && strpos($organize->properties, 'cl') !== false) ? 'checked' : '' }} value="cl" name="properties[]">
                    Công lập
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" {{ (isset($organize->properties) && strpos($organize->properties, 'tn') !== false) ? 'checked' : '' }} value="tn" name="properties[]">
                    Tư nhân
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" {{ (isset($organize->properties) && strpos($organize->properties, 'vt') !== false) ? 'checked' : '' }} value="vt" name="properties[]">
                    Hợp tác công tư
                </label>
            </div>

            <div class="form-group" id="belongto">
                <label>{{ __('label.organize.belongto') }}</label><br>
                <label class="checkbox-inline">
                    <input type="checkbox" {{ (isset($organize->belongto) && strpos($organize->belongto, 'is') !== false) ? 'checked' : '' }} value="is" name="belongto[]">
                    {{ __('label.organize.institute_school') }}
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" {{ (isset($organize->belongto) && strpos($organize->belongto, 'en') !== false) ? 'checked' : '' }} value="en" name="belongto[]">
                    {{ __('label.organize.enterprise') }}
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" {{ (isset($organize->belongto) && strpos($organize->belongto, 'dbl') !== false) ? 'checked' : '' }} value="dbl" name="belongto[]">
                    {{ __('label.organize.departments_branches_localities') }}
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" {{ (isset($organize->belongto) && strpos($organize->belongto, 'inde') !== false) ? 'checked' : '' }} value="inde" name="belongto[]">
                    {{ __('label.organize.independence') }}
                </label>
            </div>
        </div>
