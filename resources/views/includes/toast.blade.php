@php
    if (session('success')) {
        $bgColor = 'bg-green-300';
        $message = session('success');
    } elseif (session('danger')) {
        $bgColor = 'bg-red-100';
        $message = session('danger');
    } elseif (session('warning')) {
        $bgColor = 'bg-orange-100';
        $message = session('warning');
    } else {
        $bgColor = 'bg-gray-100';
        $message = '';
    }
@endphp
@if (session('success'))
    <div id="toast" class="hidden fixed left-1/2 -translate-x-1/2 top-20">
        <div class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 {{ $bgColor }} rounded-lg shadow"
            role="alert">
            <div class="text-sm font-normal">{{ $message }}</div>
        </div>
    </div>
    <script>
        const toast = document.getElementById('toast');
        toast.classList.remove('hidden');
        setTimeout(() => {
            toast.classList.add('hidden')
        }, 3000);
    </script>
@endif
