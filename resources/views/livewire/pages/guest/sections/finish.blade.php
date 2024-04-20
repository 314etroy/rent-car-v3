{{-- Section 5 --}}
<section class="mt-4" wire:poll.2s='changeSection("5")'>
    <div class="mx-auto max-w-7xl bg-white flex justify-center">
        <div class="py-5">
            <div class="container relative">
                <div class="text-center">
                    <div class="px-10 py-72 my-7">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900">Mulțumim pentru rezervare!</h1>
                        <h2 class="tracking-tight text-gray-900">Rezervarea a fost înregistrată în sistemul nostru. Pentru orice informații referitoare la rezervarea dumneavoastră sau pentru adăugarea șoferului secundar, vă rugăm să va conectați la contul dumneavoastră sau să ne contactati prin oricare dintre metodele de contact.</h2>
                        <a href="/" class="link-to">
                            <button class="w-[400px] h-[40px] p-2 rounded-md text-white bg-[#7963e0] hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800" wire:click="changeSection(&quot;1&quot;)">
                                Către prima pagină
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
