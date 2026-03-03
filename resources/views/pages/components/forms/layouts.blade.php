@extends('layouts.app')

@section('title', 'Form Layouts')

@section('content')
<div class="space-y-10 pb-20">
    <div class="flex flex-col gap-2">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Form Layouts</h1>
        <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">Inspirasi struktur formulir untuk berbagai keperluan aplikasi.</p>
    </div>

    <div class="max-w-3xl mx-auto space-y-8">
        <section class="bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-200 dark:border-gray-800 overflow-hidden shadow-sm">
            <div class="p-8 border-b border-gray-100 dark:border-gray-800">
                <h3 class="text-xl font-bold dark:text-white">Account Settings</h3>
                <p class="text-sm text-gray-400 font-medium">Update your personal information and security.</p>
            </div>
            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-400 uppercase ml-1">First Name</label>
                        <input type="text" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-2xl px-5 py-3 text-sm font-bold dark:text-white outline-none focus:ring-2 focus:ring-indigo-500" value="Aulia">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-400 uppercase ml-1">Last Name</label>
                        <input type="text" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-2xl px-5 py-3 text-sm font-bold dark:text-white outline-none focus:ring-2 focus:ring-indigo-500" value="Azizah">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-400 uppercase ml-1">Email Address</label>
                    <input type="email" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-2xl px-5 py-3 text-sm font-bold dark:text-white outline-none focus:ring-2 focus:ring-indigo-500" value="aulia.azizah@bpskutim.go.id">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-400 uppercase ml-1">Bio</label>
                    <textarea rows="4" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-3xl px-5 py-4 text-sm font-bold dark:text-white outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Write something about yourself..."></textarea>
                </div>
            </div>
            <div class="p-8 bg-gray-50 dark:bg-gray-800/50 flex justify-end gap-3">
                <button class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 transition-colors">Discard</button>
                <button class="px-8 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-indigo-500/20 active:scale-95 transition-all">Save Changes</button>
            </div>
        </section>

        <section class="bg-indigo-600 rounded-3xl p-8 flex flex-col md:flex-row items-center justify-between gap-6 overflow-hidden relative">
            <i class="ti ti-mail-opened text-9xl absolute -bottom-8 -right-8 text-white opacity-10 -rotate-12"></i>
            <div class="relative z-10">
                <h4 class="text-white text-xl font-bold">Join Newsletter</h4>
                <p class="text-indigo-100 text-sm font-medium">Get the latest UI tips every week.</p>
            </div>
            <div class="flex w-full md:w-auto gap-2 relative z-10">
                <input type="text" class="bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white placeholder-white/50 outline-none focus:bg-white/20 transition-all text-sm" placeholder="Your email...">
                <button class="bg-white text-indigo-600 px-6 py-2 rounded-xl font-bold text-sm hover:bg-indigo-50 transition-all">Join</button>
            </div>
        </section>
    </div>
</div>
@endsection