export function showLoader(selector = "#loader") {
    const loader = document.querySelector(selector);

    if (loader) {
        loader.classList.remove('d-none');
    }
}

export function hideLoader(selector = "#loader") {
    const loader = document.querySelector(selector);

    if (loader) {
        loader.classList.add('d-none');
    }
}
