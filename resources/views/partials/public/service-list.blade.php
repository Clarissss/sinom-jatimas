<div class="space-y-5">
    @forelse($services as $service)
        <article class="flex gap-5 rounded-2xl border border-orange-100 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md sm:gap-6 sm:p-7">
            <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-full bg-orange-50 ring-2 ring-orange-200">
                @if($service->iconUrl())
                    <img src="{{ $service->iconUrl() }}" alt="{{ $service->name }}" class="h-full w-full object-cover">
                @else
                    <i class="fa-solid {{ $service->fallbackIconClass() }} text-2xl text-brand"></i>
                @endif
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900 sm:text-2xl">{{ $service->name }}</h3>
                <p class="mt-3 text-sm leading-relaxed text-gray-600 sm:text-base">{{ $service->description }}</p>
            </div>
        </article>
    @empty
        <article class="rounded-2xl border border-dashed border-gray-200 bg-gray-50 p-8 text-center text-gray-500">
            No services available yet.
        </article>
    @endforelse
</div>
