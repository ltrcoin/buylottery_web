<div class="box-header with-border">
    <h3 class="box-title">{{ __('label.organize.investors') }}</h3>
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
        <label>{{ __('label.organize.representative_name') }}<span style="color: #f00">*</span></label>
        <input class="form-control" value="{{ isset($organize->legal_representative_name) ? $organize->legal_representative_name : '' }}" name="legal_representative_name" type="text">
    </div>

    {{-- <div class="form-group">
        <label>{{ __('label.organize.type_investment_funds') }}<span style="color: #f00">*</span></label>
        <select name="type_investment_funds" class="form-control select2" style="width: 100%;">
            @foreach($lstTypeInvestmentFunds as $data)
                <option value="{{$data->code}}" {{ (isset($organize->type_investment_funds) && strpos($organize->type_investment_funds, $data->code) !== false) ? 'selected' : '' }} >
                    {{$data->name}}
                </option>
            @endforeach
        </select>
    </div> --}}

    <div class="form-group">
        <label for="tel">{{ __('label.organize.tel') }}<span style="color: #f00">*</span></label>
        <input class="form-control" value="{{ isset($organize->tel) ? $organize->tel : '' }}" name="tel" type="text">
    </div>

    <div class="form-group">
        <label>{{ __('label.organize.email') }}<span style="color: #f00">*</span></label>
        <input class="form-control" value="{{ isset($organize->email) ? $organize->email : '' }}" name="email" type="email">
    </div>

    <div class="form-group">
        <label for="comment">{{ __('label.organize.total_current_capital') }}<span style="color: #f00">*</span></label>
        <input class="form-control" value="{{ isset($organize->total_current_capital) ? $organize->total_current_capital : '' }}" name="total_current_capital" type="text">
    </div>

    <div class="form-group">
        <label>{{ __('label.organize.investment_sector') }}</label>
        <select name="investment_sector[]" class="form-control select2" multiple="multiple"
                style="width: 100%;">
            @foreach($lstInvestmentSector as $data)
                <option value="{{$data->code}}" {{ (isset($organize->investment_sector) && strpos($organize->investment_sector, $data->code) !== false) ? 'selected' : '' }} >
                    {{$data->name}}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="comment">{{ __('label.organize.number_of_startups_invested') }}</label>
        <input class="form-control" value="{{ isset($organize->number_of_startups_invested) ? $organize->number_of_startups_invested : '' }}" name="number_of_startups_invested" type="text">
    </div>

    <div class="form-group">
        <label for="comment">{{ __('label.organize.investment_capital') }} (USD)</label>
        <input class="form-control" value="{{ isset($organize->investment_capital) ? $organize->investment_capital : '' }}" name="investment_capital" type="text">
    </div>
    
</div>