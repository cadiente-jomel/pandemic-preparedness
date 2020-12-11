let controls = (function () {
    const selected = document.querySelector('.selected');
    const profileSelectedList = document.querySelectorAll('.profile-selected');
    const searchOuter = document.querySelector('.search-outer');
    const searchInput = document.querySelector('.search-input');
    const optionsProfile = document.querySelectorAll(
        '.profile-options-container'
    );
    const optionsContainer = document.querySelector('.options-container');

    const optionsList = document.querySelectorAll('.option');
    // let i = 0;
    profileSelectedList.forEach((profileSelected) => {
        profileSelected.addEventListener('click', () => {
            let profileToggle = profileSelected.nextElementSibling;

            profileToggle.classList.toggle('active');
            // console.log(optionsProfile[i])
            // optionsProfile[i].classList.toggle("active")
            // optionsProfile.classList.toggle("active");
            profileSelected.classList.toggle('br');
            // i += 1;
        });
    });

    selected.addEventListener('click', () => {
        optionsContainer.classList.toggle('active');
    });

    optionsList.forEach((o) => {
        o.addEventListener('click', () => {
            selected.innerHTML = o.querySelector('label').innerHTML;
            optionsContainer.classList.remove('active');
        });
    });

    searchInput.addEventListener('focus', () => {
        searchOuter.classList.add('search-active');
    });

    searchInput.addEventListener('blur', () => {
        searchOuter.classList.remove('search-active');
    });

    let myModal = document.getElementById('myModal');
    let myInput = document.getElementById('myInput');
    try {
        myModal.addEventListener('shown.bs.modal', function () {
            myInput.focus();
        });
    } catch {}

    let x, i, j, l, ll, selElmnt, a, b, c;
    /*look for any elements with the class "custom-select":*/
    x = document.getElementsByClassName('custom-select');
    l = x.length;
    for (i = 0; i < l; i++) {
        selElmnt = x[i].getElementsByTagName('select')[0];
        ll = selElmnt.length;
        /*for each element, create a new DIV that will act as the selected item:*/
        a = document.createElement('DIV');
        a.setAttribute('class', 'select-selected');
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        x[i].appendChild(a);
        /*for each element, create a new DIV that will contain the option list:*/
        b = document.createElement('DIV');
        b.setAttribute('class', 'select-items select-hide');
        for (j = 1; j < ll; j++) {
            /*for each option in the original select element,
    create a new DIV that will act as an option item:*/
            c = document.createElement('DIV');
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener('click', function (e) {
                /*when an item is clicked, update the original select box,
        and the selected item:*/
                let y, i, k, s, h, sl, yl;
                s = this.parentNode.parentNode.getElementsByTagName(
                    'select'
                )[0];
                sl = s.length;
                h = this.parentNode.previousSibling;
                for (i = 0; i < sl; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        h.innerHTML = this.innerHTML;
                        y = this.parentNode.getElementsByClassName(
                            'same-as-selected'
                        );
                        yl = y.length;
                        for (k = 0; k < yl; k++) {
                            y[k].removeAttribute('class');
                        }
                        this.setAttribute('class', 'same-as-selected');
                        break;
                    }
                }
                h.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener('click', function (e) {
            /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle('select-hide');
            this.classList.toggle('select-arrow-active');
        });
    }
    function closeAllSelect(elmnt) {
        /*a function that will close all select boxes in the document,
  except the current select box:*/
        let x,
            y,
            i,
            xl,
            yl,
            arrNo = [];
        x = document.getElementsByClassName('select-items');
        y = document.getElementsByClassName('select-selected');
        xl = x.length;
        yl = y.length;
        for (i = 0; i < yl; i++) {
            if (elmnt == y[i]) {
                arrNo.push(i);
            } else {
                y[i].classList.remove('select-arrow-active');
            }
        }
        for (i = 0; i < xl; i++) {
            if (arrNo.indexOf(i)) {
                x[i].classList.add('select-hide');
            }
        }
    }
    /*if the user clicks anywhere outside the select box,
then close all select boxes:*/
    document.addEventListener('click', closeAllSelect);

    const activateEventListener = () => {
        const tableRow = document.querySelectorAll('.table-click');

        tableRow.forEach((row) => {
            row.addEventListener('click', () => {
                let curr_id = parseInt(row.childNodes[0].value);
                let userId = { userId: curr_id };
                // console.log(JSON.stringify(userId))
                fetch('.././includes/detailed.php', {
                    method: 'POST',
                    body: JSON.stringify(userId),
                })
                    .then((res) => {
                        return res.json();
                    })
                    .then((data) => {
                        try {
                            let profileRemove = document.querySelector(
                                '.citizen-personal-info'
                            );
                            profileRemove.remove();
                            const travelData = document.querySelectorAll('.travel-data');
                            travelData.forEach(el => {
                                el.remove();
                            })

                            const contactData = document.querySelectorAll('.contact-data');
                            contactData.forEach(el => {
                                el.remove();
                            })
                        } catch {}
                        const profile = document.querySelector(
                            '.citizen-profile-information'
                        );
                        const travelRecord = document.querySelector(
                            '.travel-record'
                        );
                        const contactRecord = document.querySelector('.contact-record');

                        


                        profile.innerHTML += `<div class="citizen-personal-info">
            <ul class="personal-info">
                <li>First Name: <span clsas="info-first">${data[0].first_name}</span></li>
                <li>Last Name: <span clsas="info-last">${data[0].last_name}</span></li>
                <li>Status: <span clsas="info-status">${data[0].covid_status}</span></li>
                <li>Day of Quarantine: <spa clsas="info-day">${data[0].days} Days</spa></li>
                <li>Age: <span clsas="info-age">${data[0].age}</span></li>
                <li>Occupation: <span clsas="info-occupation">${data[0].occupation}</span> </li>
                <li>Civil Status: <span clsas="info-civil">${data[0].civil_status}</span></li>
                <li>Covid Case: <span clsas="info-case">${data[0].covid_case}</span></li>
            </ul>
        </div>`;
            data[0].travel_data.forEach(record => {
                travelRecord.innerHTML += `<div class="t-option option travel-data">
                                            <div class="option-left">
                                                <p>${record.travel_date}</p>
                                            </div>
                                            <div class="option-right">
                                                <p>${record.travel_location}</p>
                                            </div>
                                            </div>`;

            })
            data[0].contact_data.forEach(record => {
                contactRecord.innerHTML += `<div class="interact-option contact-data">
                                            <div class="interact-option-left">
                                                <p>${record.contact_date}</p>
                                            </div>
                                            <div class="interact-option-middle">
                                                <p>${record.contact_person}</p>
                                            </div>
                                            <div class="interact-option-right">
                                                <p>${record.contact_address}</p>
                                            </div>
                                        </div>`
            })
            // console.log(data);
                    });
            });
        });
    }
    activateEventListener();
    const form = document.querySelector('.add-form')
    form.addEventListener('submit', e => {
        const url = form.attributes.action.textContent;
        e.preventDefault();
        let travelHistroy = [];
        let contactHistory = [];
        let firstName = document.querySelector('.first-name').value
        let lastName = document.querySelector('.last-name').value
        let age = document.querySelector('.age').value
        let occupation = document.querySelector('.occupation').value
        let days = document.querySelector('.days').value
        let covidStatus = document.querySelector('.covid-status').value
        let covidCase = document.querySelector('.covid-case').value
        let civilStatus = document.querySelector('.civil-status').value
        let address = document.querySelector('.address').value
        let travelDetail = document.querySelectorAll('.travel-detail')
        let intractDetail = document.querySelectorAll('.interact-detail')
        let i = 0;
        travelDetail.forEach(data => {
            const loc = document.querySelectorAll('.locationwhen')
            const tloc = document.querySelectorAll('.travel-location')
            travelHistroy.push({'travel_date': loc[i].value, 'travel_location': tloc[i].value})        
            i += 1;
        })
        i = 0;
        intractDetail.forEach(data => {
            const interactWhen = document.querySelectorAll('.interact-locationwhen')
            const interactName = document.querySelectorAll('.contact-name')
            const interactLo = document.querySelectorAll('.contact-location')
            contactHistory.push({'interact_date': interactWhen[i].value, 'interact_name': interactName[i].value, 'interact_location': interactLo[i].value})        
            i += 1;
        })
        let data = {
            first_name: firstName, 
            last_name: lastName,
            user_age: parseInt(age),
            user_occupation: occupation,
            user_address: address,
            quarantine_days: parseInt(days),
            covid_status: covidStatus,
            covid_case: covidCase,
            civil_status: civilStatus,
            travel_history: travelHistroy,
            contact_history: contactHistory
        }
        fetch(url, {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then((res) => {
            return res.json();
        })
        .then((data) => {
            
            const tableRecord = document.querySelector('.table-record');
            console.log(data);
            const tableRow = document.createElement('tr');
            tableRow.classList.add('table-row');
            tableRow.classList.add('table-click');
            tableRecord.appendChild(tableRow);
            const inputHidden = document.createElement('input')
            inputHidden.type = 'hidden';
            inputHidden.name = 'userId';
            inputHidden.value = data[0].new_id;
            const rowID = document.createElement('td');
            rowID.classList.add('table-data');
            rowID.textContent = data[0].new_id;
            const fullName = document.createElement('td');
            fullName.classList.add('table-data');
            fullName.textContent = `${firstName}  ${lastName}`;
            const rowAge = document.createElement('td');
            rowAge.classList.add('table-data');
            rowAge.textContent = age;
            const rowAddress = document.createElement('td')
            rowAddress.classList.add('table-data');
            rowAddress.textContent = address;
            const status = document.createElement('td')
            status.classList.add('table-data')
            const icon = document.createElement('i');
            if (covidStatus !== 'Negative') {
                icon.classList.add('positive');
                icon.classList.add('fas');
                icon.classList.add('fa-check-circle')
                status.appendChild(icon)
            } else {
                icon.classList.add('positive');
                icon.classList.add('fas');
                icon.classList.add('fa-times-circle')
                status.appendChild(icon)
            }

            const action = document.createElement('td');
            action.classList.add('table-data');
            const anchorEdit  = document.createElement('a');
            anchorEdit.classList.add('btn-edit');
            const btnDelete = document.createElement('button');
            btnDelete.classList.add('btn-trash')
            // data-bs-toggle="modal" data-bs-target="#confirm-modal"
            btnDelete.setAttribute('data-bs-toggle', 'modal');
            btnDelete.setAttribute('data-bs-target', '#confirm-modal')
            action.appendChild(anchorEdit);
            action.appendChild(btnDelete)
            const edit = document.createElement('i');
            const deleteRow = document.createElement('i');
            edit.classList.add('far');
            edit.classList.add('fa-edit');
            deleteRow.classList.add('fas');
            deleteRow.classList.add('fa-trash');

            anchorEdit.appendChild(edit);
            btnDelete.appendChild(deleteRow);
            tableRow.appendChild(inputHidden);
            tableRow.appendChild(rowID);
            tableRow.appendChild(fullName);
            tableRow.appendChild(rowAge);
            tableRow.appendChild(rowAddress);
            tableRow.appendChild(status);
            tableRow.appendChild(action);
            activateEventListener();
        })
        .catch((err) => {
            console.log(err)
        })
        
    })


    


    const addBtn = document.querySelector('.add-record');
    addBtn.addEventListener('click', () => {
        resetInput();
    })
    const resetInput = () => {
        let cs = document.querySelector('.covid-status')
        let ccase = document.querySelector('.covid-case');
        let cstatus = document.querySelector('.civil-status');
        document.querySelector('.first-name').value = "";
        document.querySelector('.last-name').value = "";
        document.querySelector('.age').value = "";
        document.querySelector('.occupation').value = "";
        document.querySelector('.days').value = "";
        // cs.textContent = "Covid Status:";
        // cs.value = "NA";
        // ccase.textContent =  "Covid Case:";
        // ccase.value = "NA";
        // cstatus.textContent = "Covid Status";
        // cstatus.value = "NA";
        document.querySelector('.address').value = "";
    }

    let curr_url, curr_row;
    const btnTrash = document.querySelectorAll('.btn-trash');
    btnTrash.forEach(data => {
        data.addEventListener('click', () => {
            curr_url = data.parentElement.parentElement.childNodes[0].value
            curr_row = data.parentElement.parentElement
            console.log(curr_row);
        })
    })

    const editBtn = document.querySelectorAll('.btn-edit');
    
    editBtn.forEach(btn => {
        btn.addEventListener('click', e => {
            curr_url = btn.parentElement.parentElement.childNodes[0].value
            curr_row = btn.parentElement.parentElement
            // alert(curr_url)
            e.preventDefault();

            dataEdit = {
                id: curr_url,
            }
            let url = btn.attributes.href.textContent;
            fetch(url, {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(dataEdit),
            })
            .then((res) => {
                return res.json();
            })
            .then((data) => {
                addBtn.click();
            })
        })
    })

    const btnDeleteConfirm = document.querySelector('.btn-confirm-delete');
    btnDeleteConfirm.addEventListener('click', e => {
        e.preventDefault();
        const url = btnDeleteConfirm.attributes.href.textContent;
        deleteData = {
            id: curr_url,
        }
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(deleteData),
        }).then(() => {
            const closeModal = document.querySelector('.btn-cancel');
            closeModal.click();
            curr_row.remove();
        }).catch((err) => {
            console.log(err);
        })
    })
    
})();

function more() {
    const travelHistory = document.querySelector('.travel-history-container');
    travelHistory.innerHTML += ` <div class="travel-detail">
    <input type="date" class="locationwhen" name="travel-when">
    <label class="custom-field one">
        <input class="travel-location" type="text" name="travel-location" required/>
        <span class="placeholder">Location</span>
    </label>
    </div>
    `;
}

function interactMore() {
    const travelHistory = document.querySelector('.interact-history-container');
    travelHistory.innerHTML += ` <div class="interact-detail">
    <input type="date" class="interact-locationwhen" name="contact-when">
    <label class="custom-field one">
        <input class="contact-name" name="contact-name" type="text" required/>
        <span class="placeholder">Person Name</span>
    </label>
    <label class="custom-field one">
        <input class="contact-location" type="text" name="contact-location" required/>
        <span class="placeholder">Location</span>
    </label>
    </div>
    `;
}
