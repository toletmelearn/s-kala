<footer id="contact" class="border-t border-rose-100 bg-stone-950 text-white">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-[1.2fr_0.8fr_0.8fr] lg:px-8">
        <div>
            <p class="text-xl font-bold">{{ $settings?->site_name ?? 'S-kala – Shakuntala Shishu Lok' }}</p>
            <p class="mt-3 max-w-xl text-sm leading-6 text-stone-300">{{ $settings?->tagline ?? 'Skill, Strength & Self-Reliance' }}</p>
            <p class="mt-6 max-w-xl text-sm leading-6 text-stone-400">
                S-kala – Shakuntala Shishu Lok | Skill, Strength &amp; Self-Reliance
            </p>
        </div>

        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-200">Contact</p>
            <div class="mt-4 space-y-3 text-sm text-stone-300">
                @if ($settings?->address)
                    <p>{{ $settings->address }}</p>
                @endif
                @if ($settings?->phone)
                    <p>{{ $settings->phone }}</p>
                @endif
                @if ($settings?->email)
                    <p>{{ $settings->email }}</p>
                @endif
                @unless ($settings?->address || $settings?->phone || $settings?->email)
                    <p>Dhampur, Uttar Pradesh</p>
                @endunless
                <a href="{{ route('contact.create') }}" class="inline-flex rounded-full border border-white/10 px-4 py-2 text-xs font-semibold text-stone-200 hover:bg-white/10">
                    Contact Form
                </a>
            </div>
        </div>

        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-200">Connect</p>
            <div class="mt-4 flex flex-wrap gap-3">
                <a href="{{ route('home') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold text-stone-200 hover:bg-white/10">Home</a>
                <a href="{{ route('training.index') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold text-stone-200 hover:bg-white/10">Training</a>
                <a href="{{ route('products.index') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold text-stone-200 hover:bg-white/10">Products</a>
                <a href="{{ route('gallery.index') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold text-stone-200 hover:bg-white/10">Gallery</a>
                <a href="{{ route('impact.index') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold text-stone-200 hover:bg-white/10">Impact</a>
                <a href="{{ route('contact.create') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold text-stone-200 hover:bg-white/10">Contact</a>
                <a href="{{ route('join.create') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold text-stone-200 hover:bg-white/10">Join S-kala</a>
                <a href="{{ route('certificates.verify', 'SKALA-VERIFY-XXXXXXXX') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold text-stone-200 hover:bg-white/10">Certificate Verification</a>
                @if ($settings?->facebook_url)
                    <a href="{{ $settings->facebook_url }}" class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold text-stone-200 hover:bg-white/10">Facebook</a>
                @endif
                @if ($settings?->instagram_url)
                    <a href="{{ $settings->instagram_url }}" class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold text-stone-200 hover:bg-white/10">Instagram</a>
                @endif
                @if ($settings?->youtube_url)
                    <a href="{{ $settings->youtube_url }}" class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold text-stone-200 hover:bg-white/10">YouTube</a>
                @endif
                @unless ($settings?->facebook_url || $settings?->instagram_url || $settings?->youtube_url)
                    <p class="text-sm leading-6 text-stone-400">Social links will appear here after they are added from Website CMS.</p>
                @endunless
            </div>
        </div>
    </div>
</footer>
