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
    const categoryList = document.querySelectorAll('.radio');
    const searchForm = document.querySelector('.search-form');
    


    searchForm.addEventListener('submit', e => {
        e.preventDefault();
        const url = searchForm.attributes.action.textContent;
        let searchVal = document.getElementById('search-value');
        data = {
            val: searchVal.value,
        }
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        }).then(res=> {
            
            return res.json()
        })
        .then(results=> {
            generateRow(results)
        })
    })

    const generateRow = (results) => {
        // console.log(results[0])
        const tableRowPrev = document.querySelectorAll('.table-row-data');
        tableRowPrev.forEach(el => {
            el.remove();
        })


        const tableRecord = document.querySelector('.table-record');
        results.forEach(data => {
            console.log(data);
            const tableRow = document.createElement('tr');
            tableRow.classList.add('table-row');
            tableRow.classList.add('table-click');
            tableRow.classList.add('table-row-data');
            tableRecord.appendChild(tableRow);
            const inputHidden = document.createElement('input')
            inputHidden.type = 'hidden';
            inputHidden.name = 'userId';
            inputHidden.value = data.new_id;
            const rowID = document.createElement('td');
            rowID.classList.add('table-data');
            rowID.textContent = data.new_id;
            const fullName = document.createElement('td');
            fullName.classList.add('table-data');
            fullName.textContent = `${data.first_name} ${data.last_name}`;
            const rowAge = document.createElement('td');
            rowAge.classList.add('table-data');
            rowAge.textContent = data.age;
            const rowAddress = document.createElement('td')
            rowAddress.classList.add('table-data');
            rowAddress.textContent =    data.address;
            const status = document.createElement('td')
            status.classList.add('table-data')
            const icon = document.createElement('i');
            if (data.covid_status !== 'Negative') {
                icon.classList.add('positive');
                icon.classList.add('fas');
                icon.classList.add('fa-check-circle')
                status.appendChild(icon)
            } else {
                icon.classList.add('negative');
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

        })
        activateEventListener();
    }
    
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
        // alert('selected')
    });
    optionsList.forEach((o) => {
        o.addEventListener('click', (e) => {
            e.preventDefault();
            selected.innerHTML = o.querySelector('label').innerHTML;
            optionsContainer.classList.remove('active');
            let query = {
                val: o.childNodes[1].value,
            }
            
            fetch('../includes/search.php', {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(query)
            }).then(res => {
                return res.json()
            }).then(results => {
                generateRow(results);
            })
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

//     let x, i, j, l, ll, selElmnt, a, b, c;
//     /*look for any elements with the class "custom-select":*/
//     x = document.getElementsByClassName('custom-select');
//     l = x.length;
//     for (i = 0; i < l; i++) {
//         selElmnt = x[i].getElementsByTagName('select')[0];
//         ll = selElmnt.length;
//         /*for each element, create a new DIV that will act as the selected item:*/
//         a = document.createElement('DIV');
//         a.setAttribute('class', 'select-selected');
//         a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
//         x[i].appendChild(a);
//         /*for each element, create a new DIV that will contain the option list:*/
//         b = document.createElement('DIV');
//         b.setAttribute('class', 'select-items select-hide');
//         for (j = 1; j < ll; j++) {
//             /*for each option in the original select element,
//     create a new DIV that will act as an option item:*/
//             c = document.createElement('DIV');
//             c.innerHTML = selElmnt.options[j].innerHTML;
//             c.addEventListener('click', function (e) {
//                 /*when an item is clicked, update the original select box,
//         and the selected item:*/
//                 let y, i, k, s, h, sl, yl;
//                 s = this.parentNode.parentNode.getElementsByTagName(
//                     'select'
//                 )[0];
//                 sl = s.length;
//                 h = this.parentNode.previousSibling;
//                 for (i = 0; i < sl; i++) {
//                     if (s.options[i].innerHTML == this.innerHTML) {
//                         s.selectedIndex = i;
//                         h.innerHTML = this.innerHTML;
//                         y = this.parentNode.getElementsByClassName(
//                             'same-as-selected'
//                         );
//                         yl = y.length;
//                         for (k = 0; k < yl; k++) {
//                             y[k].removeAttribute('class');
//                         }
//                         this.setAttribute('class', 'same-as-selected');
//                         break;
//                     }
//                 }
//                 h.click();
//             });
//             b.appendChild(c);
//         }
//         x[i].appendChild(b);
//         a.addEventListener('click', function (e) {
//             /*when the select box is clicked, close any other select boxes,
//       and open/close the current select box:*/
//             e.stopPropagation();
//             closeAllSelect(this);
//             this.nextSibling.classList.toggle('select-hide');
//             this.classList.toggle('select-arrow-active');
//         });
//     }
//     function closeAllSelect(elmnt) {
//         /*a function that will close all select boxes in the document,
//   except the current select box:*/
//         let x,
//             y,
//             i,
//             xl,
//             yl,
//             arrNo = [];
//         x = document.getElementsByClassName('select-items');
//         y = document.getElementsByClassName('select-selected');
//         xl = x.length;
//         yl = y.length;
//         for (i = 0; i < yl; i++) {
//             if (elmnt == y[i]) {
//                 arrNo.push(i);
//             } else {
//                 y[i].classList.remove('select-arrow-active');
//             }
//         }
//         for (i = 0; i < xl; i++) {
//             if (arrNo.indexOf(i)) {
//                 x[i].classList.add('select-hide');
//             }
//         }
//     }
//     /*if the user clicks anywhere outside the select box,
// then close all select boxes:*/
//     document.addEventListener('click', closeAllSelect);
    // * VARIAAAAAAAAAAAAAABLEEEE!!!
    let userId;
    let travelHistory = [];
    let contactHistory = [];
    let firstName = document.querySelector('.first-name');
    let lastName = document.querySelector('.last-name');
    let age = document.querySelector('.age');
    let occupation = document.querySelector('.occupation');
    let days = document.querySelector('.days');
    let covidStatus = document.querySelector('.covid-status');
    let covidCase = document.querySelector('.covid-case');
    let civilStatus = document.querySelector('.civil-status');
    let address = document.querySelector('.address');

    let travelDetail;
    let intractDetail ;
    // * END OF VARIAAAAAAAAAAAAAAAAABLEEEEE!!!
    const editBtnListener = () =>  {
        const editBtn = document.querySelectorAll('.btn-edit');
    
    editBtn.forEach(btn => {
        btn.addEventListener('click', e => {
            resetInput();
            curr_url = btn.parentElement.parentElement.childNodes[0].value
            curr_row = btn.parentElement.parentElement
            // alert(curr_url)
            e.preventDefault();

            console.log(curr_url)

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
                console.log(data);
                form.attributes.action.textContent = '../includes/update_user.php';
                // addBtn.click();
                firstName.value = data[0].first_name;
                lastName.value = data[0].last_name;
                age.value = data[0].age;
                occupation.value = data[0].occupation;
                address.value = data[0].address;
                days.value = data[0].days;
                covidStatus.value = data[0].covid_status;
                // covidStatus.textContent = data[0].covid_status;
                // civilStatus.textContent = data[0].civil_status;
                civilStatus.value = data[0].civil_status;
                // covidCase.textContent = data[0].covid_case;
                covidCase.value = data[0].covid_case;
                const prevs = document.querySelectorAll('.previous')
                let arr = [data[0].covid_status,
                            data[0].covid_case,
                            data[0].civil_status];
                let i = 0;
                const prevsVal = document.querySelectorAll('.previous-value')
                prevs.forEach(prev => {
                    prev.classList.remove('text-hide');
                    prevsVal[i].textContent = arr[i];
                    i+=1;
                })

                data[0].travel_data.forEach(travelData => {
                    let curr = travelBtn(1);
                    more(curr ,travelData.travel_date, travelData.travel_location, travelData.travel_id)
                })

                data[0].contact_data.forEach(contactData => {
                    let curr = interactBtn(1);
                    interactMore(curr, contactData.contact_date, contactData.contact_person, contactData.contact_address, contactData.contact_id);
                })
                
                // historyDelete();

                // flag = false;
                // firstName.value = data.
            })
        })
    })
    }
    editBtnListener();

    const activateEventListener = () => {
        const tableRow = document.querySelectorAll('.table-click');

        tableRow.forEach((row) => {
            row.addEventListener('click', () => {
                let curr_id = parseInt(row.childNodes[0].value);
                userId = { userId: curr_id };
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

    try {
        const modal = document.querySelector('.modal-backdrop')

        modal.addEventListener('click', () => {
            alert('modal clicked!')
        })
    }catch {}

    let curr_url, curr_row;
    const form = document.querySelector('.add-form')
    form.addEventListener('submit', e => {
        let flag = true;
        const url = form.attributes.action.textContent;
        if(url === '../includes/update_user.php'){
            flag = false;
        }
        // if(url === '../includes/update_user.php'); {
        //     alert('form rerendered!');
        //     editBtnListener();
        // }
        e.preventDefault();
        travelDetail = document.querySelectorAll('.travel-detail');
        intractDetail = document.querySelectorAll('.interact-detail');
        // curr_url = data.parentElement.parentElement.childNodes[0].value
        let i = 0;
        travelDetail.forEach(data => {
            const loc = document.querySelectorAll('.locationwhen')
            const tloc = document.querySelectorAll('.travel-location')
            const tid = document.querySelectorAll('.travel-id')
            travelHistory.push({'travel_date': loc[i].value, 'travel_location': tloc[i].value,'travel_id': tid[i].value});        
            i += 1;
        })
        i = 0;
        intractDetail.forEach(data => {
            const interactWhen = document.querySelectorAll('.interact-locationwhen')
            const interactName = document.querySelectorAll('.contact-name')
            const interactLo = document.querySelectorAll('.contact-location')
            const interactId = document.querySelectorAll('.interact-id')
            contactHistory.push({'interact_date': interactWhen[i].value, 'interact_name': interactName[i].value, 'interact_location': interactLo[i].value, 'interact_id': interactId[i].value})        
            i += 1;
        })
        console.log(userId)
        let dataBody = {
            userId: userId,
            first_name: firstName.value, 
            last_name: lastName.value,
            user_age: parseInt(age.value),
            user_occupation: occupation.value,
            user_address: address.value,
            quarantine_days: parseInt(days.value),
            covid_status: covidStatus.value,
            covid_case: covidCase.value,
            civil_status: civilStatus.value,
            travel_history: travelHistory,
            contact_history: contactHistory
        }
        // console.log(JSON.stringify(dataBody))
        fetch(url, {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dataBody)
        }).then((res) => {
            // return res.json();
            return res.json();
        })
        .then((data) => {
            // alert(url);
            if(!flag){
                alert(url)
                // alert('dd')
                dataBody = {};
                document.querySelector('.modal-close').click();
                console.log(document.querySelector('.modal-close'));
                
            } else {
                alert(url)
                  console.log(data)
            const tableRecord = document.querySelector('.table-record');
            // console.log(data[0]);
            const tableRow = document.createElement('tr');
            tableRow.classList.add('table-row');
            tableRow.classList.add('table-click');
            tableRow.classList.add('table-row-data');
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
            fullName.textContent = `${firstName.value}  ${lastName.value}`;
            const rowAge = document.createElement('td');
            rowAge.classList.add('table-data');
            rowAge.textContent = age.value;
            const rowAddress = document.createElement('td')
            rowAddress.classList.add('table-data');
            rowAddress.textContent = address.value;
            const status = document.createElement('td')
            status.classList.add('table-data')
            const icon = document.createElement('i');
            if (covidStatus !== 'Negative') {
                icon.classList.add('positive');
                icon.classList.add('fas');
                icon.classList.add('fa-check-circle')
                status.appendChild(icon)
            } else {
                icon.classList.add('negative');
                icon.classList.add('fas');
                icon.classList.add('fa-times-circle')
                status.appendChild(icon)
            }

            const action = document.createElement('td');
            action.classList.add('table-data');
            const anchorEdit  = document.createElement('a');
            anchorEdit.classList.add('btn-edit');
            anchorEdit.href = '../includes/update_record.php';
            anchorEdit.setAttribute('data-bs-target', '#add-modal');
            anchorEdit.setAttribute('data-bs-toggle', 'modal');
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
           
            resetInput();
                activateEventListener();
                editBtnListener();
            }
          
        })
        .catch((err) => {
            console.log(err)
        })
        
    })


    

    let flag = true;
    const addBtn = document.querySelector('.add-record');
    addBtn.addEventListener('click', () => {
        try {
        const prevs = document.querySelectorAll('.previous');
        prevs.forEach(prev => {
            prev.classList.add('text-hide');
        })
        }catch{}
        form.attributes.action.textContent = '../includes/create_record.php';
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
        cs.value = "NA";
        // ccase.textContent =  "Covid Case:";
        ccase.value = "NA";
        // cstatus.textContent = "Covid Status";
        cstatus.value = "NA";
        document.querySelector('.address').value = "";
        const travelDetails = document.querySelectorAll('.travel-detail');
        console.log(travelDetails)
        const interactDetails = document.querySelectorAll('.interact-detail');
        console.log(interactDetails)
        interactDetails.forEach(el => {
            el.remove();
        })
        travelDetails.forEach(el1 => {
            el1.remove();
        })
        // if(flag) {
        //     interactMore();
        //     more();
        // }
    }
    const btnTrash = document.querySelectorAll('.btn-trash');
    btnTrash.forEach(data => {
        data.addEventListener('click', () => {
            curr_url = data.parentElement.parentElement.childNodes[0].value
            curr_row = data.parentElement.parentElement
            console.log(curr_row);
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
            console.log(curr_row)
            curr_row.remove();
        }).catch((err) => {
            console.log(err);
        })
    })
    
})();

const historyDelete = (btn) => {
    /*
    icon.classList.add('positive');
                icon.classList.add('fas');
                icon.classList.add('fa-check-circle')
    */
    btn.addEventListener('click', e => {
        let del = btn.childNodes[0];

        del.classList.remove('fa-minus-circle');
        del.classList.add('fa-check-circle');
        del.style.color = '#4bb543';
        del.setAttribute('data-toggle', 'tooltip');
        del.setAttribute('data-placement', 'top');
        del.setAttribute('title', 'confirm delete?');

        del.addEventListener('click', () => {
            console.log('deleted');
            
            
            let valueToBeDeleted = btn.nextElementSibling.value;
            let currClass = btn.parentElement.className;
            console.log(currClass);
            data = {
                id: valueToBeDeleted,
                table: currClass
            }
            fetch('../includes/delete_history.php', {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(()=> {
                btn.parentElement.remove();
            }).catch((err) => {
                console.log(err)
            })
        })
        // btn.parentElement.remove();
    })
    // alert('history')
    // const btns = document.querySelectorAll('.remove-container')

    // btns.forEach(btn => {
    //     btn.addEventListener('click', () => {
    //         console.log('delete history');
    //     })
    // })
}

const addButton = (el, indicator=0) =>  {
    let flag = 1;
    flag = indicator
    console.log('curr bool ' + flag)
    const btnHis = document.createElement('div');
    btnHis.setAttribute('data-toggle', 'tooltip');
    btnHis.setAttribute('data-placement', 'top');
    btnHis.setAttribute('title', 'delete this data');
    btnHis.classList.add('remove-container');
    const btnHisIcon = document.createElement('i');
    btnHisIcon.classList.add('fas');
    btnHisIcon.classList.add('fa-minus-circle');
    btnHis.appendChild(btnHisIcon);
    historyDelete(btnHis);
    if (flag === 1) {
        console.log(true)
        return btnHis;
    } else {
        console.log(false)
        el(btnHis);
    }
}

const helper = (el, el1) => {
    el(el1);
}

const travelBtn = (indicator=0) => {
    return addButton(more, indicator);
}

const interactBtn = (indicator=1) => {
    return addButton(interactMore, indicator);
}

const travelBool = () => {
    travelBtn(0)
}

const interactBool = () => {
    interactBtn(0)
}


const travelHistoryCon = document.querySelector('.travel-record-more')
travelHistoryCon.addEventListener('click', travelBool);
const interactHistoryCon = document.querySelector('.interact-record-more');
interactHistoryCon.addEventListener('click', interactBool);

function more(btnStr,date='', loc='', id='') {
    const travelHistory = document.querySelector('.travel-history-container');
    console.log(typeof btnStr)
    const travelDetail = document.createElement('div')
    if (typeof btnStr != "object") {
        let btn = btnStr();
        console.log(typeof btn)
        console.log(btn)
        travelDetail.appendChild(btn)
    } else {
        travelDetail.appendChild(btnStr)
    }
    travelDetail.classList.add('travel-detail');
    const inputIDHidden = document.createElement('input');
    inputIDHidden.type = 'hidden';
    inputIDHidden.classList.add('travel-id');
    inputIDHidden.name = 'interact-id';
    inputIDHidden.value = id;
    const inputDate = document.createElement('input');
    inputDate.type = 'date';
    try {
        inputDate.valueAsDate = new Date(date)
    }catch{}
    inputDate.classList.add('locationwhen');
    inputDate.name = 'travel-when';
    const labelInput = document.createElement('label');
    labelInput.classList.add('custom-field');
    labelInput.classList.add('one');
    const inputText = document.createElement('input');
    inputText.type = 'text';
    inputText.classList.add('travel-location');
    inputText.name = 'travel-location';
    inputText.value = loc
    inputText.setAttribute('required', true);
    const spanText = document.createElement('span');
    spanText.classList.add('placeholder');
    spanText.textContent = 'Location';

    travelHistory.appendChild(travelDetail);
    travelDetail.appendChild(inputIDHidden);
    travelDetail.appendChild(inputDate);
    labelInput.appendChild(inputText);
    labelInput.appendChild(spanText);
    travelDetail.appendChild(labelInput);
    // return btnStr;
    // historyDelete();
}

function interactMore(btnStr, date='', name='', loc='', id='') {
    const travelHistory = document.querySelector('.interact-history-container');
    // travelHistory.innerHTML += ` <div class="interact-detail">
    // <input type="date" class="interact-locationwhen" name="contact-when">
    //
    // <label class="custom-field one">
    //     <input class="contact-name" name="contact-name" type="text" required/>
    //     <span class="placeholder">Person Name</span>
    // </label>
    // <label class="custom-field one">
    //     <input class="contact-location" type="text" name="contact-location" required/>
    //     <span class="placeholder">Location</span>
    // </label>
    // </div>
    // `;

    const travelDetail = document.createElement('div')
    travelDetail.classList.add('interact-detail');
    // const btnHis = document.createElement('div');
    // btnHis.setAttribute('data-toggle', 'tooltip');
    // btnHis.setAttribute('data-placement', 'top');
    // btnHis.setAttribute('title', 'delete this data');
    // btnHis.classList.add('remove-container');
    // const btnHisIcon = document.createElement('i');
    // btnHisIcon.classList.add('fas');
    // btnHisIcon.classList.add('fa-minus-circle');
    // btnHis.appendChild(btnHisIcon);
    travelDetail.appendChild(btnStr);
    const inputIDHidden = document.createElement('input');
    inputIDHidden.type = 'hidden';
    inputIDHidden.classList.add('interact-id');
    inputIDHidden.name = 'interact-id';
    inputIDHidden.value = id;
    const inputDate = document.createElement('input');
    inputDate.type = 'date';
    inputDate.classList.add('interact-locationwhen');
    inputDate.name = 'contact-when';
    try {
        inputDate.valueAsDate = new Date(date)
    }catch{}
    const labelInputName = document.createElement('label');
    labelInputName.classList.add('custom-field');
    labelInputName.classList.add('one');

    const labelInputLoc = document.createElement('label');
    labelInputLoc.classList.add('custom-field');
    labelInputLoc.classList.add('one');

    const inputTextName = document.createElement('input');
    inputTextName.type = 'text';
    inputTextName.value = name;
    inputTextName.classList.add('contact-name');
    inputTextName.name = 'contact-name';
    inputTextName.setAttribute('required', true);

    const inputTextLoc = document.createElement('input');
    inputTextLoc.type = 'text';
    inputTextLoc.classList.add('contact-location');
    inputTextLoc.name = 'contact-location';
    inputTextLoc.value = loc;
    inputTextLoc.setAttribute('required', true);
    const spanTextName = document.createElement('span');
    spanTextName.classList.add('placeholder');
    spanTextName.textContent = 'Person\'s Name';
    const spanTextLoc = document.createElement('span');
    spanTextLoc.classList.add('placeholder');
    spanTextLoc.textContent = 'Location';

    travelHistory.appendChild(travelDetail);
    travelDetail.appendChild(inputIDHidden);
    travelDetail.appendChild(inputDate);
    labelInputName.appendChild(inputTextName);
    labelInputName.appendChild(spanTextName);
    travelDetail.appendChild(labelInputName);
    labelInputLoc.appendChild(inputTextLoc);
    labelInputLoc.appendChild(spanTextLoc);
    travelDetail.appendChild(labelInputLoc);
}

