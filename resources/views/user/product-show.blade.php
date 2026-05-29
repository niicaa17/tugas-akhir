@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap');

    :root {
        --cream:      #f7f1e3;
        --cream-mid:  #ede3cc;
        --cream-deep: #ddd0b3;
        --parchment:  #faf6ec;
        --forest:     #2c4a2e;
        --forest-mid: #3d6340;
        --forest-lt:  #5a8a5e;
        --sage:       #7da87f;
        --sage-lt:    #a8c8aa;
        --moss:       #bfd4b2;
        --gold:       #c49a3c;
        --gold-lt:    #dbb96a;
        --gold-pale:  #f0dda8;
        --text-dark:  #1e3020;
        --text-mid:   #3d5c3f;
        --text-soft:  #5e7d60;
        --text-muted: #8aaa8c;
        --line:       rgba(44, 74, 46, 0.12);
        --line-mid:   rgba(44, 74, 46, 0.22);
    }

    .pdp-body .navbar,
    .pdp-body main.py-4 { padding: 0 !important; }

    .pdp-body { background: var(--cream); }

    * { box-sizing: border-box; }

    .pdp-root {
        min-height: 100vh;
        background: var(--cream);
        color: var(--text-dark);
        font-family: 'DM Sans', sans-serif;
        position: relative;
    }

    /* ── Decorative background ── */
    .pdp-bg {
        position: fixed;
        inset: 0;
        pointer-events: none;
        z-index: 0;
        overflow: hidden;
    }
    .pdp-bg::before {
        content: '';
        position: absolute;
        top: -200px; right: -200px;
        width: 700px; height: 700px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(196,154,60,0.10) 0%, transparent 70%);
    }
    .pdp-bg::after {
        content: '';
        position: absolute;
        bottom: -150px; left: -150px;
        width: 600px; height: 600px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(93,138,94,0.13) 0%, transparent 70%);
    }
    .pdp-bg-leaf {
        position: absolute;
        top: 60px; right: 40px;
        width: 340px; height: 340px;
        opacity: 0.055;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Cpath d='M100 10 C130 10 180 40 190 100 C200 160 160 190 100 190 C40 190 10 150 10 100 C10 50 70 10 100 10 Z' fill='%232c4a2e'/%3E%3Cpath d='M100 10 L100 190 M100 10 C70 60 60 130 100 190' stroke='%23f7f1e3' stroke-width='3' fill='none'/%3E%3C/svg%3E") center/contain no-repeat;
    }

    /* ── Topbar ── */
    .pdp-topbar {
        position: sticky;
        top: 0;
        z-index: 30;
        background: rgba(247, 241, 227, 0.88);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border-bottom: 1px solid var(--line-mid);
    }
    .pdp-topbar-inner {
        max-width: 1180px;
        margin: 0 auto;
        padding: 14px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .pdp-back {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: var(--forest);
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        transition: color 0.2s, gap 0.2s;
    }
    .pdp-back:hover { color: var(--gold); gap: 14px; }
    .pdp-back-arrow {
        width: 28px; height: 28px;
        border-radius: 50%;
        border: 1.5px solid currentColor;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 14px;
        transition: background 0.2s;
    }
    .pdp-back:hover .pdp-back-arrow { background: var(--forest); color: var(--cream); }

    .pdp-logo {
        font-family: 'Cormorant Garamond', serif;
        font-size: 22px;
        font-weight: 600;
        color: var(--forest);
        letter-spacing: 0.04em;
    }
    .pdp-cart-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--forest);
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        padding: 9px 20px;
        border: 1.5px solid var(--line-mid);
        border-radius: 999px;
        transition: all 0.2s;
    }
    .pdp-cart-btn:hover {
        background: var(--forest);
        color: var(--cream);
        border-color: var(--forest);
    }

    /* ── Main layout ── */
    .pdp-container {
        max-width: 1180px;
        margin: 0 auto;
        padding: 60px 32px 80px;
        position: relative;
        z-index: 1;
    }

    /* ── Product hero ── */
    .pdp-hero {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
        background: var(--parchment);
        border-radius: 32px;
        overflow: hidden;
        border: 1px solid var(--line-mid);
        box-shadow: 0 30px 80px rgba(30, 48, 32, 0.14), 0 8px 24px rgba(30, 48, 32, 0.08);
        animation: pdp-fadeup 0.7s ease both;
    }

    @keyframes pdp-fadeup {
        from { opacity: 0; transform: translateY(28px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Left: Image */
    .pdp-img-side {
        position: relative;
        background: linear-gradient(160deg, #e8dfc9 0%, #d4c9a8 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 52px 44px;
        min-height: 520px;
    }
    .pdp-img-side::after {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 1px; height: 100%;
        background: linear-gradient(to bottom, transparent, var(--line-mid) 20%, var(--line-mid) 80%, transparent);
    }
    .pdp-badge-organic {
        position: absolute;
        top: 24px; left: 24px;
        background: var(--forest);
        color: var(--sage-lt);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        padding: 6px 14px;
        border-radius: 999px;
    }
    .pdp-main-img {
        width: 100%;
        max-width: 320px;
        aspect-ratio: 1;
        object-fit: contain;
        background: var(--cream);
        padding: 16px;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(30,48,32,0.22), 0 6px 14px rgba(30,48,32,0.1);
        transition: transform 0.4s ease;
    }
    .pdp-main-img:hover { transform: scale(1.025) rotate(0.6deg); }
    .pdp-no-img {
        width: 100%; max-width: 320px; aspect-ratio: 1;
        border-radius: 20px;
        background: var(--cream-deep);
        display: flex; align-items: center; justify-content: center;
        color: var(--text-muted);
        font-size: 14px;
    }
    .pdp-img-ornament {
        position: absolute;
        bottom: 24px; right: 28px;
        font-family: 'Cormorant Garamond', serif;
        font-size: 11px;
        font-style: italic;
        color: var(--text-muted);
        letter-spacing: 0.04em;
    }

    /* Right: Info */
    .pdp-info-side {
        padding: 52px 52px 48px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 28px;
    }

    .pdp-eyebrow {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--text-muted);
    }
    .pdp-eyebrow::before {
        content: '';
        display: block;
        width: 28px; height: 1px;
        background: var(--gold);
    }

    .pdp-product-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 46px;
        font-weight: 600;
        line-height: 1.1;
        color: var(--text-dark);
        margin: 8px 0 0;
    }

    .pdp-rating-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 4px;
    }
    .pdp-stars { color: var(--gold); font-size: 15px; letter-spacing: 2px; }
    .pdp-review-count { font-size: 13px; color: var(--text-muted); }

    .pdp-divider {
        height: 1px;
        background: linear-gradient(to right, var(--line-mid), transparent);
        margin: 4px 0;
    }

    .pdp-price-wrap { display: flex; align-items: baseline; gap: 12px; }
    .pdp-price {
        font-family: 'Cormorant Garamond', serif;
        font-size: 48px;
        font-weight: 700;
        color: var(--forest);
        line-height: 1;
    }
    .pdp-price-note {
        font-size: 13px;
        color: var(--text-muted);
        padding: 4px 12px;
        background: var(--moss);
        border-radius: 999px;
        font-weight: 500;
    }

    .pdp-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 6px;
    }
    .pdp-chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 14px;
        border-radius: 999px;
        border: 1px solid var(--line-mid);
        background: rgba(255,255,255,0.5);
        font-size: 12.5px;
        font-weight: 500;
        color: var(--text-mid);
    }
    .pdp-chip-icon { font-size: 15px; }

    .pdp-chip-habis {
        background: linear-gradient(135deg, #d1546a, #b8364c);
        color: #fff;
        border-color: transparent;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        box-shadow: 0 2px 8px rgba(209,84,106,0.32);
    }

    .pdp-habis-banner {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 22px 24px;
        border-radius: 18px;
        background: linear-gradient(135deg, rgba(209,84,106,0.08), rgba(184,54,76,0.04));
        border: 1px dashed rgba(209,84,106,0.32);
    }
    .pdp-habis-icon { font-size: 34px; flex-shrink: 0; }
    .pdp-habis-title { font-weight: 700; color: #b8364c; font-size: 15px; margin-bottom: 4px; }
    .pdp-habis-sub { color: var(--text-soft); font-size: 13px; }

    .pdp-other-habis-badge {
        position: absolute; top: 9px; right: 9px;
        background: linear-gradient(135deg, #d1546a, #b8364c);
        color: #fff;
        font-size: 10.5px; font-weight: 700;
        padding: 4px 10px; border-radius: 20px;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        box-shadow: 0 2px 8px rgba(209,84,106,0.4);
    }
    .pdp-other-card.pdp-other-habis .pdp-other-img,
    .pdp-other-card.pdp-other-habis .pdp-other-no-img {
        filter: grayscale(0.7) opacity(0.65);
    }
    .pdp-other-card.pdp-other-habis .pdp-other-cta {
        color: #b8364c;
    }

    .pdp-desc-short {
        font-size: 14.5px;
        line-height: 1.7;
        color: var(--text-soft);
        border-left: 2px solid var(--gold);
        padding-left: 16px;
        font-style: italic;
        font-family: 'Cormorant Garamond', serif;
        font-size: 18px;
    }

    /* Qty + CTA */
    .pdp-bottom-block { display: flex; flex-direction: column; gap: 20px; }

    .pdp-qty-label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 8px;
    }
    .pdp-qty-row {
        display: flex;
        align-items: center;
        gap: 0;
        background: rgba(255,255,255,0.55);
        border: 1px solid var(--line-mid);
        border-radius: 16px;
        padding: 6px;
        width: fit-content;
    }
    .pdp-qty-btn {
        width: 40px; height: 40px;
        border: none;
        border-radius: 10px;
        background: transparent;
        color: var(--forest);
        font-size: 20px;
        font-weight: 300;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background 0.18s, color 0.18s;
    }
    .pdp-qty-btn:hover { background: var(--forest); color: var(--cream); }
    .pdp-qty-display {
        width: 52px;
        text-align: center;
        font-family: 'Cormorant Garamond', serif;
        font-size: 26px;
        font-weight: 600;
        color: var(--forest);
    }

    .pdp-cta-row {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }
    .pdp-btn-primary {
        flex: 1;
        min-width: 180px;
        height: 56px;
        border: none;
        border-radius: 16px;
        background: var(--forest);
        color: var(--cream);
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 0.04em;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        transition: background 0.2s, transform 0.18s, box-shadow 0.18s;
        box-shadow: 0 10px 28px rgba(44, 74, 46, 0.28);
        text-decoration: none;
    }
    .pdp-btn-primary:hover {
        background: var(--forest-mid);
        transform: translateY(-2px);
        box-shadow: 0 16px 36px rgba(44, 74, 46, 0.36);
        color: var(--cream);
    }
    .pdp-btn-secondary {
        flex: 1;
        min-width: 180px;
        height: 56px;
        border: 1.5px solid var(--forest);
        border-radius: 16px;
        background: transparent;
        color: var(--forest);
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 0.04em;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        transition: all 0.2s;
        text-decoration: none;
    }
    .pdp-btn-secondary:hover {
        background: var(--forest);
        color: var(--cream);
        transform: translateY(-2px);
    }

    /* ── Description block ── */
    .pdp-desc-block {
        margin-top: 40px;
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 24px;
        animation: pdp-fadeup 0.7s 0.15s ease both;
    }
    .pdp-desc-card {
        background: var(--parchment);
        border-radius: 24px;
        padding: 36px 38px;
        border: 1px solid var(--line);
        box-shadow: 0 8px 24px rgba(30,48,32,0.07);
    }
    .pdp-section-label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .pdp-section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--line-mid);
    }
    .pdp-desc-text {
        font-size: 15px;
        line-height: 1.75;
        color: var(--text-mid);
        margin: 0;
        white-space: pre-line;
    }


    /* ── Other products ── */
    .pdp-others-section {
        margin-top: 56px;
        animation: pdp-fadeup 0.7s 0.25s ease both;
    }
    .pdp-others-header {
        display: flex;
        align-items: baseline;
        gap: 16px;
        margin-bottom: 28px;
    }
    .pdp-others-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 36px;
        font-weight: 600;
        color: var(--text-dark);
    }
    .pdp-others-subtitle {
        font-size: 13px;
        color: var(--text-muted);
    }
    .pdp-others-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }
    .pdp-other-card {
        background: var(--parchment);
        border-radius: 22px;
        overflow: hidden;
        border: 1px solid var(--line);
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        box-shadow: 0 6px 20px rgba(30,48,32,0.07);
        transition: transform 0.22s ease, box-shadow 0.22s ease;
    }
    .pdp-other-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 18px 44px rgba(30,48,32,0.14);
        color: inherit;
    }
    .pdp-other-img-wrap {
        aspect-ratio: 1;
        overflow: hidden;
        background: var(--cream);
        position: relative;
        padding: 10px;
    }
    .pdp-other-img {
        width: 100%; height: 100%;
        object-fit: contain;
        display: block;
        transition: transform 0.4s ease;
    }
    .pdp-other-card:hover .pdp-other-img { transform: scale(1.06); }
    .pdp-other-no-img {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        color: var(--text-muted); font-size: 13px;
    }
    .pdp-other-body {
        padding: 18px 18px 16px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex: 1;
    }
    .pdp-other-name {
        font-size: 14px;
        font-weight: 600;
        line-height: 1.3;
        color: var(--text-dark);
    }
    .pdp-other-price {
        font-family: 'Cormorant Garamond', serif;
        font-size: 20px;
        font-weight: 700;
        color: var(--forest);
    }
    .pdp-other-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        padding-top: 12px;
        border-top: 1px solid var(--line);
    }
    .pdp-other-stok {
        font-size: 11px;
        color: var(--text-muted);
    }
    .pdp-other-cta {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--forest);
        display: inline-flex; align-items: center; gap: 4px;
        transition: gap 0.18s;
    }
    .pdp-other-card:hover .pdp-other-cta { gap: 7px; }

    /* ── Review Section ── */
    .pdp-review-section {
        margin-top: 48px;
        animation: pdp-fadeup 0.7s 0.2s ease both;
    }
    .pdp-review-header {
        display: flex;
        align-items: baseline;
        gap: 16px;
        margin-bottom: 28px;
    }
    .pdp-review-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 36px;
        font-weight: 600;
        color: var(--text-dark);
    }
    .pdp-review-count-badge {
        font-size: 13px;
        color: var(--text-muted);
    }

    .pdp-review-layout {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 24px;
        align-items: start;
    }

    /* Summary panel */
    .pdp-review-summary {
        background: var(--parchment);
        border-radius: 24px;
        padding: 32px 30px;
        border: 1px solid var(--line);
        box-shadow: 0 8px 24px rgba(30,48,32,0.07);
        position: sticky;
        top: 80px;
    }
    .pdp-avg-score {
        font-family: 'Cormorant Garamond', serif;
        font-size: 72px;
        font-weight: 700;
        color: var(--forest);
        line-height: 1;
        margin-bottom: 6px;
    }
    .pdp-avg-stars {
        font-size: 22px;
        letter-spacing: 3px;
        margin-bottom: 4px;
    }
    .pdp-avg-label {
        font-size: 12px;
        color: var(--text-muted);
        margin-bottom: 24px;
    }
    .pdp-bar-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
    }
    .pdp-bar-label {
        font-size: 12px;
        color: var(--text-muted);
        width: 14px;
        text-align: right;
        flex-shrink: 0;
    }
    .pdp-bar-track {
        flex: 1;
        height: 6px;
        background: var(--cream-mid);
        border-radius: 999px;
        overflow: hidden;
    }
    .pdp-bar-fill {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, var(--gold-lt), var(--gold));
        transition: width 0.8s ease;
    }
    .pdp-bar-count {
        font-size: 11px;
        color: var(--text-muted);
        width: 20px;
        flex-shrink: 0;
    }

    /* Write review */
    .pdp-write-review {
        margin-top: 24px;
        padding-top: 22px;
        border-top: 1px solid var(--line-mid);
    }
    .pdp-write-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 12px;
    }
    .pdp-star-picker {
        display: flex;
        gap: 4px;
        margin-bottom: 14px;
    }
    .pdp-star-pick {
        font-size: 28px;
        cursor: pointer;
        color: var(--cream-deep);
        transition: color 0.15s, transform 0.15s;
        line-height: 1;
        user-select: none;
    }
    .pdp-star-pick.active,
    .pdp-star-pick.hover { color: var(--gold); transform: scale(1.15); }

    .pdp-review-textarea {
        width: 100%;
        border: 1px solid var(--line-mid);
        border-radius: 14px;
        background: rgba(255,255,255,0.6);
        padding: 12px 16px;
        font-family: 'DM Sans', sans-serif;
        font-size: 13.5px;
        color: var(--text-dark);
        resize: none;
        outline: none;
        transition: border-color 0.2s;
        min-height: 90px;
    }
    .pdp-review-textarea::placeholder { color: var(--text-muted); }
    .pdp-review-textarea:focus { border-color: var(--forest-lt); }

    .pdp-review-name-input {
        width: 100%;
        border: 1px solid var(--line-mid);
        border-radius: 14px;
        background: rgba(255,255,255,0.6);
        padding: 10px 16px;
        font-family: 'DM Sans', sans-serif;
        font-size: 13.5px;
        color: var(--text-dark);
        outline: none;
        transition: border-color 0.2s;
        margin-bottom: 10px;
    }
    .pdp-review-name-input::placeholder { color: var(--text-muted); }
    .pdp-review-name-input:focus { border-color: var(--forest-lt); }

    .pdp-submit-review {
        width: 100%;
        height: 44px;
        border: none;
        border-radius: 12px;
        background: var(--forest);
        color: var(--cream);
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 10px;
        transition: background 0.2s, transform 0.18s;
    }
    .pdp-submit-review:hover { background: var(--forest-mid); transform: translateY(-1px); }
    .pdp-submit-review:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

    /* Review list */
    .pdp-review-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .pdp-review-card {
        background: var(--parchment);
        border-radius: 20px;
        padding: 24px 26px;
        border: 1px solid var(--line);
        box-shadow: 0 4px 14px rgba(30,48,32,0.05);
        animation: pdp-fadeup 0.5s ease both;
    }
    .pdp-review-card-top {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 12px;
    }
    .pdp-reviewer-avatar {
        width: 42px; height: 42px;
        border-radius: 50%;
        background: var(--moss);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Cormorant Garamond', serif;
        font-size: 18px;
        font-weight: 600;
        color: var(--forest);
        flex-shrink: 0;
    }
    .pdp-reviewer-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
    }
    .pdp-reviewer-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 3px;
    }
    .pdp-review-stars-small {
        color: var(--gold);
        font-size: 13px;
        letter-spacing: 1px;
    }
    .pdp-review-date {
        font-size: 11px;
        color: var(--text-muted);
    }
    .pdp-review-badge-verified {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--forest-lt);
        background: var(--moss);
        padding: 2px 9px;
        border-radius: 999px;
    }
    .pdp-review-body {
        font-size: 14px;
        line-height: 1.7;
        color: var(--text-mid);
        margin: 0;
    }
    .pdp-review-helpful {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px solid var(--line);
    }
    .pdp-helpful-label {
        font-size: 11px;
        color: var(--text-muted);
    }
    .pdp-helpful-btn {
        font-size: 11px;
        font-weight: 600;
        color: var(--text-soft);
        background: rgba(255,255,255,0.5);
        border: 1px solid var(--line-mid);
        border-radius: 999px;
        padding: 4px 12px;
        cursor: pointer;
        transition: all 0.18s;
    }
    .pdp-helpful-btn:hover { background: var(--forest); color: var(--cream); border-color: var(--forest); }
    .pdp-helpful-btn.liked { background: var(--forest); color: var(--cream); border-color: var(--forest); }

    .pdp-no-reviews {
        background: var(--parchment);
        border-radius: 20px;
        padding: 48px 32px;
        text-align: center;
        border: 1px dashed var(--line-mid);
    }
    .pdp-no-reviews-icon { font-size: 36px; margin-bottom: 12px; }
    .pdp-no-reviews-text {
        font-family: 'Cormorant Garamond', serif;
        font-size: 20px;
        color: var(--text-soft);
        font-style: italic;
    }
    .pdp-no-reviews-sub {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 6px;
    }

    .pdp-toast {
        position: fixed;
        bottom: 32px; left: 50%;
        transform: translateX(-50%) translateY(20px);
        background: var(--forest);
        color: var(--cream);
        padding: 12px 24px;
        border-radius: 999px;
        font-size: 13.5px;
        font-weight: 600;
        opacity: 0;
        pointer-events: none;
        z-index: 999;
        transition: opacity 0.3s, transform 0.3s;
        white-space: nowrap;
    }
    .pdp-toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

    /* ── Footer ornament ── */
    .pdp-footer-ornament {
        text-align: center;
        margin-top: 60px;
        font-family: 'Cormorant Garamond', serif;
        font-size: 13px;
        font-style: italic;
        color: var(--text-muted);
        letter-spacing: 0.06em;
    }
    .pdp-footer-ornament span { color: var(--gold); margin: 0 6px; }

    /* ── Responsive ── */
    @media (max-width: 900px) {
        .pdp-hero { grid-template-columns: 1fr; }
        .pdp-img-side { min-height: 300px; padding: 36px 32px; }
        .pdp-img-side::after { display: none; }
        .pdp-info-side { padding: 36px 32px; }
        .pdp-product-name { font-size: 36px; }
        .pdp-price { font-size: 36px; }
        .pdp-desc-block { grid-template-columns: 1fr; }
        .pdp-others-grid { grid-template-columns: repeat(2, 1fr); }
        .pdp-topbar-inner { padding: 12px 20px; }
        .pdp-logo { display: none; }
        .pdp-container { padding: 32px 20px 60px; }
        .pdp-review-layout { grid-template-columns: 1fr; }
        .pdp-review-summary { position: static; }
    }
    @media (max-width: 560px) {
        .pdp-others-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .pdp-cta-row { flex-direction: column; }
        .pdp-btn-primary, .pdp-btn-secondary { min-width: 100%; }
        .pdp-product-name { font-size: 30px; }
        .pdp-avg-score { font-size: 56px; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.body.classList.add('pdp-body');
        initReviews();
    });

    function changeQty(delta) {
        const display = document.getElementById('pdpQtyDisplay');
        const input = document.getElementById('pdpQtyInput');
        const max = {{ max(1, (int) $product->stok) }};
        let val = parseInt(display.textContent || '1', 10) + delta;
        val = Math.max(1, Math.min(val, max));
        display.textContent = val;
        input.value = val;
    }

    /* ── Review system ── */
    const STORAGE_KEY = 'pdp_reviews_{{ $product->id }}';
    const STORAGE_VER = 'pdp_ver_{{ $product->id }}';
    const CURRENT_VER = '2';

    const defaultReviews = [
        { name: 'Siti Rahayu',     rating: 5, text: 'Produk luar biasa! Saya sudah pakai selama 2 minggu dan badan terasa lebih segar. Sangat recommended!', date: '2 hari lalu', helpful: 24 },
        { name: 'Budi Santoso',    rating: 5, text: 'Kualitas top, pengiriman cepat sampai Surabaya. Kemasannya juga rapi dan tidak bocor. Pasti beli lagi!', date: '4 hari lalu', helpful: 18 },
        { name: 'Rina Marlina',    rating: 5, text: 'Sudah coba banyak produk herbal, tapi ini yang paling terasa khasiatnya. Badan lebih fit dan tidur lebih nyenyak.', date: '5 hari lalu', helpful: 15 },
        { name: 'Agus Hermawan',   rating: 5, text: 'Mantap sekali! Istri saya juga ikut minum dan hasilnya sama-sama memuaskan. Stok langsung beli 3 botol.', date: '1 minggu lalu', helpful: 11 },
        { name: 'Dewi Kusuma',     rating: 4, text: 'Rasanya enak dan natural. Sedikit pahit tapi itu tandanya bahan herbalnya asli. Harga juga sangat terjangkau.', date: '1 minggu lalu', helpful: 9 },
        { name: 'Hendra Wijaya',   rating: 5, text: 'Pelayanan ramah, barang sampai aman. Khasiatnya terasa dalam 3 hari pertama. Cocok untuk stamina kerja.', date: '2 minggu lalu', helpful: 13 },
        { name: 'Nuraini',         rating: 5, text: 'Pertama kali beli dan langsung cocok! Tidak ada efek samping sama sekali. Akan terus langganan di sini.', date: '2 minggu lalu', helpful: 7 },
        { name: 'Rizky Pratama',   rating: 5, text: 'Produk herbal terbaik yang pernah saya coba. Sudah rekomendasi ke seluruh keluarga. Jangan sampai kehabisan stok!', date: '3 minggu lalu', helpful: 20 },
        { name: 'Sulistyo',        rating: 5, text: 'Harga terjangkau, kualitas premium. Packing aman, pengiriman cepat. Pokoknya 5 bintang layak banget!', date: '3 minggu lalu', helpful: 6 },
        { name: 'Fatimah Zahra',   rating: 5, text: 'Alhamdulillah cocok banget. Badan jadi lebih bertenaga, dan terasa lebih sehat. Terima kasih produknya luar biasa!', date: '1 bulan lalu', helpful: 17 },
    ];

    let reviews = [];
    let selectedRating = 0;

    function initReviews() {
        try {
            const ver = localStorage.getItem(STORAGE_VER);
            const stored = localStorage.getItem(STORAGE_KEY);
            if (stored && ver === CURRENT_VER) {
                reviews = JSON.parse(stored);
            } else {
                reviews = [...defaultReviews];
                localStorage.setItem(STORAGE_VER, CURRENT_VER);
                localStorage.removeItem(STORAGE_KEY);
            }
        } catch(e) {
            reviews = [...defaultReviews];
        }
        renderReviews();
        renderSummary();
        initStarPicker();
    }

    function saveReviews() {
        try { localStorage.setItem(STORAGE_KEY, JSON.stringify(reviews)); } catch(e) {}
    }

    function renderSummary() {
        const total = reviews.length;
        const avg = total ? (reviews.reduce((s, r) => s + r.rating, 0) / total) : 0;

        document.getElementById('pdpAvgScore').textContent = avg.toFixed(1);
        document.getElementById('pdpTotalReviews').textContent = total + ' ulasan';

        // stars
        const fullStars = Math.round(avg);
        document.getElementById('pdpAvgStars').textContent = '★'.repeat(fullStars) + '☆'.repeat(5 - fullStars);

        // distribution bars
        for (let s = 5; s >= 1; s--) {
            const count = reviews.filter(r => r.rating === s).length;
            const pct = total ? (count / total * 100) : 0;
            const bar = document.getElementById('pdpBar' + s);
            const cnt = document.getElementById('pdpBarCount' + s);
            if (bar) bar.style.width = pct + '%';
            if (cnt) cnt.textContent = count;
        }

        // update hero rating
        const heroCount = document.getElementById('pdpHeroReviewCount');
        if (heroCount) heroCount.textContent = total + ' ulasan';
    }

    function renderReviews() {
        const list = document.getElementById('pdpReviewList');
        if (!list) return;
        list.innerHTML = '';

        if (!reviews.length) {
            list.innerHTML = `<div class="pdp-no-reviews">
                <div class="pdp-no-reviews-icon">🌿</div>
                <div class="pdp-no-reviews-text">Belum ada ulasan</div>
                <p class="pdp-no-reviews-sub">Jadilah yang pertama memberikan ulasan</p>
            </div>`;
            return;
        }

        reviews.forEach((rv, idx) => {
            const initials = rv.name.split(' ').map(w => w[0]).join('').substring(0,2).toUpperCase();
            const stars = '★'.repeat(rv.rating) + '☆'.repeat(5 - rv.rating);
            const card = document.createElement('div');
            card.className = 'pdp-review-card';
            card.style.animationDelay = (idx * 0.06) + 's';
            card.innerHTML = `
                <div class="pdp-review-card-top">
                    <div class="pdp-reviewer-avatar">${initials}</div>
                    <div style="flex:1;">
                        <div class="pdp-reviewer-name">${escHtml(rv.name)}</div>
                        <div class="pdp-reviewer-meta">
                            <span class="pdp-review-stars-small">${stars}</span>
                            <span class="pdp-review-date">${escHtml(rv.date)}</span>
                            ${rv.verified !== false ? '<span class="pdp-review-badge-verified">✓ Verified</span>' : ''}
                        </div>
                    </div>
                </div>
                <p class="pdp-review-body">${escHtml(rv.text)}</p>
                <div class="pdp-review-helpful">
                    <span class="pdp-helpful-label">Ulasan ini membantu?</span>
                    <button class="pdp-helpful-btn ${rv.likedByMe ? 'liked' : ''}" onclick="toggleHelpful(${idx})">
                        👍 Ya (${rv.helpful || 0})
                    </button>
                </div>
            `;
            list.appendChild(card);
        });
    }

    function toggleHelpful(idx) {
        if (reviews[idx].likedByMe) return;
        reviews[idx].helpful = (reviews[idx].helpful || 0) + 1;
        reviews[idx].likedByMe = true;
        saveReviews();
        renderReviews();
    }

    function initStarPicker() {
        const stars = document.querySelectorAll('.pdp-star-pick');
        stars.forEach((star, i) => {
            star.addEventListener('mouseenter', () => {
                stars.forEach((s, j) => s.classList.toggle('hover', j <= i));
            });
            star.addEventListener('mouseleave', () => {
                stars.forEach((s, j) => s.classList.toggle('hover', false));
                stars.forEach((s, j) => s.classList.toggle('active', j < selectedRating));
            });
            star.addEventListener('click', () => {
                selectedRating = i + 1;
                stars.forEach((s, j) => s.classList.toggle('active', j < selectedRating));
            });
        });
    }

    function submitReview() {
        const name = document.getElementById('pdpReviewName').value.trim();
        const text = document.getElementById('pdpReviewText').value.trim();
        if (!name) { showToast('Masukkan nama Anda'); return; }
        if (!selectedRating) { showToast('Pilih rating bintang dulu'); return; }
        if (!text || text.length < 10) { showToast('Tulis ulasan minimal 10 karakter'); return; }

        const now = new Date();
        reviews.unshift({
            name, rating: selectedRating, text,
            date: 'Baru saja',
            helpful: 0,
            verified: false
        });
        saveReviews();
        renderReviews();
        renderSummary();

        // reset
        document.getElementById('pdpReviewName').value = '';
        document.getElementById('pdpReviewText').value = '';
        selectedRating = 0;
        document.querySelectorAll('.pdp-star-pick').forEach(s => s.classList.remove('active'));

        showToast('✦ Ulasan berhasil dikirim, terima kasih!');
    }

    function showToast(msg) {
        const t = document.getElementById('pdpToast');
        t.textContent = msg;
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), 2800);
    }

    function escHtml(s) {
        return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }
