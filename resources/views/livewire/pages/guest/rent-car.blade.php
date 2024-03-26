<div class="bg-white">
    @if ($step === 0 || $step <= 4)
        {{-- Breadcrumb --}}
        @include('common.breadcrumb')
    @endif

    @switch($step)
        @case(0)
            {{-- Section 0 --}}
            @include('livewire.pages.guest.sections.rent_date')
        @break

        @case(1)
            {{-- Section 1 --}}
            @include('livewire.pages.guest.sections.choose_car')
        @break

        @case(2)
            {{-- Section 2 --}}
            @include('livewire.pages.guest.sections.additional_services')
        @break

        @case(3)
            {{-- Section 3 --}}
            @include('livewire.pages.guest.sections.check_out')
        @break

        @case(4)
            {{-- Section 4 --}}
            @include('livewire.pages.guest.sections.finish')
        @break

        @default
            {{-- Default --}}
            @include('livewire.pages.guest.sections.default')
    @endswitch
</div>
