

const imgItem = document.querySelectorAll(".img-item");
const modalWrapper = document.querySelector(".text-light");
const imageSection = document.querySelector(".one-card")
const img = document.createElement('img')

console.log(imgItem);

imgItem.forEach((item) => {
  console.log(item);
  item.addEventListener("click", () => {
    modalWrapper.classList.remove("hidden");
    var itemSrc = item.getAttribute('src')

    img.setAttribute('src', itemSrc)

    imageSection.appendChild(img)

  });

  item.addEventListener('mouseover', () => {
    var itemSrc = item.getAttribute('src')
      document.getElementsByTagName('main')[0].style.backgroundImage = `url(${itemSrc})`
  })
});

modalWrapper.addEventListener("click", (e) => {
  e.preventDefault();

  console.log(e);
  
//   let isWrapper = 
//   isWrapper ?  : "";
modalWrapper.classList.add("hidden")

});
