@props([
    'imageUrl' => '',
    'description' => '',
    'redirectUrl' => '',
    'width' => '400px',
    'height' => '40px',
])

<div class="text-center text-white md:text-3xl text-xl font-semibold my-5 h-[300px]"
    style="background-image: url({{ $imageUrl }}); width: 100%; background-size:cover; background-position:center; align-items:center; display:flex; justify-content:center; color:white;">
    <div>
        <h1>{{ $description }}</h1>
        @include('common.generic-btn', [
            'btn_content' => 'Rezervă acum',
            'href' => $redirectUrl,
            'wire_method' => 'changeSection("1")',
            'class' => 'w-[' . $width . '] h-[' . $height . '] p-2 rounded-md ' . getConstant('modal_generic_colors')['purple'],
        ])
    </div>
</div>
