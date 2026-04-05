<!DOCTYPE html>
<html lang="mr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} — {{ $navbar->name ?? 'ग्रामपंचायत' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@300;400;500;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary:      {{ $navbar->color ?? '#006699' }};
            --primary-dark: color-mix(in srgb, var(--primary) 75%, #000);
            --bg:     #f0f4f8;
            --card:   #fff;
            --text:   #1a1a2e;
            --muted:  #6c757d;
            --border: #e2e8f0;
            --radius: .75rem;
            --shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        *, *::before, *::after { box-sizing: border-box; }
        body {
            background: var(--bg);
            color: var(--text);
            font-family: "Noto Sans Devanagari", "Poppins", sans-serif;
            font-size: 0.9375rem;
            margin: 0;
            min-height: 100vh;
        }

        /* ── Top bar ── */
        .gallery-topbar {
            background: linear-gradient(90deg, var(--primary-dark), var(--primary));
            color: #fff;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
            position: sticky;
            top: 0;
            z-index: 200;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .gallery-topbar .gp-name    { font-size: 1rem;   font-weight: 700; }
        .gallery-topbar .gal-title  { font-size: 0.82rem; opacity: .85; }
        .btn-close-tab {
            background: rgba(255,255,255,0.2);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.35);
            border-radius: 6px;
            padding: 4px 14px;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            transition: background .2s;
            cursor: pointer;
        }
        .btn-close-tab:hover { background: rgba(255,255,255,0.35); color: #fff; }

        /* ── Container ── */
        .gallery-container {
            max-width: 1200px;
            margin: 28px auto;
            padding: 0 16px 48px;
        }

        /* ── Section heading ── */
        .gallery-heading {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary);
            border-left: 4px solid var(--primary);
            padding-left: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .gallery-heading .count-badge {
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--muted);
            background: #e9ecef;
            padding: 2px 10px;
            border-radius: 20px;
        }

        /* ── Photo card ── */
        .gal-photo-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            cursor: pointer;
            transition: transform .25s, box-shadow .25s;
        }
        .gal-photo-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 28px rgba(0,0,0,0.15);
        }
        .gal-photo-card img {
            width: 100%;
            height: 165px;
            object-fit: cover;
            display: block;
            transition: transform .3s;
        }
        .gal-photo-card:hover img { transform: scale(1.05); }
        .gal-photo-card .gal-name {
            padding: 6px 10px;
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: center;
            border-top: 1px solid var(--border);
        }

        /* ── Video card ── */
        .gal-video-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            cursor: pointer;
            transition: transform .25s, box-shadow .25s;
            position: relative;
        }
        .gal-video-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 28px rgba(0,0,0,0.15);
        }
        .gal-video-thumb {
            width: 100%;
            height: 190px;
            object-fit: cover;
            display: block;
            background: #111;
        }
        /* play overlay */
        .gal-video-card .play-overlay {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 190px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.28);
            transition: background .2s;
        }
        .gal-video-card:hover .play-overlay { background: rgba(0,0,0,0.45); }
        .play-overlay .play-btn {
            width: 52px; height: 52px;
            background: rgba(255,255,255,0.92);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: var(--primary);
            box-shadow: 0 4px 14px rgba(0,0,0,0.3);
            transition: transform .2s;
        }
        .gal-video-card:hover .play-btn { transform: scale(1.12); }
        .gal-video-card .gal-name {
            padding: 8px 12px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            border-top: 1px solid var(--border);
        }

        /* ── Lightbox (photos) ── */
        #lightbox {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.92);
            z-index: 9999;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 56px 60px 20px;
        }
        #lightbox.active { display: flex; }
        #lightbox .lb-img-wrap {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 0;
        }
        #lightbox img {
            max-width: 100%;
            max-height: 75vh;
            border-radius: 8px;
            box-shadow: 0 8px 40px rgba(0,0,0,0.7);
            object-fit: contain;
            display: block;
        }
        .lb-footer {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-top: 14px;
            flex-wrap: wrap;
        }
        .lb-caption {
            color: rgba(255,255,255,0.9);
            font-size: 0.92rem;
            font-weight: 500;
            text-align: center;
            flex: 1;
        }
        .lb-counter {
            color: rgba(255,255,255,0.55);
            font-size: 0.8rem;
            white-space: nowrap;
        }
        .lb-close {
            position: fixed;
            top: 12px; right: 16px;
            background: rgba(255,255,255,0.15);
            border: none;
            color: #fff;
            font-size: 1.5rem;
            width: 38px; height: 38px;
            border-radius: 50%;
            cursor: pointer;
            line-height: 1;
            transition: background .2s;
            z-index: 10000;
        }
        .lb-close:hover { background: rgba(255,255,255,0.3); }
        .lb-nav {
            position: fixed;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.15);
            border: none;
            color: #fff;
            font-size: 1.3rem;
            width: 44px; height: 44px;
            border-radius: 50%;
            cursor: pointer;
            transition: background .2s;
            z-index: 10000;
        }
        .lb-nav:hover { background: rgba(255,255,255,0.3); }
        .lb-prev { left: 10px; }
        .lb-next { right: 10px; }

        /* ── Video modal ── */
        .video-modal-title {
            font-weight: 700;
            font-size: 1rem;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        #videoModalPlayer {
            width: 100%;
            max-height: 65vh;
            background: #000;
            border-radius: 6px;
            display: block;
        }

        /* ── Empty state ── */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--muted);
        }
        .empty-state i { font-size: 3rem; opacity: .3; display: block; margin-bottom: 12px; }

        /* ── Footer ── */
        .gallery-footer {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            color: rgba(255,255,255,0.8);
            text-align: center;
            padding: 14px;
            font-size: 0.8rem;
        }

        @media (max-width: 576px) {
            .gal-photo-card img { height: 130px; }
            .gal-video-thumb, .gal-video-card .play-overlay { height: 155px; }
            .gallery-heading { font-size: 1.05rem; }
            #lightbox { padding: 50px 50px 16px; }
        }
    </style>
