// Adjusted for use with markup in products.blade.php

document.addEventListener('DOMContentLoaded', function () {
    const sections = Array.from(document.querySelectorAll('[data-carousel-section]'));
    if (!sections.length) return;

    const prevButton = document.querySelector('button[carousel-prev]');
    const nextButton = document.querySelector('button[carousel-next]');
    const toggleButtons = Array.from(document.querySelectorAll('[data-carousel-toggle]'));

    const isIpadViewport = () => window.matchMedia('(min-width: 740px) and (max-width: 1180px)').matches;

    const formatTitle = (text) => {
        if (!isIpadViewport()) return text;
        const words = text.trim().split(/\s+/);
        return words.length ? words[words.length - 1] : text;
    };

    const carouselState = new Map();

    sections.forEach((section) => {
        const carousel = section.querySelector('imageCarousel');
        if (!carousel) return;

        const products = Array.from(carousel.querySelectorAll('product'));
        if (!products.length) return;

        const title = carousel.querySelector('h1[carousel-title]');
        const sectionId = section.id || carousel.id;

        carouselState.set(sectionId, {
            section,
            carousel,
            products,
            title,
            currentIndex: 0,
        });

        updateProducts(sectionId);
    });

    if (!carouselState.size) return;

    let activeSectionId = sections.find((section) => !section.classList.contains('hidden'))?.id;
    if (!activeSectionId) {
        activeSectionId = sections[0].id;
        sections[0].classList.remove('hidden');
    }

    updateTitle(activeSectionId);
    syncToggleButtons();

    window.addEventListener('resize', () => updateTitle(activeSectionId));

    prevButton?.addEventListener('click', () => {
        shiftProduct(-1);
    });

    nextButton?.addEventListener('click', () => {
        shiftProduct(1);
    });

    toggleButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-carousel-toggle');
            if (!targetId || targetId === activeSectionId || !carouselState.has(targetId)) return;

            carouselState.forEach(({ section }, sectionId) => {
                section.classList.toggle('hidden', sectionId !== targetId);
            });

            activeSectionId = targetId;
            updateTitle(activeSectionId);
            updateProducts(activeSectionId);
            syncToggleButtons();
        });
    });

    function shiftProduct(step) {
        const state = carouselState.get(activeSectionId);
        if (!state) return;

        state.currentIndex = (state.currentIndex + step + state.products.length) % state.products.length;
        updateProducts(activeSectionId);
        updateTitle(activeSectionId);
    }

    function updateProducts(sectionId) {
        const state = carouselState.get(sectionId);
        if (!state) return;

        state.products.forEach((product, index) => {
            product.style.display = (index === state.currentIndex) ? 'flex' : 'none';
        });
    }

    function updateTitle(sectionId) {
        const state = carouselState.get(sectionId);
        if (!state || !state.title) return;

        const currentImage = state.products[state.currentIndex]?.querySelector('img');
        state.title.textContent = formatTitle(currentImage?.alt ?? '');
    }

    function syncToggleButtons() {
        toggleButtons.forEach((button) => {
            const isActive = button.getAttribute('data-carousel-toggle') === activeSectionId;
            button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
            button.classList.toggle('bg-zinc-900', isActive);
            button.classList.toggle('text-white', isActive);
            button.classList.toggle('bg-white', !isActive);
            button.classList.toggle('text-zinc-900', !isActive);
        });
    }
});