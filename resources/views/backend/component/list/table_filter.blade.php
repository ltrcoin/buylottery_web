<tr class="{{ count($fields) }}">
    @foreach($fields as $f)
        @if($f['filter_type'] === '#' || empty($f['filter_type']))
            <th></th>
        @elseif($f['filter_type'] === 'text')
            <th>
                <input type="text" placeholder="{{ trans('Search') }} {{ trans($f['title']) }}" class="form-control column_filter" data-filter-type="{{ $f['filter_type'] }}" data-column="{{ $loop->index }}" id="column{{ $loop->index }}_filter">
            </th>
        @elseif($f['filter_type'] == 'select')
            <th>
                <select class="select2 form-control column_filter" data-filter-type="{{ $f['filter_type'] }}" data-column="{{ $loop->index }}" id="column{{ $loop->index }}_filter">
                    <option value="">{{ trans('label.all') }}</option>
                    @php
                    if(!empty($f['refer']) && is_array($f['refer'])
                    && array_key_exists('source_table', $f['refer'])
                    && array_key_exists('value_column', $f['refer'])
                    && array_key_exists('label_column', $f['refer'])
                    && !empty($f['refer']['value_column'])
                    && !empty($f['refer']['label_column'])
                    ) {
                        $refSource = DB::table($f['refer']['source_table'])->select($f['refer']['value_column'], $f['refer']['label_column'])->get();
                    }

                    @endphp
                    @if(!empty($refSource))
                    @foreach($refSource as $ref)
                        <option value="{{ $ref->{$f['refer']['value_column']} }}">{{ $ref->{$f['refer']['label_column']} }}</option>
                    @endforeach
                    @endif
                </select>
            </th>
        @elseif($f['filter_type'] == 'date-range')
            <th>
                <input data-column="{{ $loop->index }}" type="text" class="form-control pull-right column_filter" data-filter-type="{{ $f['filter_type'] }}" id="column{{ $loop->index }}_filter">
            </th>
        @endif
    @endforeach
</tr>