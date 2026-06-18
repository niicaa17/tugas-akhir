@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap');

    :root {
        --ink:        #1a2e1a;
        --ink-soft:   #3d5c3d;
        --ink-muted:  #6b8c6b;
        --parchment:  #faf6ed;
        --parchment2: #f3ecda;
        --parchment3: #e8dfc6;
        --moss:       #4a7c4a;
        --moss-light: #6b9e5e;
        --moss-pale:  #c8ddb8;
        --gold:       #c8922a;
        --gold-pale:  #f0d898;
        --cream:      #fffdf7;
        --line:       rgba(26, 46, 26, 0.08);
        --line-md:    rgba(26, 46, 26, 0.16);
        --line-strong:rgba(26, 46, 26, 0.24);
        --shadow-xs:  0 1px 4px rgba(26,46,26,0.06);
        --shadow-sm:  0 4px 16px rgba(26,46,26,0.08);
        --shadow-md:  0 10px 32px rgba(26,46,26,0.10);
        --shadow-bar: 0 -8px 28px rgba(26,46,26,0.12);
        --r-sm:  10px;
        --r-md:  16px;
        --r-lg:  20px;
    }

    .user-payment-page .navbar { display: none; }
    .user-payment-page main.py-4 { padding: 0 !important; }
    *, *::before, *::after { box-sizing: border-box; }

    /* ── PAGE ── */
    .pay-page {
        min-height: 100vh;
        background: linear-gradient(160deg, #f5f0e4 0%, #ede5cf 60%, #e4d9be 100%);
        font-family: 'DM Sans', sans-serif;
        color: var(--ink);
    }

    /* ── TOPBAR ── */
    .pay-topbar {
        position: sticky; top: 0; z-index: 30;
        background: rgba(250, 246, 237, 0.92);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border-bottom: 1px solid var(--line-md);
    }
    .pay-topbar-inner {
        max-width: 1100px; margin: 0 auto;
        padding: 14px 24px;
        display: flex; align-items: center; justify-content: space-between;
        gap: 16px;
    }
    .pay-back {
        display: inline-flex; align-items: center; gap: 8px;
        font-size: 13px; font-weight: 600; color: var(--ink-soft);
        text-decoration: none;
        padding: 7px 14px 7px 10px;
        border-radius: 999px;
        border: 1px solid var(--line-md);
        background: var(--cream);
        transition: all .2s;
    }
    .pay-back:hover { color: var(--moss); border-color: var(--moss-pale); background: #f0f7ea; }
    .pay-back svg { transition: transform .2s; }
    .pay-back:hover svg { transform: translateX(-3px); }
    .pay-topbar-title {
        font-family: 'DM Serif Display', serif;
        font-size: 17px; color: var(--ink); letter-spacing: -.02em;
    }
    .pay-step-pill {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 5px 12px; border-radius: 999px;
        background: rgba(74,124,74,0.10);
        color: var(--moss);
        font-size: 12px; font-weight: 600;
        border: 1px solid rgba(74,124,74,0.18);
    }

    /* ── WRAP ── */
    .pay-wrap {
        max-width: 1100px; margin: 0 auto;
        padding: 24px 24px 140px;
    }

    /* ── HEAD ── */
    .pay-head { margin-bottom: 16px; }
    .pay-eyebrow {
        font-size: 11px; font-weight: 700;
        letter-spacing: 0.13em; text-transform: uppercase;
        color: var(--gold); margin-bottom: 8px;
        display: inline-flex; align-items: center; gap: 7px;
    }
    .pay-eyebrow::before { content:''; width: 18px; height: 1px; background: var(--gold); opacity: .7; }
    .pay-title {
        font-family: 'DM Serif Display', serif;
        font-size: clamp(26px, 4vw, 36px);
        line-height: 1.1;
        color: var(--ink);
        letter-spacing: -.025em;
        margin: 0 0 6px;
    }
    .pay-title em { font-style: italic; color: var(--moss); }
    .pay-sub { font-size: 13.5px; color: var(--ink-muted); line-height: 1.55; max-width: 540px; }

    /* ── ALERT ── */
    .pay-alert {
        background: rgba(184,54,76,0.08);
        border: 1px solid rgba(184,54,76,0.25);
        border-radius: var(--r-sm);
        padding: 12px 16px;
        font-size: 13px; color: #a13a4d;
        margin-bottom: 14px; font-weight: 500;
        display: flex; align-items: center; gap: 10px;
    }
    .pay-alert::before { content: '!'; width: 22px; height: 22px; border-radius: 50%; background: #b8364c; color: #fff; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0; }

    /* ── ADDRESS CARD (Shopee top section) ── */
    .pay-address-card {
        background: var(--cream);
        border: 1px solid var(--line-md);
        border-radius: var(--r-md);
        margin-bottom: 14px;
        overflow: hidden;
        position: relative;
    }
    .pay-address-card::before {
        content: '';
        position: absolute; left: 0; right: 0; bottom: 0;
        height: 3px;
        background:
            repeating-linear-gradient(135deg,
                #d1546a 0, #d1546a 10px,
                var(--moss) 10px, var(--moss) 20px,
                var(--gold) 20px, var(--gold) 30px);
    }
    .pay-address-head {
        display: flex; align-items: center; gap: 10px;
        padding: 16px 22px;
        border-bottom: 1px solid var(--line);
    }
    .pay-address-icon {
        width: 28px; height: 28px;
        border-radius: 8px;
        background: rgba(184,54,76,0.10);
        color: #b8364c;
        display: inline-flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .pay-address-title {
        font-size: 15px; font-weight: 700; color: var(--ink);
        letter-spacing: -.01em;
    }
    .pay-address-body {
        padding: 18px 22px 20px;
        display: grid;
        grid-template-columns: 220px 1fr auto;
        gap: 22px;
        align-items: flex-start;
    }
    .pay-receiver {
        display: flex; flex-direction: column; gap: 2px;
    }
    .pay-receiver-name { font-size: 14px; font-weight: 700; color: var(--ink); }
    .pay-receiver-phone { font-size: 13px; color: var(--ink-soft); }
    .pay-address-text {
        font-size: 13.5px; color: var(--ink-soft);
        line-height: 1.55;
    }
    .pay-address-default {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 9px; border-radius: 4px;
        background: rgba(184,54,76,0.10);
        color: #b8364c;
        font-size: 10.5px; font-weight: 700;
        letter-spacing: 0.04em; text-transform: uppercase;
        margin-bottom: 8px;
    }
    .pay-address-edit {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px;
        border-radius: var(--r-sm);
        border: 1px solid var(--line-strong);
        background: #fff;
        font-size: 12.5px; font-weight: 600;
        color: var(--ink-soft);
        cursor: pointer;
        text-decoration: none;
        transition: all 0.18s;
        flex-shrink: 0;
    }
    .pay-address-edit:hover { background: var(--moss-pale); border-color: var(--moss); color: var(--moss); }

    /* edit form inline */
    .pay-address-form { display: none; padding: 22px; border-top: 1px solid var(--line); background: var(--parchment); }
    .pay-address-form.is-open { display: grid; }
    .pay-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .pay-form-grid .full { grid-column: 1 / -1; }
    .pay-label {
        display: block; font-size: 12.5px; font-weight: 600;
        color: var(--ink-soft); margin-bottom: 6px;
    }
    .pay-input, .pay-textarea {
        width: 100%;
        height: 42px;
        padding: 0 14px;
        border-radius: 10px;
        border: 1px solid var(--line-md);
        background: #fff;
        color: var(--ink);
        font-family: 'DM Sans', sans-serif;
        font-size: 13.5px;
        transition: all 0.18s;
    }
    .pay-textarea { height: auto; padding: 11px 14px; min-height: 80px; resize: vertical; line-height: 1.5; }
    .pay-input:focus, .pay-textarea:focus { outline: none; border-color: var(--moss); box-shadow: 0 0 0 3px rgba(74,124,74,0.18); }
    .pay-input.is-error, .pay-textarea.is-error { border-color: #d1546a; background: #fdf3f5; }
    .pay-error { color: #d1546a; font-size: 11.5px; margin-top: 5px; }
    .pay-hint { color: var(--ink-muted); font-size: 11.5px; margin-top: 5px; line-height: 1.5; }
    .pay-form-actions {
        grid-column: 1 / -1;
        display: flex; justify-content: flex-end; gap: 10px;
        padding-top: 6px;
    }
    .pay-form-actions .pay-btn-ghost {
        background: transparent; border: 1px solid var(--line-md);
    }

    /* ── ORDER ITEMS CARD ── */
    .pay-card {
        background: var(--cream);
        border: 1px solid var(--line-md);
        border-radius: var(--r-md);
        margin-bottom: 14px;
        overflow: hidden;
    }
    .pay-card-head {
        display: flex; align-items: center; gap: 10px;
        padding: 14px 22px;
        background: linear-gradient(180deg, var(--parchment2), var(--cream));
        border-bottom: 1px solid var(--line);
    }
    .pay-shop-tag {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 10.5px; font-weight: 700; letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--gold);
        padding: 3px 9px; border-radius: 4px;
        background: var(--gold-pale);
    }
    .pay-shop-name {
        font-family: 'DM Serif Display', serif;
        font-size: 15px;
        color: var(--ink);
        letter-spacing: -.01em;
    }

    .pay-items-table {
        width: 100%;
        border-collapse: collapse;
    }
    .pay-items-table thead th {
        font-size: 11.5px; font-weight: 700; color: var(--ink-muted);
        text-transform: uppercase; letter-spacing: 0.08em;
        padding: 12px 22px;
        background: var(--parchment);
        border-bottom: 1px solid var(--line);
        text-align: left;
    }
    .pay-items-table thead th.t-right { text-align: right; }
    .pay-items-table thead th.t-center { text-align: center; }
    .pay-items-table tbody td {
        padding: 16px 22px;
        border-bottom: 1px solid var(--line);
        vertical-align: middle;
        font-size: 13.5px;
        color: var(--ink);
    }
    .pay-items-table tbody tr:last-child td { border-bottom: none; }

    .pay-item-info { display: flex; gap: 12px; align-items: center; min-width: 0; }
    .pay-item-img {
        width: 56px; height: 56px;
        border-radius: 10px;
        overflow: hidden;
        background: var(--parchment);
        flex-shrink: 0;
        padding: 6px;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid var(--line);
    }
    .pay-item-img img { width: 100%; height: 100%; object-fit: contain; }
    .pay-item-img .ph { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--ink-muted); font-size: 11px; }
    .pay-item-name { font-size: 13.5px; font-weight: 600; color: var(--ink); line-height: 1.35; }
    .pay-item-meta { font-size: 11.5px; color: var(--ink-muted); margin-top: 3px; }

    .pay-item-price { font-size: 13.5px; color: var(--ink); font-weight: 500; }
    .pay-item-qty { font-size: 13.5px; color: var(--ink); font-weight: 500; }
    .pay-item-subtotal { font-family: 'DM Serif Display', serif; font-size: 16px; color: var(--moss); font-weight: 500; letter-spacing: -.01em; }

    .pay-shop-total {
        display: flex; align-items: center; justify-content: flex-end;
        gap: 10px;
        padding: 14px 22px;
        background: var(--parchment);
        border-top: 1px solid var(--line);
        font-size: 13px;
    }
    .pay-shop-total span { color: var(--ink-soft); }
    .pay-shop-total strong {
        font-family: 'DM Serif Display', serif;
        font-size: 18px;
        color: var(--moss);
        font-weight: 500;
        letter-spacing: -.01em;
    }

    /* ── PAYMENT METHOD ── */
    .pay-method-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
        padding: 18px 22px;
    }
    .pay-method {
        position: relative;
        cursor: pointer;
        background: #fff;
        border: 1.5px solid var(--line-md);
        border-radius: 10px;
        padding: 14px 14px 12px;
        transition: all 0.18s;
        text-align: left;
        display: flex; flex-direction: column;
        min-height: 100px;
    }
    .pay-method input { position: absolute; opacity: 0; pointer-events: none; }
    .pay-method:hover { border-color: var(--moss); }
    .pay-method.is-active {
        border-color: var(--moss);
        background: linear-gradient(180deg, #fffef8, #f4ecd2);
        box-shadow: 0 4px 14px rgba(74,124,74,0.18);
    }
    .pay-method.is-active::after {
        content: '✓';
        position: absolute; top: 8px; right: 8px;
        width: 18px; height: 18px;
        border-radius: 50%;
        background: var(--moss); color: #fff;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700;
    }
    .pay-method-icon {
        width: 32px; height: 32px;
        border-radius: 8px;
        background: rgba(74,124,74,0.10);
        color: var(--moss);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 17px;
        margin-bottom: 8px;
    }
    .pay-method-title {
        font-size: 13.5px; font-weight: 700; color: var(--ink);
        margin-bottom: 3px;
    }
    .pay-method-desc {
        font-size: 11.5px; color: var(--ink-muted);
        line-height: 1.4;
    }
    .pay-method.is-disabled {
        opacity: 0.55;
        cursor: not-allowed;
        background: #f8f6ee;
    }
    .pay-method.is-disabled:hover { border-color: var(--line-md); }
    .pay-method-lock {
        position: absolute;
        top: 8px; right: 8px;
        background: rgba(184,54,76,0.10);
        color: #b8364c;
        font-size: 9.5px; font-weight: 700;
        padding: 3px 8px;
        border-radius: 999px;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }
    .pay-method-note {
        margin-top: 8px;
        font-size: 11px;
        color: #b8364c;
        font-weight: 600;
        line-height: 1.4;
    }

    /* ── E-WALLET PICKER ── */
    .ewallet-picker {
        margin: 0 22px 18px;
        padding: 14px 16px;
        border-radius: 12px;
        background: var(--parchment);
        border: 1px solid var(--line-md);
        display: none;
    }
    .ewallet-picker.is-show { display: block; }
    .ewallet-picker-label {
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--ink-soft);
        margin-bottom: 10px;
    }
    .ewallet-options {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }
    .ewallet-option {
        position: relative;
        background: #fff;
        border: 1.5px solid var(--line-md);
        border-radius: 10px;
        padding: 12px 12px;
        cursor: pointer;
        transition: all 0.18s;
        display: flex; flex-direction: column; align-items: center; gap: 6px;
    }
    .ewallet-option input { position: absolute; opacity: 0; pointer-events: none; }
    .ewallet-option:hover { border-color: var(--moss); }
    .ewallet-option.is-active {
        border-color: var(--moss);
        background: linear-gradient(180deg, #fffef8, #f4ecd2);
        box-shadow: 0 4px 12px rgba(74,124,74,0.18);
    }
    .ewallet-option.is-active::after {
        content: '✓';
        position: absolute; top: 6px; right: 6px;
        width: 16px; height: 16px;
        border-radius: 50%;
        background: var(--moss); color: #fff;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 10px; font-weight: 700;
    }
    .ewallet-logo {
        width: 38px; height: 38px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800;
        font-size: 13px;
        letter-spacing: 0.02em;
        color: #fff;
    }
    .ewallet-logo.dana { background: #118EEA; }
    .ewallet-logo.ovo  { background: #4C2A86; }
    .ewallet-logo.gopay { background: #00AED6; }
    .ewallet-logo.bni  { background: #E87722; }
    .ewallet-logo.bri  { background: #00529C; }
    .ewallet-logo.bca  { background: #0066AE; }
    .ewallet-logo.jnt  { background: #D8232A; }
    .ewallet-logo.jne_reguler { background: #1E4598; }
    .ewallet-logo.spx_standar { background: #F65A28; }
    .ewallet-name {
        font-size: 12.5px;
        font-weight: 700;
        color: var(--ink);
    }

    /* ── PROGRESS STEPPER ── */
    .pay-stepper {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 18px 0 22px;
        padding: 14px 18px;
        background: var(--cream);
        border: 1px solid var(--line-md);
        border-radius: var(--r-md);
    }
    .pay-step {
        display: flex; align-items: center; gap: 10px;
        flex-shrink: 0;
    }
    .pay-step-num {
        width: 26px; height: 26px;
        border-radius: 50%;
        background: var(--parchment3);
        color: var(--ink-muted);
        font-size: 12px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-family: 'DM Serif Display', serif;
    }
    .pay-step.is-done .pay-step-num {
        background: var(--moss);
        color: #fff;
    }
    .pay-step.is-active .pay-step-num {
        background: var(--gold);
        color: #fff;
        box-shadow: 0 0 0 4px rgba(200,146,42,0.18);
    }
    .pay-step-label {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--ink-muted);
        white-space: nowrap;
    }
    .pay-step.is-done .pay-step-label,
    .pay-step.is-active .pay-step-label {
        color: var(--ink);
    }
    .pay-step-line {
        flex: 1;
        height: 2px;
        background: var(--parchment3);
        border-radius: 2px;
        min-width: 16px;
    }
    .pay-step-line.is-done {
        background: var(--moss);
    }

    /* ── LAYOUT 2 KOLOM (desktop) ── */
    .pay-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 360px;
        gap: 22px;
        align-items: start;
    }
    .pay-main { min-width: 0; }
    .pay-aside {
        position: sticky;
        top: 86px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    /* ── SIDEBAR SUMMARY ── */
    .pay-summary-card {
        background: var(--cream);
        border: 1px solid var(--line-md);
        border-radius: var(--r-md);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .pay-summary-card-head {
        padding: 14px 18px;
        background: linear-gradient(180deg, var(--parchment2), var(--cream));
        border-bottom: 1px solid var(--line);
        display: flex; align-items: center; gap: 10px;
    }
    .pay-summary-card-head h3 {
        margin: 0;
        font-family: 'DM Serif Display', serif;
        font-size: 16px;
        color: var(--ink);
        letter-spacing: -.01em;
        font-weight: 500;
    }
    .pay-summary-card-body { padding: 16px 18px; }
    .pay-summary-line {
        display: flex; justify-content: space-between; align-items: baseline;
        font-size: 13px;
        color: var(--ink-soft);
        padding: 6px 0;
    }
    .pay-summary-line strong { color: var(--ink); font-weight: 600; }
    .pay-summary-line.is-divider {
        margin-top: 6px;
        padding-top: 12px;
        border-top: 1px dashed var(--line-md);
    }
    .pay-summary-line.is-grand {
        font-size: 14px;
        padding-top: 14px;
        margin-top: 8px;
        border-top: 1px solid var(--line-md);
    }
    .pay-summary-line.is-grand .pay-grand {
        font-family: 'DM Serif Display', serif;
        font-size: 26px;
        color: var(--moss);
        font-weight: 500;
        letter-spacing: -.025em;
        line-height: 1;
    }
    .pay-summary-line.is-grand .pay-grand small {
        font-family: 'DM Sans', sans-serif;
        font-size: 12px; color: var(--ink-muted);
        font-weight: 500; margin-right: 3px;
    }

    .pay-aside-cta {
        display: inline-flex;
        align-items: center; justify-content: center; gap: 10px;
        height: 52px;
        border: none;
        border-radius: 999px;
        background: linear-gradient(135deg, var(--gold-pale), #f5d68a);
        color: var(--ink);
        font-family: 'DM Sans', sans-serif;
        font-size: 14.5px; font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 6px 18px rgba(200,146,42,0.35);
        white-space: nowrap;
    }
    .pay-aside-cta:hover {
        background: linear-gradient(135deg, #f0d070, #e8c860);
        transform: translateY(-1px);
        box-shadow: 0 10px 24px rgba(200,146,42,0.45);
    }
    .pay-aside-trust {
        display: grid;
        gap: 8px;
        padding: 12px 14px;
        background: var(--parchment);
        border: 1px solid var(--line-md);
        border-radius: var(--r-sm);
        font-size: 12px;
        color: var(--ink-soft);
    }
    .pay-aside-trust .row {
        display: flex; align-items: center; gap: 8px;
    }
    .pay-aside-trust .row .ic {
        width: 18px; height: 18px;
        border-radius: 50%;
        background: rgba(74,124,74,0.12);
        color: var(--moss);
        display: flex; align-items: center; justify-content: center;
        font-size: 11px;
        flex-shrink: 0;
    }

    /* ── METHOD: badges & info ── */
    .pay-method-badge {
        position: absolute;
        top: 8px; right: 8px;
        background: var(--moss);
        color: #fff;
        font-size: 9.5px; font-weight: 700;
        padding: 3px 8px;
        border-radius: 999px;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }
    .pay-method-badge.gold { background: var(--gold); }
    .pay-method.is-active .pay-method-badge {
        box-shadow: 0 2px 6px rgba(0,0,0,0.18);
    }

    /* ── VA banner: tombol salin ── */
    .va-info-card {
        margin: 16px 22px 18px;
        padding: 14px 16px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--gold-pale), #fdf2cc);
        border: 1px solid rgba(200,146,42,0.32);
        display: none;
    }
    .va-info-card.is-show { display: block; }
    .va-info-head {
        display: flex; align-items: center; gap: 10px;
        margin-bottom: 10px;
    }
    .va-info-icon {
        width: 32px; height: 32px;
        border-radius: 8px;
        background: rgba(255,255,255,0.7);
        display: flex; align-items: center; justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .va-info-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #6f520f;
    }
    .va-info-row {
        display: flex; align-items: center; gap: 10px;
        background: rgba(255,255,255,0.65);
        border-radius: 10px;
        padding: 10px 12px;
        font-size: 14px;
        color: var(--ink);
    }
    .va-info-number {
        font-family: 'DM Sans', monospace;
        font-weight: 700;
        font-size: 16px;
        letter-spacing: 0.04em;
        color: var(--ink);
        flex: 1;
        word-break: break-all;
    }
    .va-info-name {
        font-size: 12px;
        color: var(--ink-soft);
        margin-top: 4px;
    }
    .va-copy-btn {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--ink);
        color: var(--cream);
        border: none;
        border-radius: 8px;
        padding: 7px 12px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.18s, transform 0.18s;
        flex-shrink: 0;
    }
    .va-copy-btn:hover { background: var(--moss); transform: translateY(-1px); }
    .va-copy-btn.is-copied { background: var(--moss); }
    .va-info-steps {
        margin: 10px 0 0;
        padding-left: 18px;
        font-size: 12.5px;
        color: var(--ink-soft);
        line-height: 1.6;
    }
    .va-info-steps li { margin-bottom: 3px; }

    /* sembunyikan summary bar bawah di desktop (sudah ada di sidebar) */
    @media (min-width: 921px) {
        .pay-summary-bar { display: none !important; }
        .pay-wrap { padding-bottom: 60px !important; }
    }

    .pay-info-banner {
        margin: 0 22px 18px;
        padding: 12px 14px;
        border-radius: 10px;
        background: var(--gold-pale);
        border: 1px solid rgba(200,146,42,0.32);
        color: #6f520f;
        font-size: 12.5px;
        line-height: 1.5;
        display: none;
    }
    .pay-info-banner.is-show { display: flex; align-items: flex-start; gap: 10px; }
    .pay-info-banner .ic { flex-shrink: 0; font-size: 16px; }
    .pay-info-banner strong { color: #5a420c; }

    /* ── SUMMARY (sticky bottom bar Shopee-style) ── */
    .pay-summary-bar {
        position: fixed;
        bottom: 16px;
        left: 50%;
        transform: translateX(-50%);
        width: calc(100% - 32px);
        max-width: 1100px;
        background: var(--cream);
        border: 1px solid var(--line-md);
        border-radius: var(--r-md);
        padding: 16px 24px;
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 22px;
        align-items: center;
        box-shadow: var(--shadow-bar);
        z-index: 25;
    }
    .pay-summary-rows {
        display: flex; flex-direction: column; gap: 4px;
    }
    .pay-summary-row {
        display: flex; align-items: center; gap: 10px;
        font-size: 12.5px;
    }
    .pay-summary-row .lbl { color: var(--ink-muted); }
    .pay-summary-row .val { color: var(--ink); font-weight: 500; }
    .pay-summary-row.is-total .lbl { color: var(--ink-soft); font-weight: 600; }
    .pay-summary-row.is-total .val {
        font-family: 'DM Serif Display', serif;
        font-size: 22px; color: var(--moss); font-weight: 500; letter-spacing: -.025em;
    }
    .pay-summary-row.is-total .val small {
        font-family: 'DM Sans', sans-serif;
        font-size: 12px; color: var(--ink-muted); font-weight: 500;
        margin-right: 3px;
    }

    .pay-btn-buy {
        display: inline-flex; align-items: center; justify-content: center; gap: 10px;
        height: 50px; padding: 0 36px;
        border-radius: 999px; border: none;
        background: linear-gradient(135deg, var(--gold-pale), #f5d68a);
        color: var(--ink);
        font-family: 'DM Sans', sans-serif;
        font-size: 14.5px; font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 16px rgba(200,146,42,0.32);
        white-space: nowrap;
    }
    .pay-btn-buy:hover {
        background: linear-gradient(135deg, #f0d070, #e8c860);
        transform: translateY(-1px);
        box-shadow: 0 8px 22px rgba(200,146,42,0.42);
    }

    .pay-btn-ghost {
        display: inline-flex; align-items: center; justify-content: center;
        gap: 6px;
        padding: 9px 18px;
        border-radius: var(--r-sm);
        border: 1px solid var(--line-md);
        background: var(--cream);
        font-size: 12.5px; font-weight: 600;
        color: var(--ink-soft);
        text-decoration: none;
        cursor: pointer;
        transition: all 0.18s;
    }
    .pay-btn-ghost:hover { background: var(--moss-pale); border-color: var(--moss); color: var(--moss); }

    /* ── RESPONSIVE ── */
    @media (max-width: 920px) {
        .pay-method-grid { grid-template-columns: repeat(2, 1fr); }
        .pay-address-body { grid-template-columns: 1fr; gap: 14px; }
        .pay-form-grid { grid-template-columns: 1fr; }
        .pay-items-table thead { display: none; }
        .pay-items-table tbody td { display: block; padding: 8px 22px; border-bottom: none; }
        .pay-items-table tbody td:first-child { padding-top: 16px; }
        .pay-items-table tbody td:last-child { padding-bottom: 16px; border-bottom: 1px solid var(--line); }
        .pay-items-table tbody td[data-label]::before {
            content: attr(data-label);
            display: block; font-size: 11px; color: var(--ink-muted); font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.06em;
            margin-bottom: 3px;
        }
    }
    @media (max-width: 680px) {
        .pay-wrap { padding: 18px 14px 160px; }
        .pay-summary-bar { grid-template-columns: 1fr; gap: 14px; padding: 14px 18px; }
        .pay-btn-buy { width: 100%; }
        .pay-method-grid { grid-template-columns: 1fr; }
        .pay-topbar-title { display: none; }
    }
</style>

<script>
    document.body.classList.add('user-payment-page');

    document.addEventListener('DOMContentLoaded', function () {
        // ── Method tab (COD / E-wallet) + provider picker ──
        const tabInputs = document.querySelectorAll('input[name="pay_tab"]');
        const tabLabels = document.querySelectorAll('.pay-method[data-method]');
        const providerInputs = document.querySelectorAll('input[name="ewallet_provider"]');
        const providerLabels = document.querySelectorAll('.ewallet-option[data-provider]');
        const bankInputs = document.querySelectorAll('input[name="bank_provider"]');
        const bankLabels = document.querySelectorAll('.ewallet-option[data-bank]');
        const courierInputs = document.querySelectorAll('input[name="kurir"]');
        const courierLabels = document.querySelectorAll('.ewallet-option[data-courier]');
        const ewalletPicker = document.getElementById('ewalletPicker');
        const bankPicker = document.getElementById('bankPicker');
        const payMetode = document.getElementById('payMetode');

        // VA info card (premium)
        const vaCard       = document.getElementById('vaInfoCard');
        const vaIcon       = document.getElementById('vaInfoIcon');
        const vaTitle      = document.getElementById('vaInfoTitle');
        const vaNumber     = document.getElementById('vaInfoNumber');
        const vaCopyBtn    = document.getElementById('vaCopyBtn');

        // VA dummy per provider (hardcoded untuk demo).
        const vaInfo = {
            'va_dana':  { title: 'Virtual Account DANA',  number: '008812345678901', icon: '💙' },
            'va_ovo':   { title: 'Virtual Account OVO',   number: '006612345678901', icon: '💜' },
            'va_gopay': { title: 'Virtual Account GoPay', number: '007712345678901', icon: '💎' },
            'bank_bni': { title: 'Virtual Account BNI',   number: '988008812345678', icon: '🏦' },
            'bank_bri': { title: 'Virtual Account BRI',   number: '262108812345678', icon: '🏦' },
            'bank_bca': { title: 'Virtual Account BCA',   number: '120108812345678', icon: '🏦' },
        };

        function getCurrentTab() {
            const sel = document.querySelector('input[name="pay_tab"]:checked');
            return sel ? sel.value : 'cod';
        }

        function getCurrentProvider() {
            const sel = document.querySelector('input[name="ewallet_provider"]:checked');
            return sel ? sel.value : 'va_dana';
        }

        function getCurrentBank() {
            const sel = document.querySelector('input[name="bank_provider"]:checked');
            return sel ? sel.value : 'bank_bni';
        }

        function refresh() {
            const tab = getCurrentTab();

            tabLabels.forEach(el => el.classList.toggle('is-active', el.dataset.method === tab));

            // sembunyikan semua picker dulu
            ewalletPicker.classList.remove('is-show');
            if (bankPicker) bankPicker.classList.remove('is-show');

            let selected = 'cod';

            if (tab === 'ewallet') {
                ewalletPicker.classList.add('is-show');
                selected = getCurrentProvider();
                providerLabels.forEach(el => el.classList.toggle('is-active', el.dataset.provider === selected));
            } else if (tab === 'bank') {
                if (bankPicker) bankPicker.classList.add('is-show');
                selected = getCurrentBank();
                bankLabels.forEach(el => el.classList.toggle('is-active', el.dataset.bank === selected));
            }

            payMetode.value = selected;

            const info = vaInfo[selected];
            if (tab !== 'cod' && info && vaCard) {
                vaCard.classList.add('is-show');
                if (vaIcon)   vaIcon.textContent   = info.icon;
                if (vaTitle)  vaTitle.textContent  = info.title;
                if (vaNumber) vaNumber.textContent = info.number;
                if (vaCopyBtn) {
                    vaCopyBtn.classList.remove('is-copied');
                    const lbl = vaCopyBtn.querySelector('.lbl');
                    if (lbl) lbl.textContent = 'Salin';
                }
            } else if (vaCard) {
                vaCard.classList.remove('is-show');
            }
        }

        tabInputs.forEach(i => i.addEventListener('change', refresh));
        providerInputs.forEach(i => i.addEventListener('change', refresh));
        bankInputs.forEach(i => i.addEventListener('change', refresh));
        courierLabels.forEach(el => {
            const input = el.querySelector('input[name="kurir"]');
            if (input) input.addEventListener('change', () => {
                courierLabels.forEach(c => c.classList.toggle('is-active', c.dataset.courier === input.value));
                updateOngkir(el);
            });
        });
        refresh();

        // ── Ringkasan ongkir & total bayar ──
        const summaryOngkir = document.getElementById('summaryOngkir');
        const summaryGrand  = document.getElementById('summaryGrand');
        const stickyGrand   = document.getElementById('stickyGrand');
        const subtotalEl    = document.querySelector('[data-subtotal]');
        const subtotal      = subtotalEl ? parseInt(subtotalEl.dataset.subtotal, 10) || 0 : 0;
        const fmt = n => 'Rp ' + n.toLocaleString('id-ID');

        function updateOngkir(label) {
            if (!summaryOngkir) return;
            const isFree = summaryOngkir.dataset.free === '1';
            const ongkir = isFree ? 0 : (parseInt(label?.dataset.ongkir, 10) || 0);
            summaryOngkir.textContent = (isFree || ongkir === 0) ? 'Gratis' : fmt(ongkir);
            const grand = subtotal + ongkir;
            if (summaryGrand) summaryGrand.innerHTML = '<small>Rp</small>' + grand.toLocaleString('id-ID');
            if (stickyGrand)  stickyGrand.innerHTML  = '<small>Rp</small>' + grand.toLocaleString('id-ID');
        }
        // sinkron dengan kurir yang aktif saat load
        const activeCourier = document.querySelector('.ewallet-option[data-courier].is-active')
            || document.querySelector('.ewallet-option[data-courier]');
        if (activeCourier) updateOngkir(activeCourier);

        // Tombol salin nomor VA
        if (vaCopyBtn) {
            vaCopyBtn.addEventListener('click', () => {
                const text = (vaNumber?.textContent || '').replace(/\s+/g, '');
                if (!text) return;
                const setCopied = () => {
                    vaCopyBtn.classList.add('is-copied');
                    const lbl = vaCopyBtn.querySelector('.lbl');
                    if (lbl) lbl.textContent = 'Tersalin';
                    setTimeout(() => {
                        vaCopyBtn.classList.remove('is-copied');
                        if (lbl) lbl.textContent = 'Salin';
                    }, 1800);
                };
                if (navigator.clipboard?.writeText) {
                    navigator.clipboard.writeText(text).then(setCopied).catch(() => {
                        // fallback
                        const ta = document.createElement('textarea');
                        ta.value = text; document.body.appendChild(ta);
                        ta.select(); document.execCommand('copy'); ta.remove();
                        setCopied();
                    });
                } else {
                    const ta = document.createElement('textarea');
                    ta.value = text; document.body.appendChild(ta);
                    ta.select(); document.execCommand('copy'); ta.remove();
                    setCopied();
                }
            });
        }

        // toggle alamat form
        const addrEdit = document.getElementById('addrEditBtn');
        const addrForm = document.getElementById('addrForm');
        const addrCancel = document.getElementById('addrCancel');

        const editIconHtml = '<svg width="13" height="13" viewBox="0 0 13 13" fill="none" aria-hidden="true"><path d="M9 1.5l2.5 2.5L4 11.5H1.5V9L9 1.5z" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg> Ubah Alamat';
        const closeIconHtml = '<svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true"><path d="M3 3l6 6M9 3l-6 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg> Tutup';

        if (addrEdit && addrForm) {
            addrEdit.addEventListener('click', e => {
                e.preventDefault();
                const isOpen = addrForm.classList.toggle('is-open');
                addrEdit.innerHTML = isOpen ? closeIconHtml : editIconHtml;
            });
        }
        if (addrCancel && addrForm) {
            addrCancel.addEventListener('click', e => {
                e.preventDefault();
                addrForm.classList.remove('is-open');
                if (addrEdit) addrEdit.innerHTML = editIconHtml;
            });
        }

        // auto-open form kalau ada error validasi alamat
        @if($errors->has('penerima_nama') || $errors->has('alamat_lengkap') || $errors->has('nomor_telepon'))
            if (addrForm) addrForm.classList.add('is-open');
            if (addrEdit) addrEdit.innerHTML = closeIconHtml;
        @endif

        // auto-open form alamat kalau salah satu field utama masih kosong
        const addrFields = ['penerima_nama','alamat_lengkap','nomor_telepon'];
        const addrEmpty = addrFields.some(id => {
            const el = document.getElementById(id);
            return !el || !el.value.trim();
        });
        if (addrEmpty && addrForm && !addrForm.classList.contains('is-open')) {
            addrForm.classList.add('is-open');
            if (addrEdit) addrEdit.innerHTML = closeIconHtml;
        }

        // Client-side guard: kalau user klik "Buat Pesanan" tapi alamat belum lengkap,
        // buka form, fokus ke field kosong pertama, dan beri pesan ringkas.
        const payForm = document.getElementById('payForm');
        if (payForm) {
            payForm.addEventListener('submit', function (e) {
                const empties = addrFields
                    .map(id => document.getElementById(id))
                    .filter(el => el && !el.value.trim());
                if (empties.length === 0) return;

                e.preventDefault();
                if (addrForm) addrForm.classList.add('is-open');
                if (addrEdit) addrEdit.innerHTML = closeIconHtml;
                empties[0].classList.add('is-error');
                empties[0].focus();
                empties[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                alert('Lengkapi alamat pengiriman dulu sebelum membuat pesanan.');
            });
        }
    });
</script>

<div class="pay-page">

    {{-- TOPBAR --}}
    <div class="pay-topbar">
        <div class="pay-topbar-inner">
            <a href="{{ $backUrl ?? route('carts.index') }}" class="pay-back">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M9 2L4 7l5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Kembali
            </a>
            <span class="pay-topbar-title">Checkout</span>
            @unless($isDraftCheckout)
            <span class="pay-step-pill">{{ 'Order #' . sprintf('%04d', $order->id) }}</span>
            @endunless
        </div>
    </div>

    <div class="pay-wrap">

        {{-- HEAD --}}
        <div class="pay-head">
            <div class="pay-eyebrow">Langkah terakhir</div>
            <h1 class="pay-title">Selesaikan <em>pembelianmu</em></h1>
            <p class="pay-sub">
                Periksa kembali alamat pengiriman, daftar produk, dan pilih metode pembayaran.
                Setelah klik <strong>Buat Pesanan</strong>, pesananmu langsung kami proses.
            </p>
        </div>

        {{-- STEPPER --}}
        <div class="pay-stepper">
            <div class="pay-step is-done">
                <div class="pay-step-num">✓</div>
                <div class="pay-step-label">Keranjang</div>
            </div>
            <div class="pay-step-line is-done"></div>
            <div class="pay-step is-active">
                <div class="pay-step-num">2</div>
                <div class="pay-step-label">Alamat &amp; Pembayaran</div>
            </div>
            <div class="pay-step-line"></div>
            <div class="pay-step">
                <div class="pay-step-num">3</div>
                <div class="pay-step-label">Selesai</div>
            </div>
        </div>

        @if ($errors->any())
            <div class="pay-alert">{{ $errors->first() }}</div>
        @endif

        <div class="pay-layout">
            <div class="pay-main">
        <form action="{{ route('payments.store') }}" method="POST" id="payForm">
            @csrf
            @if (! $isDraftCheckout)
                <input type="hidden" name="order_id" value="{{ $order->id }}">
            @endif

            {{-- ════ ALAMAT ════ --}}
            <div class="pay-address-card">
                <div class="pay-address-head">
                    <div class="pay-address-icon">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M7 1.5C4.79 1.5 3 3.29 3 5.5c0 3 4 7 4 7s4-4 4-7c0-2.21-1.79-4-4-4z" stroke="currentColor" stroke-width="1.4"/>
                            <circle cx="7" cy="5.5" r="1.4" stroke="currentColor" stroke-width="1.4"/>
                        </svg>
                    </div>
                    <div class="pay-address-title">Alamat Pengiriman</div>
                </div>

                <div class="pay-address-body">
                    @php
                        $alm = old('alamat_lengkap', $order->alamat_lengkap ?? '');
                        $nm  = old('penerima_nama', $order->penerima_nama ?? $order->user?->name ?? '');
                        $hp  = old('nomor_telepon', $order->nomor_telepon ?? '');
                        $addressComplete = $alm && $nm && $hp;
                    @endphp
                    <div class="pay-receiver">
                        @if ($addressComplete)
                            <span class="pay-address-default">Alamat utama</span>
                        @else
                            <span class="pay-address-default" style="background:rgba(200,146,42,0.12);color:#a06d12;">Perlu dilengkapi</span>
                        @endif
                        <div class="pay-receiver-name">{{ $nm ?: 'Pelanggan' }}</div>
                        <div class="pay-receiver-phone">{{ $hp ?: '—' }}</div>
                    </div>
                    <div class="pay-address-text">
                        @if ($alm)
                            {{ $alm }}
                            @unless ($addressComplete)
                                <div style="margin-top:6px;font-size:12px;color:#a06d12;">Lengkapi nama penerima dan nomor telepon lewat tombol di samping.</div>
                            @endunless
                        @else
                            Alamat belum diisi. Klik <strong>Ubah Alamat</strong> di samping untuk menambahkan alamat pengiriman.
                        @endif
                    </div>
                    <a href="#" id="addrEditBtn" class="pay-address-edit">
                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none" aria-hidden="true">
                            <path d="M9 1.5l2.5 2.5L4 11.5H1.5V9L9 1.5z" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Ubah Alamat
                    </a>
                </div>

                {{-- form ubah alamat --}}
                <div class="pay-address-form" id="addrForm">
                    <div class="pay-form-grid">
                        <div>
                            <label class="pay-label" for="penerima_nama">Nama Penerima <span style="color:#d1546a;">*</span></label>
                            <input type="text" id="penerima_nama" name="penerima_nama"
                                   class="pay-input @error('penerima_nama') is-error @enderror"
                                   value="{{ old('penerima_nama', $order->penerima_nama ?? $order->user?->name ?? '') }}"
                                   placeholder="Contoh: Siti Aminah">
                            <div class="pay-hint">Nama lengkap orang yang menerima paket.</div>
                            @error('penerima_nama')<div class="pay-error">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="pay-label" for="nomor_telepon">No. HP / Telepon <span style="color:#d1546a;">*</span></label>
                            <input type="tel" id="nomor_telepon" name="nomor_telepon"
                                   class="pay-input @error('nomor_telepon') is-error @enderror"
                                   value="{{ old('nomor_telepon', $order->nomor_telepon ?? '') }}"
                                   placeholder="Contoh: 081234567890" minlength="10" maxlength="20">
                            <div class="pay-hint">Untuk dihubungi kurir saat pengiriman.</div>
                            @error('nomor_telepon')<div class="pay-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="full">
                            <label class="pay-label" for="alamat_lengkap">Alamat Lengkap <span style="color:#d1546a;">*</span></label>
                            <textarea id="alamat_lengkap" name="alamat_lengkap"
                                      class="pay-textarea @error('alamat_lengkap') is-error @enderror"
                                      rows="3" placeholder="Jalan, nomor rumah, RT/RW, kelurahan, kecamatan, kota">{{ old('alamat_lengkap', $order->alamat_lengkap ?? '') }}</textarea>
                            <div class="pay-hint">Tulis sedetail mungkin agar paket tidak salah kirim.</div>
                            @error('alamat_lengkap')<div class="pay-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="pay-form-actions">
                            <button type="button" class="pay-btn-ghost" id="addrCancel">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ════ ITEMS / SHOP ════ --}}
            @if ($cartItems->count())
                <div class="pay-card">
                    @php
                        $firstItem = $cartItems->first(fn($i) => $i->product && $i->product->umkm);
                        $shopName = $firstItem?->product?->umkm?->nama_umkm ?? 'Toko UMKM';
                        $shopTotal = $cartItems->sum(fn($i) => $i->product->harga * $i->qty);
                    @endphp
                    <div class="pay-card-head">
                        <span class="pay-shop-tag">★ Pilihan</span>
                        <span class="pay-shop-name">{{ $shopName }}</span>
                        <span style="margin-left:auto;font-size:11.5px;color:var(--ink-muted);">UMKM resmi</span>
                    </div>

                    <table class="pay-items-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="t-right">Harga</th>
                                <th class="t-center">Jumlah</th>
                                <th class="t-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $item)
                                <tr>
                                    <td data-label="Produk">
                                        <div class="pay-item-info">
                                            <div class="pay-item-img">
                                                @if ($item->product->gambar)
                                                    <img src="{{ asset('storage/' . $item->product->gambar) }}" alt="{{ $item->product->nama_produk }}">
                                                @else
                                                    <div class="ph">No Image</div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="pay-item-name">{{ $item->product->nama_produk }}</div>
                                                <div class="pay-item-meta">Stok tersedia: {{ $item->product->stok }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Harga" style="text-align:right;">
                                        <span class="pay-item-price">Rp {{ number_format($item->product->harga, 0, ',', '.') }}</span>
                                    </td>
                                    <td data-label="Jumlah" style="text-align:center;">
                                        <span class="pay-item-qty">×{{ $item->qty }}</span>
                                    </td>
                                    <td data-label="Subtotal" style="text-align:right;">
                                        <span class="pay-item-subtotal">Rp {{ number_format($item->product->harga * $item->qty, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pay-shop-total">
                        <span>Total Pesanan ({{ $cartItems->sum('qty') }} produk):</span>
                        <strong>Rp {{ number_format($shopTotal, 0, ',', '.') }}</strong>
                    </div>
                </div>
            @elseif (! $isDraftCheckout && $order->orderDetails)
                {{-- existing order: tampilkan order details --}}
                <div class="pay-card">
                    <div class="pay-card-head">
                        <span class="pay-shop-tag">Order</span>
                        <span class="pay-shop-name">Detail Pesanan #{{ sprintf('%04d', $order->id) }}</span>
                    </div>
                    <table class="pay-items-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="t-right">Harga</th>
                                <th class="t-center">Jumlah</th>
                                <th class="t-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderDetails as $detail)
                                <tr>
                                    <td data-label="Produk">
                                        <div class="pay-item-info">
                                            <div class="pay-item-img">
                                                @if ($detail->product?->gambar)
                                                    <img src="{{ asset('storage/' . $detail->product->gambar) }}" alt="{{ $detail->product->nama_produk }}">
                                                @else
                                                    <div class="ph">No Image</div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="pay-item-name">{{ $detail->product?->nama_produk ?? 'Produk' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Harga" style="text-align:right;">
                                        <span class="pay-item-price">Rp {{ number_format($detail->harga, 0, ',', '.') }}</span>
                                    </td>
                                    <td data-label="Jumlah" style="text-align:center;">
                                        <span class="pay-item-qty">×{{ $detail->qty }}</span>
                                    </td>
                                    <td data-label="Subtotal" style="text-align:right;">
                                        <span class="pay-item-subtotal">Rp {{ number_format($detail->harga * $detail->qty, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- ════ PENGIRIMAN / KURIR ════ --}}
            @php
                $courierList = $couriers ?? [];
                $freeShip = $freeShipping ?? false;
                $oldKurir = old('kurir', array_key_first($courierList) ?: 'jnt');
            @endphp
            <div class="pay-card">
                <div class="pay-card-head">
                    <span class="pay-shop-tag" style="background:rgba(74,124,74,0.10);color:var(--moss);">Kurir</span>
                    <span class="pay-shop-name">Pilih Pengiriman</span>
                </div>

                @if ($freeShip)
                    <div style="margin:14px 22px 0;padding:11px 14px;border-radius:10px;background:rgba(74,124,74,0.10);border:1px solid rgba(74,124,74,0.25);color:var(--moss);font-size:12.5px;font-weight:600;">
                        🎉 Selamat! Pesananmu {{ $totalQty ?? 0 }} pcs &mdash; gratis ongkir untuk semua kurir.
                    </div>
                @else
                    <div style="margin:14px 22px 0;padding:11px 14px;border-radius:10px;background:rgba(200,146,42,0.12);border:1px solid rgba(200,146,42,0.3);color:#a06d12;font-size:12.5px;font-weight:600;">
                        Beli minimal {{ $freeShippingMinQty ?? 5 }} pcs untuk gratis ongkir. Saat ini: {{ $totalQty ?? 0 }} pcs.
                    </div>
                @endif

                <div class="ewallet-picker is-show" style="margin-top:14px;">
                    <div class="ewallet-picker-label">Pilih Kurir</div>
                    <div class="ewallet-options">
                        @foreach ($courierList as $key => $courier)
                            <label class="ewallet-option {{ $oldKurir === $key ? 'is-active' : '' }}" data-courier="{{ $key }}" data-ongkir="{{ $freeShip ? 0 : $courier['ongkir'] }}">
                                <input type="radio" name="kurir" value="{{ $key }}" {{ $oldKurir === $key ? 'checked' : '' }}>
                                <div class="ewallet-logo {{ $key }}" style="font-size:10px;">{{ strtoupper(substr($courier['label'], 0, 3)) }}</div>
                                <div class="ewallet-name">{{ $courier['label'] }}</div>
                                <div style="font-size:11px;color:var(--ink-muted);font-weight:600;">
                                    {{ $freeShip ? 'Gratis' : 'Rp ' . number_format($courier['ongkir'], 0, ',', '.') }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('kurir')<div class="pay-error" style="margin-top:8px;">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- ════ METODE PEMBAYARAN ════ --}}
            <div class="pay-card">
                <div class="pay-card-head">
                    <span class="pay-shop-tag" style="background:rgba(74,124,74,0.10);color:var(--moss);">Metode</span>
                    <span class="pay-shop-name">Pilih Pembayaran</span>
                </div>

                <div class="pay-method-grid" style="grid-template-columns: repeat(3, minmax(0, 1fr));">
                    @php
                        $oldMetode = old('metode');
                        $ewalletVals = ['va_dana','va_ovo','va_gopay'];
                        $bankVals    = ['bank_bni','bank_bri','bank_bca'];
                        $oldIsEwallet = in_array($oldMetode, $ewalletVals, true);
                        $oldIsBank    = in_array($oldMetode, $bankVals, true);

                        $oldEwalletProvider = $oldIsEwallet ? $oldMetode : 'va_dana';
                        $oldBankProvider    = $oldIsBank ? $oldMetode : 'bank_bni';

                        // Tab metode utama: cod / ewallet / bank
                        if ($oldMetode === 'cod') {
                            $selectedTab = 'cod';
                        } elseif ($oldIsEwallet) {
                            $selectedTab = 'ewallet';
                        } elseif ($oldIsBank) {
                            $selectedTab = 'bank';
                        } else {
                            $selectedTab = 'cod';
                        }

                        // Field "metode" yang sebenarnya disubmit:
                        if ($selectedTab === 'ewallet') {
                            $selectedMetode = $oldEwalletProvider;
                        } elseif ($selectedTab === 'bank') {
                            $selectedMetode = $oldBankProvider;
                        } else {
                            $selectedMetode = 'cod';
                        }
                    @endphp

                    <label class="pay-method {{ $selectedTab === 'cod' ? 'is-active' : '' }}" data-method="cod">
                        <input type="radio" name="pay_tab" value="cod" {{ $selectedTab === 'cod' ? 'checked' : '' }}>
                        <span class="pay-method-badge">Populer</span>
                        <div class="pay-method-icon">💵</div>
                        <div class="pay-method-title">Bayar di Tempat (COD)</div>
                        <div class="pay-method-desc">Bayar tunai saat paket diterima. Tanpa biaya tambahan.</div>
                    </label>

                    <label class="pay-method {{ $selectedTab === 'ewallet' ? 'is-active' : '' }}" data-method="ewallet">
                        <input type="radio" name="pay_tab" value="ewallet" {{ $selectedTab === 'ewallet' ? 'checked' : '' }}>
                        <span class="pay-method-badge gold">Instan</span>
                        <div class="pay-method-icon">📱</div>
                        <div class="pay-method-title">E-Wallet</div>
                        <div class="pay-method-desc">DANA, OVO, atau GoPay &mdash; pembayaran langsung tanpa tunggu.</div>
                    </label>

                    <label class="pay-method {{ $selectedTab === 'bank' ? 'is-active' : '' }}" data-method="bank">
                        <input type="radio" name="pay_tab" value="bank" {{ $selectedTab === 'bank' ? 'checked' : '' }}>
                        <span class="pay-method-badge gold">Transfer</span>
                        <div class="pay-method-icon">🏦</div>
                        <div class="pay-method-title">Transfer Bank</div>
                        <div class="pay-method-desc">BNI, BRI, atau BCA &mdash; transfer ke Virtual Account.</div>
                    </label>
                </div>

                {{-- Picker provider e-wallet (muncul kalau tab e-wallet dipilih) --}}
                <div class="ewallet-picker {{ $selectedTab === 'ewallet' ? 'is-show' : '' }}" id="ewalletPicker">
                    <div class="ewallet-picker-label">Pilih E-Wallet</div>
                    <div class="ewallet-options">
                        @foreach([
                            ['va_dana',  'dana',  'DANA',  'DANA'],
                            ['va_ovo',   'ovo',   'OVO',   'OVO'],
                            ['va_gopay', 'gopay', 'GoPay', 'GP'],
                        ] as [$value, $cls, $label, $logoText])
                            <label class="ewallet-option {{ $selectedMetode === $value ? 'is-active' : '' }}" data-provider="{{ $value }}">
                                <input type="radio" name="ewallet_provider" value="{{ $value }}" {{ $selectedMetode === $value ? 'checked' : '' }}>
                                <div class="ewallet-logo {{ $cls }}">{{ $logoText }}</div>
                                <div class="ewallet-name">{{ $label }}</div>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Picker bank (muncul kalau tab transfer bank dipilih) --}}
                <div class="ewallet-picker {{ $selectedTab === 'bank' ? 'is-show' : '' }}" id="bankPicker">
                    <div class="ewallet-picker-label">Pilih Bank</div>
                    <div class="ewallet-options">
                        @foreach([
                            ['bank_bni', 'bni', 'BNI', 'BNI'],
                            ['bank_bri', 'bri', 'BRI', 'BRI'],
                            ['bank_bca', 'bca', 'BCA', 'BCA'],
                        ] as [$value, $cls, $label, $logoText])
                            <label class="ewallet-option {{ $selectedMetode === $value ? 'is-active' : '' }}" data-bank="{{ $value }}">
                                <input type="radio" name="bank_provider" value="{{ $value }}" {{ $selectedMetode === $value ? 'checked' : '' }}>
                                <div class="ewallet-logo {{ $cls }}">{{ $logoText }}</div>
                                <div class="ewallet-name">{{ $label }}</div>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Hidden field "metode" yang sebenarnya disubmit ke backend.
                     Diupdate via JS sesuai pilihan tab dan provider. --}}
                <input type="hidden" name="metode" id="payMetode" value="{{ $selectedMetode }}">
                @error('metode')<div class="pay-error" style="padding:0 22px 14px;">{{ $message }}</div>@enderror

                <div id="payInfoBanner" class="pay-info-banner" style="display:none;">
                    <span class="ic">ℹ</span>
                    <div>
                        <div style="font-weight:700;color:#5a420c;font-size:12.5px;" id="payInfoLabel">Info</div>
                        <div id="payInfoValue" style="margin-top:2px;"></div>
                    </div>
                </div>

                {{-- VA info card (provider terpilih) --}}
                <div id="vaInfoCard" class="va-info-card">
                    <div class="va-info-head">
                        <div class="va-info-icon" id="vaInfoIcon">📱</div>
                        <div>
                            <div class="va-info-label" id="vaInfoTitle">Virtual Account</div>
                            <div style="font-size:12px;color:var(--ink-soft);margin-top:2px;">Bayar lewat aplikasi e-wallet pilihanmu</div>
                        </div>
                    </div>
                    <div class="va-info-row">
                        <div style="flex:1;">
                            <div class="va-info-number" id="vaInfoNumber">000000000000</div>
                            <div class="va-info-name">a.n. <strong>Rumah Rimpang</strong></div>
                        </div>
                        <button type="button" class="va-copy-btn" id="vaCopyBtn" data-target="vaInfoNumber">
                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" aria-hidden="true">
                                <rect x="3.5" y="1.5" width="7" height="9" rx="1.5" stroke="currentColor" stroke-width="1.4"/>
                                <path d="M2 4v7.5h6" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                            </svg>
                            <span class="lbl">Salin</span>
                        </button>
                    </div>
                    <ol class="va-info-steps">
                        <li>Buka aplikasi e-wallet (DANA / OVO / GoPay)</li>
                        <li>Pilih menu <strong>Bayar</strong> atau <strong>Top Up</strong> &rarr; <strong>Virtual Account</strong></li>
                        <li>Masukkan nomor di atas, lalu konfirmasi</li>
                    </ol>
                </div>
            </div>
        </form>
            </div>{{-- /.pay-main --}}

            {{-- SIDEBAR RINGKASAN --}}
            <aside class="pay-aside">
                @php
                    $asideTotal = $cartItems->count() ? $cartItems->sum(fn($i) => $i->product->harga * $i->qty) : ($order->total_harga ?? 0);
                    $asideQty   = $cartItems->count() ? (int) $cartItems->sum('qty') : (int) ($totalQty ?? 0);
                    $asideItems = $cartItems->count() ? $cartItems->count() : ($order->orderDetails?->count() ?? 0);
                    $shipFree   = $freeShipping ?? false;
                    $initialKurir = old('kurir', array_key_first($couriers ?? []) ?: 'jnt');
                    $initialOngkir = $shipFree ? 0 : (($couriers[$initialKurir]['ongkir']) ?? 0);
                @endphp

                <div class="pay-summary-card">
                    <div class="pay-summary-card-head">
                        <span style="font-size:18px;">🧾</span>
                        <h3>Ringkasan Pembayaran</h3>
                    </div>
                    <div class="pay-summary-card-body">
                        <div class="pay-summary-line">
                            <span>Subtotal ({{ $asideItems }} produk &middot; {{ $asideQty }} pcs)</span>
                            <strong data-subtotal="{{ $asideTotal }}">Rp {{ number_format($asideTotal, 0, ',', '.') }}</strong>
                        </div>
                        <div class="pay-summary-line">
                            <span>Ongkos kirim</span>
                            <strong id="summaryOngkir" data-free="{{ $shipFree ? '1' : '0' }}" style="color:var(--moss);">
                                {{ $shipFree ? 'Gratis' : 'Rp ' . number_format($initialOngkir, 0, ',', '.') }}
                            </strong>
                        </div>
                        <div class="pay-summary-line is-divider">
                            <span>Diskon</span>
                            <span>Rp 0</span>
                        </div>
                        <div class="pay-summary-line is-grand">
                            <span><strong>Total bayar</strong></span>
                            <span class="pay-grand" id="summaryGrand"><small>Rp</small>{{ number_format($asideTotal + $initialOngkir, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <button type="submit" form="payForm" class="pay-aside-cta">
                    Buat Pesanan
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>

                <div class="pay-aside-trust">
                    <div class="row"><span class="ic">✓</span> Pesananmu langsung kami proses begitu masuk.</div>
                    <div class="row"><span class="ic">✓</span> Data alamat &amp; kontak hanya untuk pengiriman.</div>
                    <div class="row"><span class="ic">✓</span> Stok &amp; nomor VA selalu yang terbaru.</div>
                </div>
            </aside>
        </div>{{-- /.pay-layout --}}
    </div>

    {{-- ════ STICKY SUMMARY BAR (Shopee bottom) ════ --}}
    <div class="pay-summary-bar">
        <div class="pay-summary-rows">
            @php $totalQty = $cartItems->sum('qty') ?: 1; @endphp
            <div class="pay-summary-row">
                <span class="lbl">Jumlah produk:</span>
                <span class="val">{{ $totalQty }} pcs</span>
            </div>
            <div class="pay-summary-row is-total">
                <span class="lbl">Total bayar:</span>
                <span class="val" id="stickyGrand"><small>Rp</small>{{ number_format(($order->total_harga ?? 0) + ($freeShipping ?? false ? 0 : (($couriers[old('kurir', array_key_first($couriers ?? []) ?: 'jnt')]['ongkir']) ?? 0)), 0, ',', '.') }}</span>
            </div>
        </div>
        <button type="submit" form="payForm" class="pay-btn-buy">
            Buat Pesanan
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
    </div>
</div>
@endsection
