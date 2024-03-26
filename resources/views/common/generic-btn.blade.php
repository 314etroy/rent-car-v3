@props([
    'class' => '',
    'wire_method' => null,
    'btn_content' => '',
    'data_modal_target' => '',
    'data_modal_show' => '',
    'data_modal_row_id' => null,
    'is_disabled' => false,
    'onclick' => '',
    'href' => null,
])

<a {!! setProperties('href', $href) !!}>
    <button 
        {!! setProperties('class', $class) !!}
        {!! setProperties('disabled', $is_disabled) !!}
        {!! setProperties('wire:click', $wire_method) !!}
        {!! setProperties('data-modal-target', $data_modal_target) !!}
        {!! setProperties('data-modal-show', $data_modal_show) !!}
        {!! setProperties('data-modal-row-id', $data_modal_row_id) !!}
        {!! setProperties('onclick', $onclick) !!}
    >
        {{ $btn_content }}
    </button>
</a>
