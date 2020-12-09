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

  let myModal = document.getElementById('myModal')
let myInput = document.getElementById('myInput')
try {
  myModal.addEventListener('shown.bs.modal', function () {
    myInput.focus()
  })

} catch {}


let x, i, j, l, ll, selElmnt, a, b, c;
/*look for any elements with the class "custom-select":*/
x = document.getElementsByClassName("custom-select");
l = x.length;
for (i = 0; i < l; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  ll = selElmnt.length;
  /*for each element, create a new DIV that will act as the selected item:*/
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /*for each element, create a new DIV that will contain the option list:*/
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < ll; j++) {
    /*for each option in the original select element,
    create a new DIV that will act as an option item:*/
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /*when an item is clicked, update the original select box,
        and the selected item:*/
        let y, i, k, s, h, sl, yl;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        sl = s.length;
        h = this.parentNode.previousSibling;
        for (i = 0; i < sl; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            yl = y.length;
            for (k = 0; k < yl; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
      /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
      e.stopPropagation();
      closeAllSelect(this);
      this.nextSibling.classList.toggle("select-hide");
      this.classList.toggle("select-arrow-active");
    });
}
function closeAllSelect(elmnt) {
  /*a function that will close all select boxes in the document,
  except the current select box:*/
  let x, y, i, xl, yl, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  xl = x.length;
  yl = y.length;
  for (i = 0; i < yl; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < xl; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);




const tableRow = document.querySelectorAll('.table-click');

tableRow.forEach(row => {
  row.addEventListener('click', () => {
    let curr_id = parseInt(row.childNodes[0].textContent);
    
    fetch('.././includes/detailed.php', {
      'userId': curr_id
    }).then((res) => {
      return res.json()
    })
    .then(data => {
      console.log(data)
    })
  })
})




})()  

function more() {
  const travelHistory = document.querySelector('.travel-history-container');
  travelHistory.innerHTML += ` <div class="travel-detail">
    <input type="date" class="locationwhen" name="when">
    <label class="custom-field one">
        <input type="text" required/>
        <span class="placeholder">Location</span>
    </label>
    </div>
    `
}


function interactMore() {
  const travelHistory = document.querySelector('.interact-history-container');
  travelHistory.innerHTML += ` <div class="interact-detail">
    <input type="date" class="interact-locationwhen" name="when">
    <label class="custom-field one">
        <input type="text" required/>
        <span class="placeholder">Location</span>
    </label>
    </div>
    `
}