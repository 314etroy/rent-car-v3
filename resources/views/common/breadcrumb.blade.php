@props([
    'breadcrumbButtons' => [
        ['content' => 'rent_date_section'],
        ['content' => 'choose_car_section'],
        ['content' => 'additional_services_section'],
        ['content' => 'check_out_section'],
        // ['content' => 'finish_section'],
    ],
])

{{-- Breadcrumb Section --}}
<section class="bg-white mt-20">
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumb Nav -->
        <nav class="bg-white flex justify-center px-5 py-3 text-gray-700"
            aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">

                @foreach ($breadcrumbButtons ?? [] as $index => $value)
                    {{-- @include('common.breadcrumb-button', [
                        'content' => $value['content'],
                        'sectionNumber' => $index,
                        'isActive' => $index <= $step
                    ]) --}}
                    @livewire('pages.guest.common.breadcrumb-button', [
                        'content' => $value['content'],
                        'sectionNumber' => $index,
                        'isActive' => $index <= $step,
                    ], key(uniqid()))
                @endforeach

            </ol>
        </nav>
    </div>
</section>
