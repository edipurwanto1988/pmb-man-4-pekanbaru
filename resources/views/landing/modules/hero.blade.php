@php
    $heroImage = $data->image ?? '';
    $hasImage = $heroImage && file_exists(public_path($heroImage));
    $bgStyle = $hasImage
        ? "background-image: url('" . asset($heroImage) . "'); background-size: cover; background-position: center; background-repeat: no-repeat;"
        : "background: linear-gradient(135deg, #065f46 0%, #047857 30%, #059669 60%, #10b981 100%);";
@endphp
<section style="{{ $bgStyle }} position: relative;">
    @if($hasImage)
    <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.55);"></div>
    @endif
    <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56" style="position: relative; z-index: 1;">
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl lg:text-6xl" style="color: #ffffff;">{{ $data->title ?? 'Judul' }}</h1>
        <p class="mb-8 text-lg font-normal lg:text-xl sm:px-16 lg:px-48" style="color: #d1fae5;">{{ $data->subtitle ?? 'Subjudul' }}</p>
        <div style="display: flex; justify-content: center; margin-top: 1.5rem;">
            <a href="{{ $data->cta_link ?? '#' }}" style="display: inline-flex; align-items: center; justify-content: center; padding: 14px 32px; font-size: 16px; font-weight: 600; color: #ffffff; background-color: #166534; border-radius: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(0,0,0,0.3); transition: background-color 0.3s ease; white-space: nowrap;" onmouseover="this.style.backgroundColor='#15803d'" onmouseout="this.style.backgroundColor='#166534'">
                {{ $data->cta_text ?? 'Aksi' }}
                <svg style="width: 14px; height: 10px; margin-left: 8px;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </a>
        </div>
    </div>
</section>