</script>

<div class="pdp-root">
    <div class="pdp-bg"><div class="pdp-bg-leaf"></div></div>

    {{-- Topbar --}}
    <div class="pdp-topbar">
        <div class="pdp-topbar-inner">
            <a href="{{ route('user.dashboard') }}" class="pdp-back">
                <span class="pdp-back-arrow">←</span>
                Kembali
            </a>
            <div class="pdp-logo">🌿 Herbal Store</div>
            <a href="{{ route('carts.index') }}" class="pdp-cart-btn">
                🛒 Keranjang
            </a>
        </div>
    </div>

    <div class="pdp-container">

        {{-- Hero --}}
        <div class="pdp-hero">
            {{-- Left: image --}}
            <div class="pdp-img-side">
                <div class="pdp-badge-organic">✦ Herbal Alami</div>
                @if ($product->gambar)
                    <img src="{{ asset('storage/' . $product->gambar) }}"
                         alt="{{ $product->nama_produk }}"
                         class="pdp-main-img">
                @else
                    <div class="pdp-no-img">No Image</div>
                @endif
                <div class="pdp-img-ornament">{{ $product->nama_produk }}</div>
            </div>

            {{-- Right: info --}}
            <div class="pdp-info-side">
                <div>
                    <div class="pdp-eyebrow">Produk Unggulan</div>
                    <h1 class="pdp-product-name">{{ $product->nama_produk }}</h1>
                    <div class="pdp-rating-row">
                        <span class="pdp-stars">★★★★★</span>
                        <span class="pdp-review-count" id="pdpHeroReviewCount">{{ max(1, (int)($product->total_terjual ?? 0)) }} terjual</span>
                    </div>
                </div>

                <div class="pdp-divider"></div>

                <div>
                    <div class="pdp-price-wrap">
                        <div class="pdp-price">Rp&nbsp;{{ number_format($product->harga, 0, ',', '.') }}</div>
                        <span class="pdp-price-note">/ botol</span>
                    </div>
                    <div class="pdp-chips">
                        @if ($product->stok > 0)
                            <span class="pdp-chip"><span class="pdp-chip-icon">📦</span> Stok: {{ $product->stok }}</span>
                        @else
                            <span class="pdp-chip pdp-chip-habis"><span class="pdp-chip-icon">⚠️</span> Stok Habis</span>
                        @endif
                        <span class="pdp-chip"><span class="pdp-chip-icon">🚚</span> Gratis Ongkir</span>
                        <span class="pdp-chip"><span class="pdp-chip-icon">📍</span> Dari Jambi</span>
                    </div>
                </div>

                @if ($product->deskripsi)
                <div class="pdp-desc-short">
                    {{ \Illuminate\Support\Str::limit($product->deskripsi, 120) }}
                </div>
                @endif

                <div class="pdp-bottom-block">
                    @if (session('error'))
                        <div style="padding:14px 18px;border-radius:14px;background:linear-gradient(135deg,rgba(209,84,106,0.16),rgba(184,54,76,0.06));border:1px solid rgba(209,84,106,0.28);color:#b8364c;font-size:13.5px;font-weight:500;display:flex;align-items:center;gap:10px;">
                            <span style="font-size:18px;">⚠</span>
                            {{ session('error') }}
                        </div>
                    @endif
                    @if ($product->stok > 0)
                    <div>
                        <div class="pdp-qty-label">Jumlah</div>
                        <div class="pdp-qty-row">
                            <button type="button" class="pdp-qty-btn" onclick="changeQty(-1)" aria-label="Kurangi">−</button>
                            <div class="pdp-qty-display" id="pdpQtyDisplay">1</div>
                            <button type="button" class="pdp-qty-btn" onclick="changeQty(1)" aria-label="Tambah">+</button>
                        </div>
                    </div>

                    <form action="{{ route('carts.store') }}" method="POST" id="pdpAddForm">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="qty" id="pdpQtyInput" value="1">
                        <input type="hidden" name="redirect_to" id="pdpRedirectTo" value="">
                        <div class="pdp-cta-row">
                            <button type="submit" class="pdp-btn-primary" onclick="document.getElementById('pdpRedirectTo').value=''">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M3 4h2l2.4 12.4A2 2 0 009.36 18H18a2 2 0 002-1.6L21.6 8H6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="9" cy="21" r="1.5" fill="currentColor"/>
                                    <circle cx="18" cy="21" r="1.5" fill="currentColor"/>
                                </svg>
                                Tambah ke Keranjang
                            </button>
                            <button type="submit" class="pdp-btn-secondary" onclick="document.getElementById('pdpRedirectTo').value='checkout'">
                                Beli Sekarang
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        </div>
                    </form>
                    @else
                    <div class="pdp-habis-banner">
                        <div class="pdp-habis-icon">📦</div>
                        <div>
                            <div class="pdp-habis-title">Maaf, produk sedang habis</div>
                            <div class="pdp-habis-sub">Silakan cek lagi nanti atau lihat produk lain di bawah.</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Description --}}
        <div class="pdp-desc-block">
            <div class="pdp-desc-card" style="grid-column: 1 / -1;">
                <div class="pdp-section-label">Deskripsi Produk</div>
                <p class="pdp-desc-text">{{ $product->deskripsi ?: 'Belum ada deskripsi untuk produk ini.' }}</p>
            </div>
        </div>

        {{-- ══ Review Section ══ --}}
        <div class="pdp-review-section">
            <div class="pdp-review-header">
                <h2 class="pdp-review-title">Ulasan Pelanggan</h2>
                <span class="pdp-review-count-badge" id="pdpTotalReviews">0 ulasan</span>
            </div>

            <div class="pdp-review-layout">

                {{-- Left: Summary + Write review --}}
                <div class="pdp-review-summary">
                    <div class="pdp-avg-score" id="pdpAvgScore">0.0</div>
                    <div class="pdp-avg-stars" id="pdpAvgStars">☆☆☆☆☆</div>
                    <div class="pdp-avg-label">dari 5 bintang</div>

                    @for ($s = 5; $s >= 1; $s--)
                    <div class="pdp-bar-row">
                        <span class="pdp-bar-label">{{ $s }}</span>
                        <div class="pdp-bar-track">
                            <div class="pdp-bar-fill" id="pdpBar{{ $s }}" style="width:0%"></div>
                        </div>
                        <span class="pdp-bar-count" id="pdpBarCount{{ $s }}">0</span>
                    </div>
                    @endfor

                    <div class="pdp-write-review">
                        <div class="pdp-write-label">Tulis Ulasan Anda</div>

                        <div class="pdp-star-picker">
                            @for ($i = 1; $i <= 5; $i++)
                            <span class="pdp-star-pick" data-value="{{ $i }}" title="{{ $i }} bintang">★</span>
                            @endfor
                        </div>

                        <input type="text"
                               id="pdpReviewName"
                               class="pdp-review-name-input"
                               placeholder="Nama Anda">

                        <textarea id="pdpReviewText"
                                  class="pdp-review-textarea"
                                  placeholder="Ceritakan pengalaman Anda dengan produk ini..."></textarea>

                        <button class="pdp-submit-review" onclick="submitReview()">
                            Kirim Ulasan ✦
                        </button>
                    </div>
                </div>

                {{-- Right: Review list --}}
                <div id="pdpReviewList" class="pdp-review-list">
                    {{-- Rendered by JS --}}
                </div>
            </div>
        </div>

        {{-- Other products --}}
        <div class="pdp-others-section">
            <div class="pdp-others-header">
                <h2 class="pdp-others-title">Produk Lainnya</h2>
                <span class="pdp-others-subtitle">Koleksi pilihan herbal kami</span>
            </div>

            <div class="pdp-others-grid">
                @forelse ($otherProducts as $other)
                @php $otherHabis = ($other->stok ?? 0) <= 0; @endphp
                <a href="{{ route('user.products.show', $other) }}" class="pdp-other-card {{ $otherHabis ? 'pdp-other-habis' : '' }}">
                    <div class="pdp-other-img-wrap">
                        @if ($other->gambar)
                            <img src="{{ asset('storage/' . $other->gambar) }}"
                                 alt="{{ $other->nama_produk }}"
                                 class="pdp-other-img">
                        @else
                            <div class="pdp-other-no-img">No Image</div>
                        @endif
                        @if ($otherHabis)
                            <span class="pdp-other-habis-badge">Habis</span>
                        @endif
                    </div>
                    <div class="pdp-other-body">
                        <div class="pdp-other-name">{{ $other->nama_produk }}</div>
                        <div class="pdp-other-price">Rp {{ number_format($other->harga, 0, ',', '.') }}</div>
                        <div class="pdp-other-footer">
                            <span class="pdp-other-stok">{{ $otherHabis ? 'Stok habis' : 'Stok: ' . $other->stok }}</span>
                            <span class="pdp-other-cta">{{ $otherHabis ? 'Habis' : 'Lihat →' }}</span>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-12">
                    <p style="color: var(--text-muted); font-size: 14px;">Belum ada produk lain.</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="pdp-footer-ornament">
            Dibuat dengan cinta<span>✦</span>untuk kesehatan alami Anda
        </div>
    </div>
</div>

<div class="pdp-toast" id="pdpToast"></div>
@endsection