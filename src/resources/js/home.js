  const carousel = document.querySelector('.carousel > div');
  const content = carousel.innerHTML;
  // need a copy to make the cycle effect
  carousel.innerHTML += content;

  const speed = 0;
  // to calculate tracks offset
  let position = 0;
  // to remove animation in caso of mouse over carousel
  let intervalId;

  function scroll() {
    position -= 1;
    carousel.style.transform = `translateX(${position}px)`;

    // once carousel has made a 'lap' change it to the starting position
    if (position <= -carousel.offsetWidth / 2) {
      position = 0;
      carousel.style.transition = 'none';
      carousel.style.transform = `translateX(${position}px)`;
      carousel.style.transition = 'transform 0s linear';
    }
  }

  function startScrolling() {
    intervalId = setInterval(scroll, speed);
  }

  function stopScrolling() {
    clearInterval(intervalId);
  }

  startScrolling();

  carousel.addEventListener('mouseover', stopScrolling);
  carousel.addEventListener('mouseout', startScrolling);