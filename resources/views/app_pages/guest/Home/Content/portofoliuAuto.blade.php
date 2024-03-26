<section id="portfolio" class="section-Portfolio 2xl:py-[80px] py-[70px]">
    <div class="banner text-center mb-[30px]" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="300">
        <span class="text-[14px] text-[#ddd]">Portofoliu de masini</span>
        <h2
            class="text-center mt-[5px] text-white 2xl:text-[35px] xl:text-[33px] lg:text-[30px] md:text-[26px] sm:text-[24px] text-[22px] font-bold">
            Portofoliul <span class="text-[#7963e0]"> nostru</span></h2>
    </div>
    <div
        class="flex flex-wrap justify-between items-center mx-auto 2xl:max-w-[1320px] xl:max-w-[1140px] lg:max-w-[960px] md:max-w-[720px] sm:max-w-[540px] max-[320px]:px-[12px] px-6">
        <div class="m-b-minus-24px w-full">
            <div class="portfolio-content" id="MixItUpDA2FB7" data-aos="fade-up" data-aos-duration="2000"
                data-aos-delay="600">
                <div class="portfolio-tabs mb-[30px]">
                    {{-- <ul class="2xl:flex xl:flex md:flex sm:block place-content-center text-center">
                        <li class="text-[14px] text-[#ddd] 2xl:mx-[10px] sm:mx-[0px] px-[10px] leading-[11px] font-semibold hover:text-[#7963e0] cursor-pointer inline-block active"
                            data-filter="all">
                            ALL</li>
                        <li class="text-[14px] text-[#ddd] 2xl:mx-[10px] sm:mx-[0px] px-[10px] leading-[11px] font-semibold hover:text-[#7963e0] cursor-pointer inline-block"
                            data-filter=".design">DESIGN</li>
                        <li class="text-[14px] text-[#ddd] 2xl:mx-[10px] sm:mx-[0px] px-[10px] leading-[11px] font-semibold hover:text-[#7963e0] cursor-pointer inline-block"
                            data-filter=".development">DEVELOPMENT</li>
                        <li class="text-[14px] text-[#ddd] 2xl:mx-[10px] sm:mx-[0px] px-[10px] leading-[11px] font-semibold hover:text-[#7963e0] cursor-pointer inline-block"
                            data-filter=".graphics">GRAPHICS</li>
                        <li class="text-[14px] text-[#ddd] 2xl:mx-[10px] sm:mx-[0px] px-[10px] leading-[11px] font-semibold hover:text-[#7963e0] cursor-pointer inline-block"
                            data-filter=".templates">Templates</li>
                    </ul> --}}
                </div>
                <div class="portfolio-content-items">
                    <div class="grid lg:grid-cols-2 sm:grid-cols-2 grid-cols-1 gap-[30px]">
                        <div class="mix graphics templates">
                            <div class="portfolio-img truncate rounded-2xl relative">
                                <img src='{{ asset('assets/img/jpeg/logan-alb.jpg') }}'
                                    class="transform hover:bg-blue-600 transition duration-500 hover:-rotate-12 hover:scale-125 flex h-[350px] w-full justify-center bg-cover">
                                <h3 class="top-contain absolute top-[15px] right-[15px]">
                                    <span class="bg-black rounded-full text-white font-normal text-[12px] px-2 py-1">Cea
                                        mai aleasa masina</span>
                                    <span
                                        class="bg-black rounded-full text-white font-normal text-[12px] px-2 py-1">Fiabila</span>
                                </h3>
                                <div class="bottom-contain absolute bottom-4 left-4 right-4">
                                    <div
                                        class="overlay-info px-4 py-2 bg-black bg-opacity-60 rounded-xl grid grid-cols-2 gap-[30px] place-content-between">
                                        <a href="#" class="text-white text-sm flex items-center">Dacia Logan Expression Tce 90 MT6</a>
                                        <a href="{{ asset('assets/img/jpeg/logan-alb.jpg') }}" data-fancybox="gallery"
                                            class="text-white text-sm grid justify-items-end">
                                            <p class="hidden">.</p>
                                            <span
                                                class="bg-[#7963e0] h-8 w-8 flex justify-center items-center rounded-md">
                                                <i class="fa-solid fa-arrow-right"></i>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mix design">
                            <div class="portfolio-img truncate rounded-2xl relative">
                                <img src='{{ asset('assets/img/jpeg/spring.jpg') }}' alt="design"
                                    class="transform hover:bg-blue-600 transition duration-500 hover:-rotate-12 hover:scale-125 flex h-[350px] w-full justify-center bg-cover">
                                <h3 class="top-contain absolute top-[15px] right-[15px]">
                                    <span class="bg-black rounded-full font-normal text-white text-[12px] px-2 py-1">Cea
                                        mai economica</span>
                                </h3>
                                <div class="bottom-contain absolute bottom-4 left-4 right-4">
                                    <div
                                        class="overlay-info px-4 py-2 bg-black bg-opacity-60 rounded-xl grid grid-cols-2 gap-[30px] place-content-between">
                                        <a href="#" class="text-white text-sm flex items-center">Dacia Spring Extreme</a>
                                        <a href="{{ asset('assets/img/jpeg/spring.jpg') }}" data-fancybox="gallery"
                                            class="text-white text-sm grid justify-items-end">
                                            <p class="hidden">.</p>
                                            <span
                                                class="bg-[#7963e0] h-8 w-8 flex justify-center items-center rounded-md">
                                                <i class="fa-solid fa-arrow-right"></i>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
