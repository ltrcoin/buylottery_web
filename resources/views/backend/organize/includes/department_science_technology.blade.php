<div class="box-header with-border">
    <h3 class="box-title">{{ __('label.organize.organizing_scientific_and_technological_department') }}</h3>
</div>
<div class="box-body">
    <div class="form-group">
        <label for="">{{ __('label.organize.address') }}<span style="color: #f00">*</span></label>
        <input class="form-control" value="{{ isset($organize->address) ? $organize->address : '' }}" name="address" id="address_map" type="text">
        <input type="hidden" id="lat" name="lat" />
        <input type="hidden" id="lng" name="lng" />
    </div>
    <div id="map"></div>

    <div class="form-group">
        <label>{{ __('label.organize.city') }}<span style="color: #f00">*</span></label>
        <select name="matp" class="form-control select2" style="width: 100%;">
            @foreach($listCity as $data)
                <option value="{{$data->matp}}" {{ (isset($organize->matp) && ($organize->matp == $data->matp)) ? 'selected' : '' }} >
                    {{$data->name}}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>{{ __('label.organize.tel') }}<span style="color: #f00">*</span></label>
        <input class="form-control" value="{{ isset($organize->tel) ? $organize->tel : '' }}" name="tel" type="text">
    </div>

    <div class="form-group">
        <label>{{ __('label.organize.email') }}<span style="color: #f00">*</span></label>
        <input class="form-control" value="{{ isset($organize->email) ? $organize->email : '' }}" name="email" type="email">
    </div>
</div>