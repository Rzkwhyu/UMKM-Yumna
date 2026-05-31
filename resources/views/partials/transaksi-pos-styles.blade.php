@once
<style>
    body.page-transaksi-pos .yumna-content {
        background: transparent;
        padding: 0;
    }

    .pos-page {
        flex: 1 1 auto;
        min-height: 0;
        height: 100%;
        position: relative;
        overflow: hidden;
        background-image: url('{{ asset('image/bckgrndyumna.jpeg') }}');
        background-size: cover;
        background-position: center;
    }

    .pos-page::before {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, 0.12);
        pointer-events: none;
    }

    .pos-main {
        position: relative;
        z-index: 1;
        height: 100%;
        display: flex;
        align-items: stretch;
        gap: 18px;
        padding: 18px 22px 22px;
        min-height: 0;
    }

    .pos-products {
        flex: 1 1 auto;
        min-width: 0;
        display: flex;
        flex-direction: column;
        min-height: 0;
    }

    .pos-alert {
        padding: 10px 14px;
        border-radius: 12px;
        font-size: 13px;
        margin-bottom: 12px;
        flex-shrink: 0;
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
    }

    .pos-product-list {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 12px;
        padding-right: 6px;
    }

    .pos-product-list::-webkit-scrollbar {
        width: 6px;
    }

    .pos-product-list::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.18);
        border-radius: 999px;
    }

    .pos-product {
        display: flex;
        align-items: center;
        gap: 16px;
        background: #fff;
        border-radius: 18px;
        padding: 14px 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.9);
    }

    .pos-product.is-hidden {
        display: none;
    }

    .pos-product.is-out-of-stock {
        opacity: 0.6;
    }

    .pos-product-thumb {
        width: 78px;
        height: 78px;
        border-radius: 14px;
        background: #f3f4f6;
        overflow: hidden;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
        font-size: 24px;
    }

    .pos-product-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .pos-product-info {
        flex: 1;
        min-width: 0;
    }

    .pos-product-info h3 {
        font-size: 17px;
        font-weight: 700;
        margin-bottom: 4px;
        color: #111827;
    }

    .pos-product-info .pos-kategori {
        font-size: 13px;
        color: #9ca3af;
        margin-bottom: 4px;
    }

    .pos-product-info .pos-harga {
        font-size: 15px;
        font-weight: 700;
        color: #374151;
    }

    .pos-qty-control {
        display: inline-flex;
        align-items: center;
        background: #8b7355;
        border-radius: 999px;
        overflow: hidden;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(139, 115, 85, 0.35);
    }

    .pos-qty-btn {
        width: 38px;
        height: 38px;
        border: none;
        background: transparent;
        color: #fff;
        font-size: 20px;
        font-weight: 700;
        cursor: pointer;
        line-height: 1;
    }

    .pos-qty-btn:disabled {
        opacity: 0.45;
        cursor: not-allowed;
    }

    .pos-qty-value {
        min-width: 30px;
        text-align: center;
        color: #fff;
        font-size: 15px;
        font-weight: 700;
    }

    .pos-cart {
        flex: 0 0 360px;
        width: 360px;
        max-width: 36%;
        background: rgba(255, 255, 255, 0.94);
        border-radius: 24px;
        padding: 22px 20px 20px;
        display: flex;
        flex-direction: column;
        color: #1f2937;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(6px);
        min-height: 0;
    }

    .pos-cart-head {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
        flex-shrink: 0;
    }

    .pos-cart-head h2 {
        font-size: 17px;
        font-weight: 700;
        color: #111827;
    }

    .pos-cart-head i {
        color: #6b7280;
        font-size: 16px;
    }

    .pos-cart-items {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 14px;
        padding-right: 4px;
    }

    .pos-cart-items::-webkit-scrollbar {
        width: 5px;
    }

    .pos-cart-items::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.15);
        border-radius: 999px;
    }

    .pos-cart-empty {
        color: #9ca3af;
        font-size: 13px;
        text-align: center;
        padding: 28px 8px;
        line-height: 1.6;
    }

    .pos-cart-item {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #fff;
        border: 1px solid #ece7df;
        border-radius: 14px;
        padding: 10px 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .pos-cart-item-thumb {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        background: #f3f4f6;
        overflow: hidden;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: #9ca3af;
    }

    .pos-cart-item-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .pos-cart-item-info {
        flex: 1;
        min-width: 0;
    }

    .pos-cart-item-info h4 {
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 2px;
        color: #1f2937;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .pos-cart-item-info span {
        font-size: 12px;
        color: #6b7280;
        font-weight: 600;
    }

    .pos-cart-item-qty {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #2f2f2f;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .pos-total-box {
        background: #fff;
        color: #1f2937;
        border-radius: 16px;
        padding: 18px 16px;
        text-align: center;
        margin-bottom: 12px;
        flex-shrink: 0;
        border: 1px solid #ece7df;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    }

    .pos-total-box strong {
        font-size: 34px;
        font-weight: 800;
        letter-spacing: -0.02em;
        line-height: 1.1;
    }

    .pos-payment-field {
        margin-bottom: 10px;
        flex-shrink: 0;
    }

    .pos-payment-field input {
        width: 100%;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 13px 14px;
        font-size: 14px;
        outline: none;
        font-family: inherit;
        background: #f9fafb;
        color: #374151;
    }

    .pos-payment-field input::placeholder {
        color: #9ca3af;
    }

    .pos-payment-field input[readonly] {
        background: #f3f4f6;
        color: #6b7280;
    }

    .pos-actions {
        display: flex;
        gap: 10px;
        flex-shrink: 0;
        margin-top: 4px;
    }

    .pos-btn {
        flex: 1;
        padding: 13px 12px;
        border: none;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        font-family: inherit;
        background: #6b7280;
        color: #fff;
        transition: opacity 0.15s;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
    }

    .pos-btn:hover {
        opacity: 0.92;
    }

    .pos-btn:disabled {
        opacity: 0.45;
        cursor: not-allowed;
    }

    .pos-btn--secondary {
        background: #9ca3af;
    }

    #posItemsContainer {
        display: none;
    }

    @media (max-width: 1100px) {
        .pos-main {
            flex-direction: column;
            overflow-y: auto;
        }

        .pos-cart {
            flex: none;
            width: 100%;
            max-width: 100%;
        }

        .pos-product-list {
            max-height: 50vh;
        }
    }
</style>
@endonce
