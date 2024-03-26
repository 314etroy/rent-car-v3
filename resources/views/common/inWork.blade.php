<div class="w-full mb-5" style="background: #{{ rand(0, 9) * 100000 + rand(0, 9) * 1000 }}">
    <div class="container">
        <div class="row vh-100 ">
            <div class="col-12 align-self-center p-5">
                <div class="flex flex-col items-center justify-center">

                    <a href="{{ route('home') }}" class="logo logo-admin">
                        @include('svg.application-logo', ['class' => 'w-[300px]', 'fill' => 'bg-black'])
                    </a>

                    <div class="text-center font-semibold">
                        <h4 class="mt-0 mb-3">This zone is still in work</h4>
                        <p class="text-muted mb-0">Please contact us for more details.</p>
                    </div>

                </div>
                <!--end /div-->

            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</div>
