<select id="house_direction" class="form-control" name="huongnha">
    <option value="">{{ __('common.select_house_direction') }}</option>
    <option value="dong" {{ ($selectedValue == 'dong' || request()->query('huongnha') == 'dong') ? 'selected' : '' }}>{{ __('common.east') }}</option>
    <option value="tay" {{ ($selectedValue == 'tay' || request()->query('huongnha') == 'tay') ? 'selected' : '' }}>{{ __('common.west') }}</option>
    <option value="nam" {{ ($selectedValue == 'nam' || request()->query('huongnha') == 'nam') ? 'selected' : '' }}>{{ __('common.south') }}</option>
    <option value="bac" {{ ($selectedValue == 'bac' || request()->query('huongnha') == 'bac') ? 'selected' : '' }}>{{ __('common.north') }}</option>
    <option value="dongbac" {{ ($selectedValue == 'dongbac' || request()->query('huongnha') == 'dongbac') ? 'selected' : '' }}>{{ __('common.northeast') }}</option>
    <option value="dongnam" {{ ($selectedValue == 'dongnam' || request()->query('huongnha') == 'dongnam') ? 'selected' : '' }}>{{ __('common.southeast') }}</option>
    <option value="taybac" {{ ($selectedValue == 'taybac' || request()->query('huongnha') == 'taybac') ? 'selected' : '' }}>{{ __('common.northwest') }}</option>
    <option value="taynam" {{ ($selectedValue == 'taynam' || request()->query('huongnha') == 'taynam') ? 'selected' : '' }}>{{ __('common.southwest') }}</option>
    <option value="be_boi" {{ ($selectedValue == 'be_boi' || request()->query('huongnha') == 'be_boi') ? 'selected' : '' }}>{{ __('common.swimming_pool') }}</option>
    <option value="ngoai_troi" {{ ($selectedValue == 'ngoai_troi' || request()->query('huongnha') == 'ngoai_troi') ? 'selected' : '' }}>{{ __('common.outdoor') }}</option>
    <option value="duong" {{ ($selectedValue == 'duong' || request()->query('huongnha') == 'duong') ? 'selected' : '' }}>{{ __('common.street_view') }}</option>
    <option value="dong_tu_trach" {{ ($selectedValue == 'dong_tu_trach' || request()->query('huongnha') == 'dong_tu_trach') ? 'selected' : '' }}>{{ __('common.dong_tu_trach') }}</option>
    <option value="tay_tu_trach" {{ ($selectedValue == 'tay_tu_trach' || request()->query('huongnha') == 'tay_tu_trach') ? 'selected' : '' }}>{{ __('common.tay_tu_trach') }}</option>
</select>
