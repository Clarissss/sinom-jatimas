<footer id="contact" class="bg-gray-900 py-12 text-white lg:py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-8 md:grid-cols-2 lg:gap-12">
            <div>
                <h3 class="text-xl font-bold">{{ $companyProfile?->company_name ?? 'PT. SINOM JATI MAS' }}</h3>
                <p class="mt-3 leading-relaxed text-gray-400">{{ \Illuminate\Support\Str::limit($companyProfile?->about_us ?? 'General Contractor & General Trading.', 120) }}</p>
            </div>
            <div>
                <h4 class="mb-4 text-lg font-semibold">Contact</h4>
                <ul class="space-y-3 text-gray-400">
                    <li class="flex items-start">
                        <i class="fa-solid fa-location-dot mr-3 mt-0.5 text-brand-light"></i>
                        <span>{{ $companyProfile?->address ?? 'Link. Sukarela RT/RW 006/001, Kel. Mekarsari Kec. Pulomerak' }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fa-regular fa-envelope mr-3 text-brand-light"></i>
                        <a href="mailto:{{ $companyProfile?->email ?? 'sinomjatimas@gmail.com' }}" class="hover:text-white">{{ $companyProfile?->email ?? 'sinomjatimas@gmail.com' }}</a>
                    </li>
                    <li class="flex items-center">
                        <i class="fa-brands fa-whatsapp mr-3 text-brand-light"></i>
                        <a href="https://wa.me/{{ preg_replace('/\D+/', '', $companyProfile?->phone ?? '087771300570') }}" target="_blank" rel="noopener noreferrer" class="hover:text-white">{{ $companyProfile?->phone ?? '0877-7130-0570' }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="mt-10 border-t border-gray-800 pt-8 text-center">
            <p class="text-gray-500">&copy; {{ date('Y') }} PT. Sinom Jati Mas. All rights reserved.</p>
        </div>
    </div>
</footer>
