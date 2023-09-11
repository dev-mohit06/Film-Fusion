let loaderDiv = document.querySelector('.loader');
window.addEventListener('load', function() {
    if (loaderDiv) {
      loaderDiv.classList.add('remove');
      setTimeout(() => {
        elemRemover();
      }, 1000);
    }
});

elemRemover = () => {
  if(loaderDiv.classList.contains('remove')){
    loaderDiv.remove();
  }
}