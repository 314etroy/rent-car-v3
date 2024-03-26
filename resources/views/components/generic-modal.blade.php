<div x-data="{
    show: @entangle('show').defer,
    inhibModalClosure: @entangle('modalProps.inhibModalClosure').defer,
}" x-on:keydown.escape.window="show = false" x-cloak>
    {{-- , --}}
    <div class="fixed top-0 left-0 right-0 z-50 items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex"
        x-show="show">
        <div class="relative w-full max-w-2xl max-h-full z-50" x-on:click.away="if(!inhibModalClosure) show = false">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    @if (isset($modalHeader))
                        {{ $modalHeader }}
                        <button type="button" x-show="!inhibModalClosure" x-on:click="show = false"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            wire:click="closeModal()">
                            @include('svg.modal-close-icon')
                        </button>
                    @endif
                </div>

                <!-- Modal body -->
                @if (isset($modalBody))
                    {{ $modalBody }}
                @endif

                <!-- Modal footer -->
                @if (isset($modalFooter))
                    <div class="modal-footer">
                        {{ $modalFooter }}
                    </div>
                @endif
            </div>
        </div>

        <div x-show="inhibModalClosure"
            class="bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40 flex items-center justify-center">
        </div>

        <div x-show="!inhibModalClosure"
            class="bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40 flex items-center justify-center"
            wire:click="closeModal()">
        </div>

    </div>
</div>
