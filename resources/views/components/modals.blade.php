{{-- Reusable Confirmation Modal --}}
<div x-data="confirmModal()"
     x-show="open"
     x-cloak
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[60] flex items-center justify-center"
     role="dialog"
     aria-modal="true"
     id="confirm-modal">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="open = false"></div>
    <div class="relative bg-white rounded-[2rem] shadow-2xl w-full max-w-md mx-4 overflow-hidden animate-fade-in"
         @click.away="open = false">
        <div class="p-8 text-center">
            <div class="w-16 h-16 mx-auto rounded-full bg-red-50 text-red-500 flex items-center justify-center text-2xl mb-5">
                <i class="fa-solid" :class="icon"></i>
            </div>
            <h3 class="text-lg font-black text-gray-900 mb-2" x-text="title"></h3>
            <p class="text-sm text-gray-500 mb-8" x-text="message"></p>
            <div class="flex space-x-3">
                <button type="button" @click="open = false"
                        class="flex-1 px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <form :action="action" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="_method" :value="method">
                    <button type="submit"
                            class="w-full px-5 py-2.5 text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-colors"
                            :class="buttonClass">
                        <span x-text="buttonText"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Reusable Alert Modal --}}
<div x-data="alertModal()"
     x-show="open"
     x-cloak
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[60] flex items-center justify-center"
     role="dialog"
     aria-modal="true"
     id="alert-modal">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="close()"></div>
    <div class="relative bg-white rounded-[2rem] shadow-2xl w-full max-w-md mx-4 overflow-hidden animate-fade-in"
         @click.away="close()">
        <div class="p-8 text-center">
            <div class="w-16 h-16 mx-auto rounded-full flex items-center justify-center text-2xl mb-5"
                 :class="bgColor"
                 :class="iconColor">
                <i class="fa-solid" :class="icon"></i>
            </div>
            <h3 class="text-lg font-black text-gray-900 mb-2" x-text="title"></h3>
            <p class="text-sm text-gray-500 mb-8 whitespace-pre-line" x-text="message"></p>
            <button type="button" @click="close()"
                    class="w-full px-5 py-2.5 bg-gray-900 text-white rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-black transition-colors">
                <span x-text="buttonText"></span>
            </button>
        </div>
    </div>
</div>

<script>
function confirmModal() {
    return {
        open: false,
        title: '',
        message: '',
        action: '',
        method: 'POST',
        buttonText: 'Konfirmasi',
        buttonClass: 'bg-[#DD3517] hover:bg-[#FF812E]',
        icon: 'fa-circle-exclamation',
        init() {
            window.addEventListener('open-confirm', e => this.configure(e.detail));
        },
        configure(config) {
            this.title = config.title || 'Konfirmasi';
            this.message = config.message || 'Apakah Anda yakin ingin melanjutkan aksi ini?';
            this.action = config.action || '';
            this.method = config.method || 'POST';
            this.buttonText = config.buttonText || 'Konfirmasi';
            this.buttonClass = config.buttonClass || 'bg-[#DD3517] hover:bg-[#FF812E]';
            this.icon = config.icon || 'fa-circle-exclamation';
            this.open = true;
        }
    }
}

function alertModal() {
    return {
        open: false,
        title: '',
        message: '',
        icon: 'fa-circle-info',
        iconColor: 'text-blue-500',
        bgColor: 'bg-blue-50',
        buttonText: 'OK',
        callback: null,
        init() {
            window.addEventListener('open-alert', e => this.configure(e.detail));
        },
        configure(config) {
            this.title = config.title || 'Informasi';
            this.message = config.message || '';
            this.icon = config.icon || 'fa-circle-info';
            this.iconColor = config.iconColor || 'text-blue-500';
            this.bgColor = config.bgColor || 'bg-blue-50';
            this.buttonText = config.buttonText || 'OK';
            this.callback = config.callback || null;
            this.open = true;
        },
        close() {
            this.open = false;
            if (typeof this.callback === 'function') {
                this.callback();
            }
        }
    }
}

function openConfirmModal(config) {
    window.dispatchEvent(new CustomEvent('open-confirm', { detail: config }));
}

function openAlertModal(config) {
    window.dispatchEvent(new CustomEvent('open-alert', { detail: config }));
}
</script>
