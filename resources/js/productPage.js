// Adjusted for use with markup in products.blade.php

document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.querySelector('imageCarousel#carousel1');
    if (!carousel) return;

    const products = Array.from(carousel.querySelectorAll('product'));
    let currentIndex = 0;

    const title = document.querySelector('h1[carousel-title]');

    const isIpadViewport = () => window.matchMedia('(min-width: 740px) and (max-width: 1180px)').matches;

    const formatTitle = (text) => {
        if (!isIpadViewport()) return text;
        const words = text.trim().split(/\s+/);
        return words.length ? words[words.length - 1] : text;
    };

    function showProduct(index) {
        products.forEach((product, i) => {
            product.style.display = (i === index) ? 'flex' : 'none';
        });
    }

    showProduct(currentIndex);
    title.textContent = formatTitle(products[currentIndex].querySelector('img').alt);

    window.addEventListener('resize', () => {
        title.textContent = formatTitle(products[currentIndex].querySelector('img').alt);
    });


    document.querySelector('button[carousel-prev]')?.addEventListener('click', function () {
        currentIndex = (currentIndex - 1 + products.length) % products.length;
        showProduct(currentIndex);
        title.textContent = formatTitle(products[currentIndex].querySelector('img').alt);

    });

    document.querySelector('button[carousel-next]')?.addEventListener('click', function () {
        currentIndex = (currentIndex + 1) % products.length;
        showProduct(currentIndex);
        title.textContent = formatTitle(products[currentIndex].querySelector('img').alt);
    });

});