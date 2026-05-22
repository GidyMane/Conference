{{-- ================= PARTNERS / SUPPORTED BY ================= --}}
{{-- Drop this section wherever suits — recommended: between .announcement-banner and .conference-theme --}}

<style>
.partners-strip {
    background: #ffffff;
    border-top: 1px solid #e0e0e0;
    border-bottom: 1px solid #e0e0e0;
    padding: 2rem 0;
}
.partners-strip .section-label {
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #6c757d;
    margin-bottom: 1.5rem;
}
.partners-grid {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 2rem 3rem;
}
.partner-logo-link {
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: opacity 0.2s ease, transform 0.2s ease;
    opacity: 0.85;
}
.partner-logo-link:hover {
    opacity: 1;
    transform: translateY(-2px);
}
.partner-logo-link img {
    max-height: 64px;
    max-width: 160px;
    width: auto;
    object-fit: contain;
    filter: grayscale(20%);
    transition: filter 0.2s ease;
}
.partner-logo-link:hover img {
    filter: grayscale(0%);
}
/* Text fallback shown when image fails to load */
.partner-text-fallback {
    display: none;
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--green-dark, #1a5c2e);
    text-align: center;
    max-width: 120px;
    line-height: 1.3;
}
/* Show fallback if <img> has broken-image icon — JS handles this */
.partner-logo-link.img-error .partner-text-fallback { display: block; }
.partner-logo-link.img-error img { display: none; }

@media (max-width: 576px) {
    .partners-grid { gap: 1.5rem 2rem; }
    .partner-logo-link img { max-height: 48px; max-width: 120px; }
}
</style>

<section class="partners-strip">
    <div class="container text-center">
        <p class="section-label mb-0">Supported &amp; Partnered By</p>

        <div class="partners-grid mt-3">

            {{-- 1. Ministry of Agriculture and Livestock Development --}}
            <a href="https://kilimo.go.ke/"
               target="_blank" rel="noopener noreferrer"
               class="partner-logo-link"
               title="Ministry of Agriculture and Livestock Development">
                <img src="https://kilimo.go.ke/wp-content/uploads/2023/05/MoALD-Logo.png"
                     alt="Ministry of Agriculture and Livestock Development logo"
                     onerror="this.closest('.partner-logo-link').classList.add('img-error')">
                <span class="partner-text-fallback">Ministry of Agriculture &amp; Livestock Development</span>
            </a>

            {{-- 2. Food Systems Resilience Program (FSRP) --}}
            <a href="https://fsrp.go.ke/"
               target="_blank" rel="noopener noreferrer"
               class="partner-logo-link"
               title="Food Systems Resilience Program">
                <img src="https://fsrp.go.ke/sites/default/files/FSRP%20Banner24Apr24.jpg"
                     alt="Food Systems Resilience Program logo"
                     onerror="this.closest('.partner-logo-link').classList.add('img-error')">
                <span class="partner-text-fallback">Food Systems Resilience Program</span>
            </a>

            {{-- 3. FAO Kenya --}}
            <a href="https://www.fao.org/kenya/en/"
               target="_blank" rel="noopener noreferrer"
               class="partner-logo-link"
               title="FAO Kenya">
                <img src="https://www.fao.org/images/corporatelibraries/fao-logo/fao-logo-en.svg"
                     alt="FAO – Food and Agriculture Organization of the United Nations logo"
                     onerror="this.closest('.partner-logo-link').classList.add('img-error')">
                <span class="partner-text-fallback">FAO Kenya</span>
            </a>

            {{-- 4. Agriculture and Food Authority (AFA) --}}
            <a href="https://www.afa.go.ke/"
               target="_blank" rel="noopener noreferrer"
               class="partner-logo-link"
               title="Agriculture and Food Authority">
                <img src="https://www.afa.go.ke/images/logo.png"
                     alt="Agriculture and Food Authority logo"
                     onerror="this.closest('.partner-logo-link').classList.add('img-error')">
                <span class="partner-text-fallback">Agriculture &amp; Food Authority</span>
            </a>

        </div>
    </div>
</section>

<script>
/*
 * Extra safety net: some browsers fire onerror unreliably for SVG/CORS images.
 * This script checks all partner images after load and marks failures.
 */
(function () {
    document.querySelectorAll('.partner-logo-link img').forEach(function (img) {
        function check() {
            if (!img.complete || img.naturalWidth === 0) {
                img.closest('.partner-logo-link').classList.add('img-error');
            }
        }
        if (img.complete) { check(); }
        else { img.addEventListener('load', check); img.addEventListener('error', check); }
    });
})();
</script>