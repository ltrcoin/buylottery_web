<div class="box-body">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group col-md-12">
					<label for="name">{{__('label.game.name')}}</label>
					<input readonly type="text" class="form-control" id="name" name="name" value="{{ old('name') ?? $item->name ?? '' }}">
				</div>
				<div class="form-group col-md-12">
					<label for="numbers">{{ __('label.game.numbers') }}</label>
					<input readonly class="form-control" type="number" id="numbers" name="numbers" value="{{ old('numbers') ?? $item->numbers ?? '' }}">
				</div>
				<div class="form-group col-md-12">
					<label for="ticket_price">{{ __('label.game.ticket_price') }}</label>
					<input readonly class="form-control" type="number" id="ticket_price" name="ticket_price" value="{{ old('ticket_price') ?? $item->ticket_price ?? '' }}">
				</div>
				<div class="form-group col-md-12">
					<input disabled id="has_special_number" class="icheck-input" type="checkbox"
						   name="has_special_number" value="1" @if(!empty($item) && $item->has_special_number){{ 'checked' }}@endif>
					<label for="has_special_number">{{ __('label.game.has_special_number') }}</label>
				</div>
				<div class="form-group col-md-12">
					<label for="min_number">{{ __('label.game.min_number') }}</label>
					<input readonly class="form-control" type="number" min="0" name="min_number"
						   id="min_number" value="{{ old('min_number') ?? $item->min_number ?? null }}">
				</div>
				<div class="form-group col-md-12">
					<label for="max_number">{{ __('label.game.max_number') }}</label>
					<input readonly class="form-control" type="number" min="0" name="max_number"
						   id="max_number" value="{{ old('max_number') ?? $item->max_number ?? null }}">
				</div>
				<div class="special-info" @if(empty($item) || !$item->has_special_number)style="display: none"@endif>
					<div class="form-group col-md-12">
						<label for="min_special">{{ __('label.game.min_special') }}</label>
						<input readonly class="form-control" type="number" min="0" name="min_special"
							   id="min_special" value="{{ old('min_special') ?? $item->min_special ?? null }}">
					</div>
					<div class="form-group col-md-12">
						<label for="max_special">{{ __('label.game.max_special') }}</label>
						<input readonly class="form-control" type="number" min="0" name="max_special"
							   id="max_special" value="{{ old('max_special') ?? $item->max_special ?? null }}">
					</div>
					<div class="form-group col-md-12">
						<label for="special_numbers">{{ __('label.game.special_numbers') }}</label>
						<input readonly type="number" min="0" name="special_numbers" class="form-control"
							   id="special_numbers" value="{{ old('special_numbers') ?? $item->special_numbers ?? null }}">
					</div>
				</div>
				<div class="form-group col-md-12">
					<label for="draw_day">{{ __('label.game.draw_day') }}</label>
					<div class="row">
						@foreach(range(0, 6) as $weekDay)
							<div class="col-md-4">
								<label><input disabled type="checkbox" class="icheck-input"
											  name="draw_day[]" @if(!empty($drawDays) && in_array($weekDay, $drawDays)){{ 'checked' }}@endif
											  value="{{ $weekDay }}"> {{ __('label.week_day.' . $weekDay) }}
								</label>
							</div>
						@endforeach
					</div>
				</div>
				<div class="form-group col-md-12">
					<label for="draw_time">{{ __('label.game.draw_time') }}</label>
					<div class="input-group bootstrap-timepicker timepicker">
						<input readonly id="draw_time" value="{{ old('draw_time') ?? (!empty($item) ? ($item->draw_time != '24:00:00' ? $item->draw_time : '00:00:00') : '') }}" name="draw_time" type="text" class="form-control input-small">
						<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
					</div>
				</div>

				<div class="form-group col-md-12">
					<label for="id_game_api">{{ __('label.game.id_game_api') }}</label>
					<input readonly type="text" class="form-control" id="id_game_api"
						   placeholder="{{ __('label.game.id_game_api_placeholder') }}"
						   name="id_game_api" value="{{ old('id_game_api') ?? $item->id_game_api ?? '' }}">
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="row internal-info">
				@if(!empty($item) && !empty($item->image))
					<div class="form-group col-md-12">
						<label>{{ __('label.game.image') }}</label>
					</div>
					<div class="form-group col-md-12">
						<img src="{{ asset('upload/' . $item->image) }}" alt="{{ $item->name }}" class="img img-responsive">
					</div>
				@endif

				<div class="form-group col-md-12">
					<label for="description">{{ __('label.game.description') }}</label>
					<textarea readonly name="description" id="description" cols="30" rows="10"
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
				@foreach ($prizes as $prize)
					<tr fade-in fade-out>
						<td>
							{{ $prize->name }}
						</td>
						<td>
							{{ $prize->match }}
						</td>
						<td>
							{{ $prize->special_match }}
						</td>
						<td>
							{{ number_format($prize->value) }}
						</td>
						<td>
							{{ $prize->unit }}
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>