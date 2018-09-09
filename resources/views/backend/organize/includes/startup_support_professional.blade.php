<div class="box-header with-border">
    <h3 class="box-title">{{ __('label.organize.expert_support') }}</h3>
</div>

    <div class="box-body">
        <div class="form-group">
            <label for="">{{ __('label.organize.address') }}<span style="color: #f00">*</span></label>
            <input class="form-control" name="address" value="{{ isset($organize->address) ? $organize->address : '' }}" id="address_map" type="text">
            <input type="hidden" id="lat" name="lat" />
            <input type="hidden" id="lng" name="lng" />
        </div>
        <div id="map"></div>
        <div class="form-group">
            <label>{{ __('label.organize.support_type') }}<span style="color: #f00">*</span></label>
            <select name="support_type[]" class="form-control select2" multiple="multiple"
                        style="width: 100%;">
                @foreach($lstSupportTypeCG as $data)
                    <option value="{{$data->code}}" {{ (isset($organize->support_type) && strpos($organize->support_type, $data->code) !== false) ? 'selected' : '' }} >
                        {{$data->name}}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="">{{ __('label.organize.support_time') }}</label>
            <input class="form-control"  value="{{ isset($organize->support_time) ? $organize->support_time : '' }}" name="support_time"  type="text">
        </div>

        <div class="form-group">
            <label for="">{{ __('label.organize.startup_has_support') }}</label>
            <input class="form-control"  value="{{ isset($organize->startup_has_support) ? $organize->startup_has_support : '' }}" name="startup_has_support"  type="text">
        </div>

        <div class="form-group">
            <label for="">{{ __('label.organize.costs') }}</label>
            <input class="form-control" value="{{ isset($organize->costs) ? $organize->costs : '' }}" name="costs"  type="text">
        </div>
    </div>