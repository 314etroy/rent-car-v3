@props([
    'commonTypeHTML' => [
        'text',
        'email',
        'tel',
        'number',
        'search',
        'password',
        'date',
        'time',
        'url',
        'color',
        'checkbox',
        'radio',
        'file',
        'files',
        'hidden',
    ],
    'hideLabel' => false,
    'isDisabled' => false,
    'isRequired' => false,
    'isMultiple' => false,

    'rows' => null,
    'inputData' => null,
    'step' => null, // in seconds

    'id' => '',
    'key' => '',
    'ariaLabel' => '',
    'labelClass' => '',
    'placeholder' => '',
    'wireModelType' => null,
    'wireModelName' => '',
    'selectDefaultText' => '',
    'style' => '',
    'divClass' => '',
    'labelText' => '',

    'emptyLabelClass' => '',
    'validLabelClass' => '',
    'errorLabelClass' => '',
    'emptyInputClass' => '',
    'validInputClass' => '',
    'errorInputClass' => '',

    'display' => true,
    'showValidationMsg' => true,
    'showDefaultOption' => true,
    'selectHaveDafaultValue' => true,
])

<div {!! setProperties('class', $divClass) !!}>
    @if ($display)
        @if (!$hideLabel)
            <label {!! setProperties('for', $key) !!} {!! setProperties('class', $labelClass) !!}>
                <span {!! setProperties('class', $emptyLabelClass) !!}>
                    {!! empty($labelText) ? ucfirst(str_replace('-', ' ', hasValue($key, 'EMPTY_LABEL'))) . ' ' : $labelText !!}
                    @if ($isRequired)
                        <span class="text-red-500">*</span>
                    @endif
                    @if ($showValidationMsg)
                        @if ($errors->has($wireModelName))
                            @error("$wireModelName")
                                <span {!! setProperties('class', $errors->has($wireModelName) ? $errorLabelClass : $validLabelClass) !!}>{{ $message }}</span>
                            @enderror
                        @endif

                        @if (!$errors->has($wireModelName) && !empty($inputData))
                            <span {!! setProperties('class', $validLabelClass) !!}>este ok</span>
                        @endif
                    @endif

                </span>

            </label>
        @endif

        @switch($type)
            @case(in_array($type, $commonTypeHTML))
                <input type="{{ $type }}" {!! setProperties('id', empty($id) ? $key : $id) !!} {!! setProperties('name', $key) !!} {!! setProperties('style', $style) !!}
                    {!! setProperties('step', $step) !!} {!! setProperties('required', $isRequired) !!} {!! setProperties('disabled', $isDisabled) !!} {!! setProperties('multiple', $isMultiple) !!}
                    {!! setProperties('aria-label', $ariaLabel) !!} {!! setProperties('placeholder', ucfirst($placeholder), $type) !!} {!! setProperties($wireModelType ?? 'wire:model.live', $wireModelName) !!} {!! setProperties('class', $errors->has($wireModelName) ? $errorInputClass : $emptyInputClass) !!} />
            @break

            @case('textarea')
                <textarea {!! setProperties('id', $key) !!} {!! setProperties('name', $key) !!} {!! setProperties('rows', $rows) !!} {!! setProperties('style', $style) !!}
                    {!! setProperties('required', $isRequired) !!} {!! setProperties('disabled', $isDisabled) !!} {!! setProperties('aria-label', $ariaLabel) !!} {!! setProperties('placeholder', ucfirst($placeholder)) !!}
                    {!! setProperties($wireModelType ?? 'wire:model.live', $wireModelName) !!} {!! setProperties('class', $errors->has($wireModelName) ? $errorInputClass : $emptyInputClass) !!}></textarea>
            @break

            @case('select')
                <select {!! setProperties('id', $key) !!} {!! setProperties('name', $key) !!} {!! setProperties('style', $style) !!} {!! setProperties('required', $isRequired) !!}
                    {!! setProperties('disabled', $isDisabled) !!} {!! setProperties('multiple', $isMultiple) !!} {!! setProperties('aria-label', $ariaLabel) !!} {!! setProperties($wireModelType ?? 'wire:model.live', $wireModelName) !!}
                    {!! setProperties('class', $errors->has($wireModelName) ? $errorInputClass : $emptyInputClass) !!}>
                    @if ($showDefaultOption)
                        <option value="" disabled>{{ $selectDefaultText }}</option>
                    @endif
                    @foreach ($allOptions ?? [] as $key => $val)
                        <option value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                </select>
            @break

            @default
        @endswitch
    @endif
</div>
