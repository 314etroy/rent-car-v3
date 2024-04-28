<div>
    <section class="flex justify-center bg-white" style="padding: 50px 10%">
        <div class="container p-5">
            <div class="grid lg:grid-cols-2 grid-cols-1 gap-6">
                <div>
                    <h2 class="md:text-3xl text-xl font-semibold my-5">Contactează-ne</h2>
                    <p class="text-slate-700">Pentru mai multe informații referitoare la serviciile noastre vă rugăm completați formularul sau să ne contactați prin oricare metode prezente în această pagină.</p>
                    <p class="text-slate-500 mt-12">Adresa noastră de email:</p>
                    <h4>
                        <a href="mailto:contact@starentinchirieriauto.ro" class="text-lg font-semibold text-slate-600">contact@starentinchirieriauto.ro</a>
                    </h4>
                    <p class="text-slate-500 mt-12">Telefon de contact:</p>
                    <h4>
                        <a href="tel:0722-222-222" class="text-lg font-semibold text-slate-600">0722-222-222</a>
                    </h4>
                    <div class="mt-12">
                        <div class="flex flex-col gap-3">
                            <h5 class="text-slate-400">Ne puteti găsi pe social media:</h5>
                            <div class="flex gap-5">
                                <div>
                                    <a href="https://www.facebook.com/starent">
                                        <svg class="w-7 h-7 text-slate-500" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                                <div>
                                    <a href="https://www.instagram.com/starent">
                                        <svg class="w-7 h-7 text-slate-500" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="2" y="2" width="20" height="20" rx="5"
                                                ry="5">
                                            </rect>
                                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="row">
                        <div class="col-sm-6 mb-2">
                            <label class="form-label">
                                Nume și prenume
                                <span class="text-danger-alt">*</span>
                            </label>
                            <div class="input-group form ">
                                <input class="form-control {{ config('constants.common_css.contact.empty_input') }}"
                                    type="text" name="nameSiPrenume"
                                    wire:model.debounce.200ms="formFildsContent.nameSiPrenume"
                                    placeholder="Nume complet">
                            </div>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <label class="form-label">
                                Email
                                <span class="text-danger-alt">*</span>
                            </label>
                            <div class=" input-group form">
                                <input class="form-control {{ config('constants.common_css.contact.empty_input') }}"
                                    type="email" name="email" wire:model.debounce.200ms="formFildsContent.email"
                                    placeholder="Emailul dumneavoastră">
                            </div>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <label class="form-label">
                                Telefon
                                <span class="text-danger-alt">*</span>
                            </label>
                            <div class=" input-group form">
                                <input class="form-control {{ config('constants.common_css.contact.empty_input') }}"
                                    type="phone" name="phone" wire:model.debounce.200ms="formFildsContent.phone"
                                    placeholder="Numărul de telefon">
                            </div>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <label class="form-label">
                                Subiect
                                <span class="text-danger-alt">*</span>
                            </label>
                            <div class=" input-group form">
                                <input class="form-control {{ config('constants.common_css.contact.empty_input') }}"
                                    type="text" name="subiect" wire:model.debounce.200ms="formFildsContent.subject"
                                    placeholder="Subiect">
                            </div>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <label class="form-label">
                                Mesaj
                                <span class="text-danger-alt">*</span>
                            </label>
                            <div class=" input-group form">
                                <textarea class="form-control {{ config('constants.common_css.contact.empty_textarea') }}" type="number" name="mesaj"
                                    rows="5" wire:model.debounce.200ms="formFildsContent.mesaj" placeholder="Adăugați mesaj"></textarea>
                            </div>
                        </div>
                        <div id="errors" style="margin-top: 10px">
                            @if (!empty($errorMsgs) && !$successMsg)
                                <div
                                    class="alert alert-danger mb-4 alert-dismissible text-white bg-red-500 border border-red-500">
                                    <span class="ml-4">{{ reset($errorMsgs) }}</span>
                                </div>
                            @endif
        
                            @if (empty($errorMsgs) && $successMsg)
                                <div
                                    class="alert alert-success mb-4  alert-dismissible text-white bg-green-500 border border-green-500">
                                    <span class="alert-heading ml-4">Cererea a fost trimisă cu succes.</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex justify-end">
                            @include('common.generic-btn', [
                                'btn_content' => 'Trimite mesaj',
                                'wire_method' => 'handleSubmit',
                                'class' =>
                                    'w-full p-2 rounded-md ' . getConstant('modal_generic_colors')['purple'],
                            ])
                        </div>
                        
                    </div>
                </div>
               
            </div>
        </div>

    </section>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d89876.85852940445!2d24.988596499804682!3d45.25483289432369!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40b329b90719bcb7%3A0xd4d45c5e5ba46dad!2sC%C3%A2mpulung!5e0!3m2!1sro!2sro!4v1708299022213!5m2!1sro!2sro" width="100%" height="400px" style="border:0;" allowfullscreen="" loading="async" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
