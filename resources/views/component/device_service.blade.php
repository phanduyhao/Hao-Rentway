<!-- resources/views/components/device_service.blade.php -->
<div class="form-group col-md-12">
    <label>{{ __('post.device_service') }}</label>
    <div class="o-features">
        <ul class="no-ul-list third-row">
            @foreach ($thietbis as $thietbi)
                @php
                    // Kiểm tra nếu thiết bị có trong danh sách đã chọn
                    $isChecked = in_array($thietbi->title, $selectedThietBiNames ?? []);
                @endphp
                <li class="d-flex align-items-center gap-2">
                    <input id="{{ $thietbi->id }}" class="form-check-input"
                        name="thietbis[{{ $thietbi->id }}]" type="checkbox"
                        value="{{ $thietbi->title }}" {{ $isChecked ? 'checked' : '' }}>

                    <input type="hidden" name="icon_thietbi[{{ $thietbi->id }}]" value="{{ $thietbi->icon }}">

                    <div>
                        @if ($thietbi->icon != null)
                            <img src="{{ $thietbi->icon }}" width="30px" alt="">
                        @endif
                        <label for="{{ $thietbi->id }}" class="form-check-label">{{ $thietbi->title }}</label>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