</head>
<body>

{{-- Top bar --}}
<div class="gallery-topbar">
    <div>
        <div class="gp-name">{{ $navbar->name ?? 'ग्रामपंचायत' }}</div>
        <div class="gal-title">{{ $title }} / {{ $title_en }}</div>
    </div>
    <button class="btn-close-tab" onclick="window.close()">
        <i class="fa fa-times me-1"></i> बंद करा
    </button>
</div>

{{-- Main --}}
<div class="gallery-container">

    <div class="gallery-heading">
        {{ $title }}
        <span class="count-badge">{{ $items->count() }} {{ $type === 'photos' ? 'छायाचित्रे' : 'व्हिडिओ' }}</span>
    </div>

    @if($items->isEmpty())
        <div class="empty-state">
            <i class="fa {{ $type === 'photos' ? 'fa-images' : 'fa-film' }}"></i>
            <p>कोणतेही {{ $type === 'photos' ? 'छायाचित्र' : 'व्हिडिओ' }} उपलब्ध नाही.</p>
        </div>

    @elseif($type === 'photos')
        {{-- Photo grid --}}
        <div class="row g-3">
            @foreach($items as $i => $item)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="gal-photo-card" onclick="openLightbox({{ $i }})"
                         title="{{ $item->name ?? 'शीर्षक नाही' }}">
                        <img src="{{ asset('storage/' . $item->attachment) }}"
                             alt="{{ $item->name ?? '' }}"
                             loading="lazy">
                        <div class="gal-name" title="{{ $item->name ?? 'शीर्षक नाही' }}">
                            {{ $item->name ?? 'शीर्षक नाही' }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Lightbox --}}
        <div id="lightbox">
            <button class="lb-close" onclick="closeLightbox()">&times;</button>
            <button class="lb-nav lb-prev" onclick="lbNav(-1)"><i class="fa fa-chevron-left"></i></button>
            <div class="lb-img-wrap">
                <img id="lbImg" src="" alt="">
            </div>
            <div class="lb-footer">
                <div class="lb-caption" id="lbCaption"></div>
                <div class="lb-counter" id="lbCounter"></div>
            </div>
            <button class="lb-nav lb-next" onclick="lbNav(1)"><i class="fa fa-chevron-right"></i></button>
        </div>

    @else
        {{-- Video grid --}}
        <div class="row g-4">
            @foreach($items as $i => $item)
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="gal-video-card"
                         onclick="openVideoModal('{{ asset('storage/' . $item->attachment) }}', '{{ addslashes($item->name ?? 'शीर्षक उपलब्ध नाही') }}')"
                         title="{{ $item->name ?? 'शीर्षक उपलब्ध नाही' }}">
                        {{-- Thumbnail via video poster trick --}}
                        <video class="gal-video-thumb" preload="metadata" muted
                               style="pointer-events:none;">
                            <source src="{{ asset('storage/' . $item->attachment) }}#t=0.5" type="video/mp4">
                        </video>
                        <div class="play-overlay">
                            <div class="play-btn"><i class="fa fa-play ms-1"></i></div>
                        </div>
                        <div class="gal-name" title="{{ $item->name ?? 'शीर्षक उपलब्ध नाही' }}">
                            {{ $item->name ?? 'शीर्षक उपलब्ध नाही' }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Video Modal --}}
        <div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header py-2 px-3">
                        <h6 class="video-modal-title mb-0" id="videoModalTitle">व्हिडिओ</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0 bg-black">
                        <video id="videoModalPlayer" controls autoplay>
                            <source id="videoModalSource" src="" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <div class="modal-footer py-2 px-3 justify-content-start">
                        <small class="text-muted" id="videoModalCaption"></small>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>

