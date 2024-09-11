<div x-data="{ show: false, id: 0 }" class="w-full md:w-4/6 order-2">
    @if ($error)
        <div id="imap-error" class="flex items-center w-full h-full fixed top-0 left-0 bg-red-900 opacity-75 z-50">
            <div class="flex flex-col mx-auto">
                <div class="w-36 mx-auto text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-3xl text-center text-white my-5">{{ __('IMAP Broken') }}</div>
                <div class="p-2 mx-auto bg-red-800 text-white leading-none md:rounded-full flex md:inline-flex"
                    role="alert">
                    <span
                        class="flex rounded-full bg-red-500 uppercase px-2 py-1 text-xs font-bold mr-3">{{ __('Error') }}</span>
                    <span class="font-semibold mr-2 text-left flex-auto">{{ $error }}</span>
                </div>
            </div>
        </div>
    @endif
    <div class="bg-white text-sm rounded-lg">
        @if ($messages)
            <div class="mailbox">
                <div x-show="!show" class="list">
                    <div class="head flex items-center gap-3 bg-gray-900 text-white py-5 px-7 rounded-t-md">
                        <div class="w-1/2 md:w-3/12">{{ __('Sender') }}</div>
                        <div class="w-1/2 md:w-8/12">{{ __('Subject') }}</div>
                        <div class="hidden md:flex md:w-1/12 justify-center">{{ __('Open') }}</div>
                    </div>
                    <div class="messages flex flex-col justify-start min-h-tm-groot-messages">
                        @foreach ($messages as $i => $message)
                            @if ($i / 3 == 0 && config('app.settings.ads.four'))
                                <div class="max-w-full ads-four">{!! config('app.settings.ads.four') !!}</div>
                            @endif
                            @if(!in_array($i, $deleted))
                            <div x-on:click="show = true; id = {{ $message['id'] }}; document.querySelector('button.delete').setAttribute('wire:click', 'delete({{ $message['id'] }})')"
                                class="flex items-center gap-3 hover:bg-gray-200 border-b border-dashed py-4 px-7 cursor-pointer"
                                data-id="{{ $message['id'] }}">
                                <div class="w-1/2 md:w-3/12">
                                    {{ $message['sender_name'] }}
                                    <div class="text-xs overflow-ellipsis">{{ $message['sender_email'] }}
                                    </div>
                                </div>
                                <div class="w-1/2 md:w-8/12">{{ $message['subject'] }}</div>
                                <div class="hidden md:block w-full md:w-1/12">
                                    <div class="flex justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div x-show="show" class="message">
                    <div class="head flex items-center bg-gray-900 text-white py-5 px-7 rounded-t-md">
                        <div class="w-full flex justify-between items-center">
                            <div x-on:click="show = false" class="flex items-center cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                                <span class="ml-2">{{ __('Go Back to Inbox') }}</span>
                            </div>
                            <div class="flex gap-3">
                                <a class="download border-b" href="#" x-bind:data-id="id">{{ __('Download') }}</a>
                                <button
                                    x-on:click="id = 0; show = false; document.querySelector(`.mailbox .list [data-id='{{ $message['id'] }}']`).remove()"
                                    class="delete border-b" wire:click="delete(1)">{{ __('Delete') }}</button>
                            </div>
                        </div>
                    </div>
                    @foreach ($messages as $message)
                        <div x-show="id === {{ $message['id'] }}" id="message-{{ $message['id'] }}"
                            class="message min-h-tm-groot-messages">
                            <textarea
                                class="hidden">To: {{ $this->email }}&#13;From: "{{ $message['sender_name'] }}" <{{ $message['sender_email'] }}>&#13;Subject: {{ $message['subject'] }}&#13;Date: {{ $message['date'] }}&#13;Content-Type: text/html&#13;&#13;{{ $message['content'] }}</textarea>
                            <div class="flex justify-between items-center py-4 px-7">
                                <div>
                                    {{ $message['sender_name'] }}
                                    <div class="text-xs overflow-ellipsis">
                                        {{ $message['sender_email'] }}
                                    </div>
                                </div>
                                <div>
                                    {{ __('Date') }}
                                    <div class="text-xs overflow-ellipsis">
                                        {{ $message['date'] }}
                                    </div>
                                </div>
                            </div>
                            <div class="border-t border-b border-dashed py-4 px-7">
                                {{ $message['subject'] }}
                            </div>
                            <div class="text-wrap py-4 px-7">
                                <iframe class="w-full flex flex-grow min-h-tm-groot-iframe"
                                    srcdoc="{{ $message['content'] }}" frameborder="0"></iframe>
                                @if (count($message['attachments']) > 0)
                                    <span class="pt-5 pb-3 px-6 text-xs">{{ __('Attachments') }}</span>
                                    <div class="flex pb-5 px-6">
                                        @foreach ($message['attachments'] as $attachment)
                                            <a class="py-2 px-3 mr-3 text-sm border-2 border-black rounded-md hover:bg-black hover:text-white"
                                                href="{{ $attachment['url'] }}" download><i
                                                    class="fas fa-chevron-circle-down"></i><span
                                                    class="ml-2">{{ $attachment['file'] }}</span></a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="flex items-center min-h-tm-groot-messages">
                <div class="flex-1 flex flex-col justify-center items-center text-gray-500 h-40">
                    <div class="text-3xl mb-5"><i class="fas fa-circle-notch fa-spin"></i></div>
                    <div class="text-lg">{{ __('No Messages') }}</div>
                    <div class="mt-1">{{ __('Waiting for Incoming Messages') }}</div>
                </div>
            </div>
        @endif
    </div>
</div>
