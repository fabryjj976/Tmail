<div x-data="{ in_app: {{ $in_app ? 'true' : 'false' }}, qr_code: false, show_loader: true, load_qr: false }" class="p-3 md:p-0 w-full md:w-40p order-2">
    <div x-show.transition.in="!in_app" class="space-y-5" style="display: none">
        <div class="border-2 border-white border-opacity-10 border-dashed rounded-md flex flex-col">
            <div class="text-lg font-bold text-center mt-8 mb-2">{{ __('Your Temporary Email Address') }}
            </div>
            <div class="m-5 flex justify-center">
                <div class="relative flex-1 max-w-email-dropdown sm:max-w-full">
                    <x-jet-dropdown align="top" width="w-full">
                        <x-slot name="trigger">
                            <div class="block appearance-none w-full truncate bg-white text-white py-4 px-5 pr-8 bg-opacity-10 rounded-md cursor-pointer focus:outline-none select-none"
                                id="email_id">{{ $email }}</div>
                        </x-slot>
                        <x-slot name="content">
                            @foreach ($emails as $email)
                                <x-jet-dropdown-link href="{{ route('switch', $email) }}">
                                    {{ $email }}
                                </x-jet-dropdown-link>
                            @endforeach
                        </x-slot>
                    </x-jet-dropdown>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-white">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                </div>
                <div class="btn_copy flex items-center bg-indigo-600 rounded-md text-white text-center py-4 px-5 ml-3 hover:bg-opacity-75 cursor-pointer"
                    style="background-color: {{ config('app.settings.colors.secondary') }}">
                    <i class="far fa-copy"></i>
                </div>
                <div class="ml-3 flex items-center">
                    <div class="border border-dashed border-white h-6"></div>
                </div>
                <div @click="qr_code = true; load_qr = true"
                    class="flex items-center bg-indigo-600 rounded-md text-white text-center py-4 px-5 ml-3 hover:bg-opacity-75 cursor-pointer"
                    style="background-color: {{ config('app.settings.colors.tertiary') }}">
                    <i class="fas fa-qrcode"></i>
                </div>
            </div>
        </div>
        <div class="actions grid grid-cols-3 gap-3">
            <div onclick="document.getElementById('refresh').classList.remove('pause-spinner')"
                class="flex justify-center items-center bg-white bg-opacity-10 hover:bg-opacity-25 text-white rounded-md text-center cursor-pointer py-3 px-4">
                <i id="refresh" class="fas fa-sync-alt fa-spin"></i>
                <div class="text-sm ml-3">{{ __('Refresh') }}</div>
            </div>
            <div x-on:click="in_app = true"
                class="flex justify-center items-center bg-white bg-opacity-10 hover:bg-opacity-25 text-white rounded-md text-center cursor-pointer py-3 px-4">
                <i class="far fa-plus-square"></i>
                <div class="text-sm ml-3">{{ __('New') }}</div>
            </div>
            <div wire:click="deleteEmail"
                class="flex justify-center items-center bg-white bg-opacity-10 hover:bg-opacity-25 text-white rounded-md text-center cursor-pointer py-3 px-4">
                <i class="far fa-trash-alt"></i>
                <div class="text-sm ml-3">{{ __('Delete') }}</div>
            </div>
        </div>
    </div>
    <div x-show.transition.in="in_app" class="space-y-5" style="display: none">
        <div class="border-2 border-white border-opacity-10 border-dashed rounded">
            <div class="m-5 flex space-x-3">
                <form wire:submit.prevent="create" method="post" class="flex-1 space-x-3 flex">
                    <div class="flex-1 space-y-3">
                        @if(config('app.settings.captcha') == 'hcaptcha' || config('app.settings.captcha') == 'recaptcha2')
                        <div class="-mb-5">
                            <x-captcha field="captcha" class="" />
                        </div>
                        @endif
                        <input class="block appearance-none w-full rounded-md py-4 px-5 bg-white text-white bg-opacity-10 focus:outline-none placeholder-white placeholder-opacity-50" type="text" name="user" id="user" wire:model="user" placeholder="{{ __('Enter Username') }}">
                        <div class="relative">
                            <x-jet-dropdown align="top" width="w-full">
                                <x-slot name="trigger">
                                    <input x-ref="domain" type="text"
                                        class="block appearance-none w-full bg-white text-white py-4 px-5 pr-8 bg-opacity-10 rounded-md cursor-pointer focus:outline-none select-none placeholder-white placeholder-opacity-50"
                                        placeholder="{{ __('Select Domain') }}" name="domain" id="domain"
                                        wire:model="domain" readonly>
                                </x-slot>
                                <x-slot name="content">
                                    @foreach ($domains as $domain)
                                        <a x-on:click="$refs.domain.value = '{{ $domain }}'; $wire.setDomain('{{ $domain }}')"
                                            class='block px-4 py-2 text-sm leading-5 text-gray-700 cursor-pointer hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out'>{{ $domain }}</a>
                                    @endforeach
                                </x-slot>
                            </x-jet-dropdown>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-white">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <button id="create"
                        class="flex items-center bg-indigo-600 rounded-md text-white text-center py-4 px-5 hover:bg-opacity-75 cursor-pointer"
                        style="background-color: {{ config('app.settings.colors.secondary') }}">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </form>
                <div class="flex items-center">
                    <div class="border border-dashed border-white h-6"></div>
                </div>
                <form wire:submit.prevent="random" method="post" class="flex">
                    <button id="random"
                        class="flex items-center bg-green-400 rounded-md text-white text-center py-4 px-5 hover:bg-opacity-75 cursor-pointer"
                        style="background-color: {{ config('app.settings.colors.tertiary') }}">
                        <i class="fas fa-random"></i>
                    </button>
                </form>
            </div>
        </div>
        @if (count($emails) > 0 && $in_app)
            <div>
                <a href="{{ route('mailbox') }}"
                    class="flex items-center bg-white bg-opacity-25 rounded-md text-white text-center py-3 px-5 space-x-3 hover:bg-opacity-10 cursor-pointer text-sm">
                    <i class="fas fa-chevron-left"></i>
                    <span>{{ __('Get back to MailBox') }}</span>
                </a>
            </div>
        @endif
        @if (!$in_app)
            <div>
                <div x-on:click="in_app = false"
                    class="flex justify-center items-center bg-white bg-opacity-25 rounded-md text-white text-center py-3 px-5 hover:bg-opacity-10 cursor-pointer text-sm">
                    <span>{{ __('Cancel') }}</span>
                </div>
            </div>
        @endif
    </div>
    <div @keydown.window.escape="qr_code = false" x-show="qr_code" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" x-ref="dialog" aria-modal="true" style="display: none">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"> 
            <div x-show="qr_code" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-description="" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="qr_code = false" aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&ZeroWidthSpace;</span>
            
            <div x-show="qr_code" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-description="Modal panel, show/hide based on modal state." class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle">
                <div class="bg-gray-900 px-4 py-5 sm:p-6" style="background-color: {{ config('app.settings.colors.primary') }}">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left space-y-5">
                        <h3 class="leading-6 text-center" id="modal-title">
                            {{ __('Scan QR Code to access') }}
                            <span class="block text-center text-sm">{{ $email }}</span>
                        </h3>
                        <div class="mt-2 space-y-3">
                            <div x-show="show_loader" class="flex justify-center text-4xl">
                                <i class="fas fa-circle-notch fa-spin"></i>
                            </div>
                            <img x-on:load="show_loader = false" :src="load_qr ? 'https://api.qrserver.com/v1/create-qr-code/?bgcolor={{ ltrim(config('app.settings.colors.primary'), '#') }}&color=ffffff&data={{ route('mailbox', $email) }}' : ''" alt="qr_code">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(config('app.settings.captcha') == 'recaptcha3')
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('app.settings.recaptcha3.site_key') }}"></script>
    <script>
        const handle = (e) => {
            e.preventDefault();
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ config('app.settings.recaptcha3.site_key') }}', { action: 'submit' }).then(function(token) {
                    Livewire.emit('checkReCaptcha3', token, e.target.id);
                });
            });
        }
        document.getElementById('create').addEventListener('click', handle);
        document.getElementById('random').addEventListener('click', handle);
    </script>
    @endif
</div>
