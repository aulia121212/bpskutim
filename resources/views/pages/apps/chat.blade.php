@extends('layouts.app')

@section('title', 'Modern Chat')

@section('content')
    <div class="flex relative flex-col h-screen bg-white  transition-colors duration-300 rounded-3xl border border-gray-200 md:flex-row dark:bg-gray-950 dark:border-gray-800 overflow-hidden"
        x-data="{
            activeChat: 1,
            search: '',
            newMessage: '',
            isTyping: false,
            showEmoji: false,
        
            contacts: [
                { id: 1, name: 'Rafael Nuansa', status: 'online', bio: 'Digital Alchemist' },
                { id: 2, name: 'Zianka Azra', status: 'idle', bio: 'Designing Dreams' },
                { id: 3, name: 'Studio Support', status: 'online', bio: '24/7 Creative Aid' }
            ],
        
            messages: [
                { id: 1, contact_id: 1, text: 'Hey! Have you seen the latest 3D renders?', sender: 'other', time: '14:20' },
                { id: 2, contact_id: 1, text: 'Not yet, sending them now?', sender: 'me', time: '14:22' },
                { id: 3, contact_id: 1, text: 'Just uploaded to the cloud. Check the lighting on the neon parts! ✨', sender: 'other', time: '14:25' },
                { id: 4, contact_id: 2, text: 'The branding assets are ready for review.', sender: 'other', time: '09:15' },
            ],
        
            emojis: ['✨', '🚀', '🌈', '🎨', '⚡', '💎', '🔥', '🌙', '💜', '🍀', '🍕', '👾'],
        
            get filteredContacts() {
                return this.contacts.filter(c =>
                    c.name.toLowerCase().includes(this.search.toLowerCase())
                );
            },
        
            // Mengambil objek kontak yang sedang aktif
            getActiveContact: function() {
                var self = this;
                return this.contacts.find(function(c) { return c.id === self.activeChat; });
            },
        
            // Fungsi kirim pesan dengan simulasi balasan
            sendMessage: function() {
                if (this.newMessage.trim() === '') return;
        
                const chatID = this.activeChat;
                this.messages.push({
                    id: Date.now(),
                    contact_id: chatID,
                    text: this.newMessage,
                    sender: 'me',
                    time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
                });
        
                this.newMessage = '';
                this.showEmoji = false;
                this.scrollToBottom();
        
                // Simulasi Bot Balasan
                setTimeout(() => {
                    if (this.activeChat === chatID) {
                        this.isTyping = true;
                        this.scrollToBottom();
        
                        setTimeout(() => {
                            this.isTyping = false;
                            this.messages.push({
                                id: Date.now(),
                                contact_id: chatID,
                                text: 'Pesan diterima! Kami akan segera meninjau ini. 🚀',
                                sender: 'other',
                                time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
                            });
                            this.scrollToBottom();
                        }, 2000);
                    }
                }, 1000);
            },
        
        
            scrollToBottom: function() {
                this.$nextTick(function() {
                    var el = document.getElementById('chatContainer');
                    if (el) el.scrollTo({ top: el.scrollHeight, behavior: 'smooth' });
                });
            }
        }" x-init="scrollToBottom()">

        {{-- SIDEBAR --}}
        <div
            class="flex flex-col shrink-0 w-full border-r border-gray-200 transition-colors duration-300 md:w-80 bg-gray-50/50 backdrop-blur-xl dark:border-gray-800 dark:bg-gray-900/50">
            <div class="p-8 pb-4">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-indigo-600 shadow-lg rounded-2xl shadow-indigo-500/20">
                            <i class="text-xl text-white ti ti-message-2-filled"></i>
                        </div>
                        <h1 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">Chat</h1>
                    </div>
                    <button class="text-gray-400 hover:text-indigo-600 transition-colors"><i
                            class="ti ti-edit text-lg"></i></button>
                </div>

                <div class="relative">
                    <i class="absolute top-1/2 left-4 text-xs -translate-y-1/2 ti ti-search text-gray-400"></i>
                    <input type="text" x-model="search" placeholder="Search contacts..."
                        class="py-3 pr-4 pl-10 w-full text-xs transition-all border outline-none rounded-xl bg-white border-gray-200 text-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500/20">
                </div>
            </div>

            <div class="flex-1 px-4 py-4 space-y-1 overflow-y-auto custom-scrollbar">
                <template x-for="item in filteredContacts" :key="item.id">
                    <div @click="activeChat = item.id; scrollToBottom()"
                        class="flex relative items-center gap-4 p-3 transition-all cursor-pointer rounded-2xl border border-transparent"
                        :class="activeChat === item.id ?
                            'bg-gray-100  border-gray-200 dark:bg-gray-800 dark:border-gray-700' :
                            'hover:bg-gray-100 dark:hover:bg-white/5'">

                        <div class="relative shrink-0">
                            <x-avatar ::name="item.name" size="xs" shape="xl" />
                            <div class="absolute right-0 bottom-0 w-3 h-3 rounded-full border-2 border-white dark:border-gray-800"
                                :class="item.status === 'online' ? 'bg-emerald-500' : 'bg-amber-500'"></div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <span class="block text-sm font-semibold text-gray-900 dark:text-white"
                                x-text="item.name"></span>
                            <span class="block text-xs truncate text-gray-500 dark:text-gray-400" x-text="item.bio"></span>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- CHAT CANVAS --}}
        <div class="flex flex-col flex-1 min-w-0 bg-white transition-colors duration-300 dark:bg-gray-950">
            <div
                class="flex shrink-0 justify-between items-center px-6 h-20 bg-white/80 backdrop-blur-md border-b border-gray-200 transition-colors duration-300 md:px-10 dark:bg-gray-950/80 dark:border-gray-800">

                <div class="flex items-center gap-4" x-show="getActiveContact()">
                    <div class="relative">
                        <x-avatar ::name="getActiveContact().name" shape="full"
                            />
                        <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 rounded-full border-2 border-white dark:border-gray-950"
                            :class="getActiveContact().status === 'online' ? 'bg-emerald-500' : 'bg-amber-500'">
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <h2 class="text-sm font-bold tracking-tight text-gray-900 md:text-base dark:text-white"
                            x-text="getActiveContact().name"></h2>
                        <div class="flex items-center gap-1.5">
                            <span class="text-[10px] font-bold uppercase tracking-widest transition-colors"
                                :class="getActiveContact().status === 'online' ? 'text-emerald-500' : 'text-amber-500'"
                                x-text="getActiveContact().status">
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-1 md:gap-3">
                    {{-- Tombol Call --}}
                    <button @click="alert('Calling ' + getActiveContact().name + '...')"
                        class="group flex items-center justify-center w-10 h-10 transition-all rounded-xl hover:bg-indigo-50 dark:hover:bg-indigo-500/10">
                        <i class="text-xl ti ti-phone text-gray-400 group-hover:text-indigo-600 transition-colors"></i>
                    </button>

                    {{-- Tombol Video (Tambahan agar lebih lengkap) --}}
                    <button
                        class="group flex items-center justify-center w-10 h-10 transition-all rounded-xl hover:bg-indigo-50 dark:hover:bg-indigo-500/10">
                        <i class="text-xl ti ti-video text-gray-400 group-hover:text-indigo-600 transition-colors"></i>
                    </button>

                    {{-- Garis Pemisah Tipis --}}
                    <div class="w-px h-6 mx-1 bg-gray-200 dark:bg-gray-800"></div>

                    {{-- Tombol Menu --}}
                    <button
                        class="group flex items-center justify-center w-10 h-10 transition-all rounded-xl hover:bg-gray-100 dark:hover:bg-white/5">
                        <i
                            class="text-xl ti ti-dots-vertical text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition-colors"></i>
                    </button>
                </div>
            </div>

            {{-- Messages --}}
            <div id="chatContainer"
                class="flex-1 px-6 py-10 space-y-6 overflow-y-auto scroll-smooth custom-scrollbar md:px-12">
                <template x-for="msg in messages.filter(m => m.contact_id === activeChat)" :key="msg.id">
                    <div class="flex items-start gap-3 group" :class="msg.sender === 'me' ? 'flex-row-reverse' : ''">

                        <div class="flex flex-col max-w-[75%]"
                            :class="msg.sender === 'me' ? 'items-end' : 'items-start'">
                            <div class="flex items-center gap-2 mb-1">
                                <template x-if="msg.sender !== 'me'">
                                    <span class="text-xs font-bold text-gray-900 dark:text-white"
                                        x-text="getActiveContact().name"></span>
                                </template>
                                <span class="text-[10px] text-gray-400 font-medium" x-text="msg.time"></span>
                                <template x-if="msg.sender === 'me'">
                                    <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400">You</span>
                                </template>
                            </div>

                            <div class="relative p-4 rounded-2xl text-sm leading-relaxed"
                                :class="msg.sender === 'me' ?
                                    'bg-indigo-600 text-white rounded-tr-none shadow-md shadow-indigo-500/20' :
                                    'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 rounded-tl-none'">
                                <p x-text="msg.text"></p>

                            </div>
                        </div>
                    </div>
                </template>

                <div x-show="isTyping" class="flex items-center px-1 gap-2 text-gray-400">
                    <div class="flex gap-1.5 p-3 bg-gray-100 dark:bg-gray-800 rounded-2xl rounded-tl-none">
                        <div class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-bounce"></div>
                        <div class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-bounce delay-75"></div>
                        <div class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-bounce delay-150"></div>
                    </div>
                </div>
            </div>

            {{-- Input Area --}}
            <div class="px-6 pb-10 pt-2 shrink-0">
                <div class="mx-auto max-w-5xl relative">
                    {{-- Emoji Picker --}}
                    <div x-show="showEmoji" @click.away="showEmoji = false"
                        class="flex absolute bottom-full left-0 z-30 gap-3 p-5 mb-4 bg-white border border-gray-200  rounded-2xl dark:bg-gray-900 dark:border-gray-700"
                        x-cloak x-transition>
                        <template x-for="e in emojis" :key="e">
                            <button @click="newMessage += e" class="text-2xl transition-transform hover:scale-125"
                                x-text="e"></button>
                        </template>
                    </div>

                    <div
                        class="flex items-center gap-4 p-2.5 transition-all border bg-gray-50 border-gray-200 rounded-2xl dark:bg-gray-900 dark:border-gray-700 focus-within:ring-2 focus-within:ring-indigo-500/20 focus-within:border-indigo-500">
                        <button @click="showEmoji = !showEmoji"
                            class="flex items-center justify-center w-11 h-11 transition-all rounded-xl text-gray-400 hover:text-amber-500">
                            <i class="text-2xl ti ti-mood-smile"></i>
                        </button>

                        <input type="text" x-model="newMessage" @keydown.enter.prevent="sendMessage()"
                            placeholder="Type your message..."
                            class="flex-1 py-2 px-2 text-sm bg-transparent border-none outline-none text-gray-900 dark:text-white placeholder-gray-400">

                        <div class="flex items-center gap-2 pr-1">
                            <button type="button" class="text-gray-400 hover:text-indigo-600 transition-all p-2">
                                <i class="ti ti-paperclip text-xl"></i>
                            </button>
                            <button @click="sendMessage()" :disabled="!newMessage.trim()"
                                class="flex items-center justify-center gap-2 px-6 h-11 font-bold text-white bg-indigo-600 transition-all shadow-md rounded-xl shadow-indigo-600/20 disabled:opacity-30 active:scale-95">
                                <span class="hidden text-xs sm:inline"></span>
                                <i class="ti ti-send"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(75, 85, 99, 0.15);
            border-radius: 10px;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.08);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection