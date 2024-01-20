
document.querySelectorAll('.left-btn').forEach(btn => {
    const publicationID = btn.id.match(/\d+/)[0]
    btn.addEventListener('click', ()=>goToPrevSlideMain(publicationID))
})

document.querySelectorAll('.right-btn').forEach(btn => {
    const publicationID = btn.id.match(/\d+/)[0]
    btn.addEventListener('click', ()=>goToNextSlideMain(publicationID))
})

function goToMainSlide(currentSlide, nextSlide) {
    currentSlide.style.display = 'none'
    nextSlide.style.display = 'flex'
    nextSlide.classList.remove('d-none')
    currentSlideIndex = nextSlide
}
function hideArrowMain(publicationID, type) {
    console.log('hide arrow '+type)
    const btn = document.getElementById(type+'BtnMain'+publicationID)
    btn.style.display = 'none'
}

function showArrowMain(publicationID, type) {
    console.log('show arrow '+type)
    const btn = document.getElementById(type+'BtnMain'+publicationID)
    btn.classList.remove('d-none')
    btn.style.display = 'block'
}

function findCurrentIndex(elements) {
    for (let i = 0; i < elements.length; i++) {
       if (!elements[i].classList.contains('d-none') && elements[i].style.display !== 'none') {
            return i;
       }
    }
    return -1; // Return -1 if no current slide is found
}

function goToNextSlideMain(publicationID) {
    console.log('right btn clicked')
    const slides = document.querySelectorAll('.carousel-image-main'+publicationID);
    const index = findCurrentIndex(slides)
    console.log('index : '+index)
    console.log('slides length : '+slides.length)
    if (index+1 === slides.length-1) {
        hideArrowMain(publicationID, 'right')
    }
    showArrowMain(publicationID, 'left')
    goToMainSlide(slides[index], slides[index+1]);
}

function goToPrevSlideMain(publicationID) {
    console.log('previous slide')
    const slides = document.querySelectorAll('.carousel-image-main'+publicationID);
    const index = findCurrentIndex(slides)
    if (index-1 === 0) {
        hideArrowMain(publicationID,'left')
    }
    showArrowMain(publicationID, 'right')
    goToMainSlide(slides[index], slides[index-1]);
}