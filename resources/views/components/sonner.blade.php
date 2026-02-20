<div x-data="{ 
    message: '', 
    show: false,
    addToast(msg) { this.message = msg; this.show = true; setTimeout(() => this.show = false, 3000) }
}" @notify.window="addToast($event.detail)" x-show="show" x-cloak
class="fixed bottom-4 right-4 z-[100] bg-gray-900 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3">
    <i class="fas fa-bell text-green-400"></i>
    <span class="text-sm font-bold" x-text="message"></span>
</div>