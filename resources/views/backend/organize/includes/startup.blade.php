<div class="box-header with-border">
    <h3 class="box-title">{{ __('label.organize.startup') }}</h3>
</div>
    <div class="box-body">
        <div class="form-group">
            <label for="">{{ __('label.organize.tax_code') }}</label>
            <input class="form-control" value="{{ isset($organize->tax_code) ? $organize->tax_code : '' }}"  name="tax_code" type="text">
         </div>
        
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
            <label>{{ __('label.organize.established_date') }}<span style="color: #f00">*</span></label>
            <div class="input-group date">
                <input value="{{ isset($organize->established_date) ? $organize->established_date : '' }}" class="form-control pull-right datepicker" name="established_date" type="date">
                <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
                </div>
            </div>
            <div id="established_date"></div>   
            <!-- /.input group -->
        </div>
        <div class="panel-group" id="legal_representative_area" role="tablist" aria-multiselectable="true">
            @if(isset($lstRepresentative))
                @foreach($lstRepresentative as $key => $item)
                    {!! view('backend.organize.includes.legal_representative' , [
                        'lstDiploma' => $lstDiploma,
                        'organize' => $item,
                        'item' => $key
                    ])->render() !!}
                @endforeach
            @else
                {!! view('backend.organize.includes.legal_representative' , [
                    'lstDiploma' => $lstDiploma,
                    'item' => 0
                ])->render() !!}
            @endif
        </div>
        <div class="form-group">
            <button type="button" onclick="addFounder()" class="btn btn-primary">{{__('label.organize.new_legal_representative_name')}}</button>
        </div>

        <div class="form-group">
            <label>{{ __('label.organize.tel') }}<span style="color: #f00">*</span></label>
            <input class="form-control" value="{{ isset($organize->tel) ? $organize->tel : '' }}"  name="tel" type="text">
        </div>

        <div class="form-group">
            <label>{{ __('label.organize.business_areas') }}<span style="color: #f00">*</span></label>
            <select name="business_areas[]" class="form-control select2" multiple="multiple"
                style="width: 100%;">
                @foreach($lstInvestmentSector as $data)
                    <option value="{{$data->code}}" {{ (isset($organize->business_areas) && strpos($organize->business_areas, $data->code) !== false) ? 'selected' : '' }} >
                        {{$data->name}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>{{ __('label.organize.needs_tobe_supported') }}</label>
            <select name="needs_tobe_supported[]" class="form-control select2" multiple="multiple"
                    style="width: 100%;">
                @foreach($lstSupportType as $data)
                    <option value="{{$data->code}}" {{ (isset($organize->needs_tobe_supported) && strpos($organize->needs_tobe_supported, $data->code) !== false) ? 'selected' : '' }} >
                        {{$data->name}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>{{ __('label.organize.target_market') }}<span style="color: #f00">*</span></label><br>
            <label class="radio-inline">
                <input type="radio"  {{ (isset($organize->target_market) && $organize->target_market =='Trong nước') ? 'checked' : '' }} value="Trong nước" name="target_market">{{ __('label.organize.domestic') }}</label>
            <label class="radio-inline">
                <input type="radio"  {{ (isset($organize->target_market) && $organize->target_market =='Quốc tế') ? 'checked' : '' }} value="Quốc tế" name="target_market">{{ __('label.organize.international') }}</label>
            <label class="radio-inline">
                <input type="radio"  {{ (isset($organize->target_market) && $organize->target_market =='Trong khu vực/vùng miền') ? 'checked' : '' }} value="Trong khu vực/vùng miền" name="target_market">{{ __('label.organize.area_region') }}</label>
            <div id="target_market"></div>
        </div>
        
        <div class="form-group">
            <label>{{ __('label.organize.email') }}<span style="color: #f00">*</span></label>
            <input class="form-control" value="{{ isset($organize->email) ? $organize->email : '' }}" name="email" type="email">
        </div>

        <div class="form-group">
            <label for="comment">{{ __('label.organize.outstanding_features_1') }}</label>
            <textarea class="form-control" name="outstanding_features" rows="5" id="comment">{{ isset($organize->outstanding_features) ? $organize->outstanding_features : '' }}</textarea>
        </div> 

        <div class="form-group">
            <label for="comment">{{ __('label.organize.outstanding_features_2') }}</label>
            <textarea class="form-control" name="outstanding_features_1" rows="5" id="comment">{{ isset($organize->outstanding_features_1) ? $organize->outstanding_features_1 : '' }}</textarea>
        </div> 

        <div class="form-group">
            <label for="comment">{{ __('label.organize.outstanding_features_3') }}</label>
            <textarea class="form-control" name="outstanding_features_2" rows="5" id="comment">{{ isset($organize->outstanding_features_2) ? $organize->outstanding_features_2 : '' }}</textarea>
        </div> 

        <div class="form-group" > 
            <label>{{ __('label.organize.investment_status') }}<span style="color: #f00">*</span></label>
            <label class="radio-inline">
                <input type="radio" {{ (isset($organize->investment_status) && $organize->investment_status =='Rồi') ? 'checked' : '' }} value="Rồi" name="investment_status">{{ __('label.organize.already') }}</label>
            <label class="radio-inline">
                <input type="radio" {{ (isset($organize->investment_status) && $organize->investment_status =='Chưa') ? 'checked' : '' }} value="Chưa" name="investment_status">{{ __('label.organize.not') }}</label>
            <div id="investment_status"></div>
        </div>
    </div>