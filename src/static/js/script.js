let controls = (function() {
  const selected = document.querySelector(".selected");
  const profileSelectedList = document.querySelectorAll('.profile-selected')
  const searchOuter = document.querySelector('.search-outer')
  const searchInput = document.querySelector('.search-input')
  const optionsProfile = document.querySelectorAll('.profile-options-container')
  const optionsContainer = document.querySelector(".options-container");
  
  const optionsList = document.querySelectorAll(".option");
  // let i = 0;
  profileSelectedList.forEach(profileSelected => {
  profileSelected.addEventListener("click", () => {
   let profileToggle = profileSelected.nextElementSibling;

   profileToggle.classList.toggle("active")
    // console.log(optionsProfile[i])
    // optionsProfile[i].classList.toggle("active")
    // optionsProfile.classList.toggle("active");  
    profileSelected.classList.toggle("br");
    // i += 1;
  })
})

  selected.addEventListener("click", () => {
    optionsContainer.classList.toggle("active");
  });
  
  optionsList.forEach(o => {
    o.addEventListener("click", () => {
      selected.innerHTML = o.querySelector("label").innerHTML;
      optionsContainer.classList.remove("active");
    });
  });

  searchInput.addEventListener('focus', () => {
    searchOuter.classList.add('search-active')
  })

  searchInput.addEventListener('blur', () => {
    searchOuter.classList.remove('search-active')
  })
})()  
