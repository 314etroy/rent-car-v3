<section id="news" class="section-news bg-[#161321]">
    <div class="relative pt-[60px]">
        <img src="assets/img/shape/bg-shape-dark.png" alt="bg-shape"
            class="absolute top-0 left-0 right-0 w-full bg-center bg-cover">
    </div>
    <div class="2xl:pb-[80px] pb-[70px] 2xl:pt-[80px] md:pt-[70px] pt-[20px]">
        <div class="banner text-center mb-[30px]" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="300">
            <span class="text-[14px] text-[#ddd]">Experiente Desavarsite</span>
            <h2
                class="text-center mt-[5px] text-white 2xl:text-[35px] xl:text-[33px] lg:text-[30px] md:text-[26px] sm:text-[24px] text-[22px] font-bold">
                Testiomonialele <span class="text-[#7963e0]"> clientilor nostri</span></h2>
        </div>
        <div class="flex flex-wrap justify-between items-center mx-auto mx-auto 2xl:max-w-[1320px] xl:max-w-[1140px] lg:max-w-[960px] md:max-w-[720px] sm:max-w-[540px] max-[320px]:px-[12px] relative px-6"
            data-aos="fade-up" data-aos-duration="2000" data-aos-delay="300">
            <div class="relative"></div>
            <div
                class="2xl:absolute 2xl:max-[1140px] xl:absolute xl:max-w-[720px] lg:absolute lg:max-w-[620px] max-w-[100%] relative">
                <div class="transition-all justify-start items-start">
                    <div class="news-slider">
                        <div class="carousel-wrap">
                            <div class="owl-carousel news-carousel owl-loaded owl-drag">
                                <div class="owl-stage-outer">
                                    <div class="owl-stage">
                                        <div class="owl-item">
                                            <div class="card bg-[#120f1c] rounded-2xl p-6">
                                                <img src='{{ asset('assets/img/png/testimonial_1.PNG') }}'
                                                    alt="news-3" class="rounded-2xl h-[200px]">
                                                <div class="news-card-details mt-[16px] ">
                                                    <p class="flex  text-[13px] leading-[30px] mb-[5px] text-[#7963e0]">
                                                        Daria Mihaela <span class="text-gray-400">
                                                            <div class="flex">
                                                                @foreach (range(1, 5) as $value)
                                                                    @include('svg.star')
                                                                @endforeach
                                                            </div>
                                                        </span>
                                                    </p>
                                                    <h5
                                                        class="text-white pb-[15px] text-[17px] mt-[5px] font-bold border-b border-[#27213b]">
                                                        {{ __('translations.translate_testimonial_1') }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="owl-item">
                                            <div class="card bg-[#120f1c] rounded-2xl p-6">
                                                <img src='{{ asset('assets/img/png/testimonial_2.PNG') }}'
                                                    alt="news-3" class="rounded-2xl h-[200px]">
                                                <div class="news-card-details mt-[16px] ">
                                                    <p class="flex  text-[13px] leading-[30px] mb-[5px] text-[#7963e0]">
                                                        Ionut Mihai <span class="text-gray-400">
                                                            <div class="flex">
                                                                @foreach (range(1, 5) as $value)
                                                                    @include('svg.star')
                                                                @endforeach
                                                            </div>
                                                        </span>
                                                    </p>
                                                    <h5
                                                        class="text-white pb-[15px] text-[17px] mt-[5px] font-bold border-b border-[#27213b]">
                                                        {{ __('translations.translate_testimonial_2') }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="transition-all flex-row 2xl:block xl:block lg:block hidden">
                <img src="assets/img/testimonialbck/8.jpg" alt="news" class=" rounded-[15px]" width="636"
                    height="599">
            </div>
        </div>
    </div>
</section>