{{-- Footer --}}
<div class="gallery-footer">
    © {{ $navbar->name ?? 'ग्रामपंचायत' }} &nbsp;•&nbsp; {{ date('Y') }} &nbsp;•&nbsp; महाराष्ट्र शासन
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@if($type === 'photos')
<script>
    const photos  = @json($items->map(fn($i) => ['src' => asset('storage/'.$i->attachment), 'name' => $i->name ?? '']));
    let current   = 0;

    function openLightbox(index) {
        current = index;
        renderLightbox();
        document.getElementById('lightbox').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('active');
        document.body.style.overflow = '';
    }
    function renderLightbox() {
        document.getElementById('lbImg').src                = photos[current].src;
        document.getElementById('lbCaption').textContent    = photos[current].name;
        document.getElementById('lbCounter').textContent    = (current + 1) + ' / ' + photos.length;
    }
    function lbNav(dir) {
        current = (current + dir + photos.length) % photos.length;
        renderLightbox();
    }
    document.getElementById('lightbox').addEventListener('click', function(e) {
        if (e.target === this) closeLightbox();
    });
    document.addEventListener('keydown', function(e) {
        if (!document.getElementById('lightbox').classList.contains('active')) return;
        if (e.key === 'Escape')     closeLightbox();
        if (e.key === 'ArrowLeft')  lbNav(-1);
        if (e.key === 'ArrowRight') lbNav(1);
    });
</script>
@else
<script>
    function openVideoModal(src, name) {
        document.getElementById('videoModalSource').src  = src;
        document.getElementById('videoModalTitle').textContent   = name;
        document.getElementById('videoModalCaption').textContent = name;

        const player = document.getElementById('videoModalPlayer');
        player.load();

        const modal = new bootstrap.Modal(document.getElementById('videoModal'));
        modal.show();
    }

    // Pause & reset video when modal is closed
    document.getElementById('videoModal').addEventListener('hide.bs.modal', function () {
        const player = document.getElementById('videoModalPlayer');
        player.pause();
        player.currentTime = 0;
    });
</script>
@endif

</body>
</html>
