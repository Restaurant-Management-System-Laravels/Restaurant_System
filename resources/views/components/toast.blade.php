<div 
    x-data="{ show: false, message: '', type: '' }"
    x-show="show"
    x-transition
    x-bind:class="type === 'success' ? 'bg-green-500' : 'bg-red-500'"
    class="fixed bottom-5 right-5 text-white px-4 py-2 rounded-lg shadow-lg z-50"
    x-text="message"
    style="display: none;"
    x-init="
        window.addEventListener('toast', event => {
            message = event.detail.message;
            type = event.detail.type;
            show = true;
            setTimeout(() => show = false, 3000);
        });
    "
>
</div>
