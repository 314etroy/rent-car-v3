@props([
    'modal_id' => null,
    'header_name',
    'modal_fields' => null,
    'btn_name' => '',
    'btn_collor' => null,
    'canBeClosed' => null,
    'type' => null,
    'delete_msg' => '',
    'row_id' => null,
])

<div id="{{ $modal_id }}" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">

    <div class="relative w-full max-w-2xl max-h-full z-50">
        <!-- Modal content -->
        <form class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $header_name }}: <span id="{{ $type . '_row_id' }}"></span>
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="{{ $modal_id }}">
                    @if ($canBeClosed)
                        @include('svg.modal-close-icon')
                    @endif
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6">
                @switch($type)
                    @case('create')
                    @case('edit')
                        @foreach ($modal_fields ?? [] as $value)
                            @include('common.genericInputFields', $value)
                        @endforeach
                    @break

                    @case('delete')
                        {{ $delete_msg }}
                    @break

                    @default
                        Put a correct type.
                @endswitch

            </div>
            <!-- Modal footer -->
            <div
                class="flex justify-end items-center p-6 space-x-3 rtl:space-x-reverse border-t border-gray-200 rounded-b dark:border-gray-600">
                @include('common.generic-btn', [
                    'btn_content' => $btn_content,
                    'class' => getConstant('modal_generic_colors')[$btn_collor],
                ])
            </div>
        </form>
    </div>

    <div {!! setProperties('data-modal-backdrop', $canBeClosed ? null : 'static') !!} {!! setProperties('data-modal-hide', $canBeClosed ? $modal_id : null) !!}
        class="bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40 flex items-center justify-center">
    </div>

</div>
