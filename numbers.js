document.addEventListener('DOMContentLoaded', function () {
    const data = {
        items: [
            { "number": "1", "spelling": "one" },
            { "number": "2", "spelling": "two" },
            { "number": "3", "spelling": "three" },
            { "number": "4", "spelling": "four" },
            { "number": "5", "spelling": "five" },
            { "number": "6", "spelling": "six" },
            { "number": "7", "spelling": "seven" },
            { "number": "8", "spelling": "eight" },
            { "number": "9", "spelling": "nine" },
            { "number": "10", "spelling": "ten" }
        ]
    };

    let currentIndex = 0;

    const carousel = document.getElementById('carousel');
    const prevButton = document.getElementById('prev');
    const nextButton = document.getElementById('next');

    function showSlide(index) {
        const item = data.items[index];
        carousel.innerHTML = `
            <div class="slide">
                <p class="number">${item.number}</p>
                <p class="spelling">${item.spelling}</p>
            </div>
        `;
        prevButton.style.display = index === 0 ? 'none' : 'inline-block';
        nextButton.style.display = index === data.items.length - 1 ? 'none' : 'inline-block';
    }

    prevButton.addEventListener('click', function () {
        if (currentIndex > 0) {
            currentIndex--;
            showSlide(currentIndex);
        }
    });

    nextButton.addEventListener('click', function () {
        if (currentIndex < data.items.length - 1) {
            currentIndex++;
            showSlide(currentIndex);
        }
    });
    showSlide(currentIndex);
});