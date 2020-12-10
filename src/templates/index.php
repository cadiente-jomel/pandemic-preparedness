<?php 
    include('base.php');
?>

            <!-- ? end of navigation place holder -->

            <!-- ? top section add-record, filter, and search -->
            <div class="header-container">
                <div class="header-section">
                    <h1 class="header-text">Pandemic Preparedness</h1>
                </div>

                <div class="header-action-container">
                    <div class="header-action">
                        <button class="primary-btn mr-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Add Record
                            <i class="fas fa-user-plus"></i>
                        </button>
                        <div class="select-box">
                            <div class="selected">Filter Record by</div>
                            

                            <div class="options-container">
                                <div class="option">
                                    <input
                                        type="radio"
                                        class="radio"
                                        id="automobiles"
                                        name="category"
                                    />
                                    <label for="automobiles"
                                        >Patience Under Investigation</label
                                    >
                                </div>

                                <div class="option">
                                    <input
                                        type="radio"
                                        class="radio"
                                        id="film"
                                        name="category"
                                    />
                                    <label for="film">Recent Record</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="search-container">
                        <form class="search-form" action="" method="GET">
                            <div class="search-outer">
                                <input
                                    type="text"
                                    name="search-value"
                                    id="search-value"
                                    class="search-input"
                                    placeholder="Seach..."
                                />
                            </div>
                            <input
                                class="primary-btn"
                                type="submit"
                                value="Search"
                            />
                        </form>
                    </div>
                </div>
            </div>
            <!-- ? end of top section add-record, filter, and search -->

            <!-- ? body-data  -->
            <main class="main-container">
                <div class="left">

                <?php 
                
                    include('./table.php')
                ?>
                    <!-- <table>
                        <tr class="table-row" id="table-header">
                            <th class="table-header">Full name</th>
                            <th class="table-header">Age</th>
                            <th class="table-header">Address</th>
                            <th class="table-header">PUI</th>
                            <th class="table-header">Action</th>
                        </tr>
                        <tr class="table-row">
                            <td class="table-data">Jomel Cadiente</td>
                            <td class="table-data">20</td>
                            <td class="table-data">Purok 5</td>
                            <td class="table-data"><i class="negative fas fa-times-circle"></i></td>
                            <td class="table-data"><a href="#"><i class="far fa-edit"></i></a> | <a href="#"><i class="fas fa-trash"></i></a></td>
                        </tr>

                    
              
                    </table> -->
                </div>
                <div class="right">
                    <div class="citizen-profile">
                        <div class="citizen-img-container">
                          <img src="https://www.adobe.com/content/dam/cc/us/en/creativecloud/photography/discover/portrait-photography/CODERED_B1_portrait_photography-P4a_438x447.jpg.img.jpg" alt="" class="citizen-img">
                        </div>
                    <div class="citizen-data">
                        <div class="br profile-select-box select-box">
                            <div class="profile-selected selected">View Travel History</div>
                            

                            <!-- <div class="options-container profile-options-container"> -->
                            <!-- <p>Record for this person not found...</p>
                                <div class="t-option option">
                                    <div class="option-left">
                                        <p>Dec 07, 2020</p>
                                    </div>
                                    <div class="option-right">
                                        <p>Barangay 1 San Mateo, Isabela</p>
                                    </div>
                                </div>

                                <div class="t-option option">
                                    <div class="option-left">
                                        <p>Dec 07, 2020</p>
                                    </div>
                                    <div class="option-right">
                                        <p>Barangay 1 San Mateo, Isabela</p>
                                    </div>
                                </div>

                                <div class="t-option option">
                                    <div class="option-left">
                                        <p>Dec 07, 2020</p>
                                    </div>
                                    <div class="option-right">
                                        <p>Barangay 1 San Mateo, Isabela</p>
                                    </div>
                                </div> -->
                            <?php 
                                include('./travel_user.php');
                            ?>
                            <!-- </div> -->
                        </div>
                        <div class="br profile-select-box select-box">
                            <div class="profile-selected selected">View Person Interacted</div>
                            
                            <?php 
                            
                                include('./contact_user.php');
                            ?>

                            <!-- <div class="options-container profile-options-container">
                                <div class="interact-option">
                                    <div class="interact-option-left">
                                        <p>Dec 07, 2020</p>
                                    </div>
                                    <div class="interact-option-middle">
                                        <p>John Bravo</p>
                                    </div>
                                    <div class="interact-option-right">
                                        <span></span>
                                        <span>Barangay 1 San Mateo, Isabela</span>
                                    </div>
                                </div>

                                <div class="interact-option">
                                    <div class="interact-option-left">
                                        <p>Dec 07, 2020</p>
                                    </div>
                                    <div class="interact-option-middle">
                                        <p>Susan William</p>
                                    </div>
                                    <div class="interact-option-right">
                                        <p>Villa Magat San Mateo, Isabela</p>
                                    </div>
                                </div>

                                <div class="interact-option">
                                    <div class="option-left">
                                        <p>Dec 07, 2020</p>
                                    </div>
                                    <div class="interact-option-middle">
                                        <p>Daniel Crisostomo</p>
                                    </div>
                                    <div class="interact-option-right">
                                        <p>Old Centro 1 San Mateo, Isabela</p>
                                    </div>
                                </div>

                            </div> -->
                        </div>
                        <div class="citizen-profile-information">
                        <?php
                        
                            // include('./about_user.php');
                        ?>
                            <!-- <div class="citizen-personal-info">
                                <ul class="personal-info">
                                    <li>First Name: <span clsas="info-first">Susan</span></li>
                                    <li>Last Name: <span clsas="info-last">Williams</span></li>
                                    <li>Status: <span clsas="info-status">Positive</span></li>
                                    <li>Day of Quarantine: <spa clsas="info-day">14days</spa></li>
                                    <li>Age: <span clsas="info-age">25</span></li>
                                    <li>Occupation: <span clsas="info-occupation">Stock Investor</span> </li>
                                    <li>Civil Status: <span clsas="info-civil">Single</span></li>
                                    <li>Covid Case: <span clsas="info-case">Asymptomatic</span></li>
                                </ul>
                            </div> -->
                        </div>
                    </div>
            </main>
            <!-- ? end of body-data -->

            <!-- ? modal -->
           <!-- Button trigger modal -->
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Record</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <form action="" method="post" style="width: 100%">
                <div class="personal-info-container info-container">
                    <h4>Personal Info</h4>

                    <label class="custom-field one">
                        <input type="text" required/>
                        <span class="placeholder">First name</span>
                    </label>
                    <label class="custom-field one">
                        <input type="text" required/>
                        <span class="placeholder">Last name</span>
                    </label>
                    
                    <label class="custom-field one">
                        <input type="text" required/>
                        <span class="placeholder">Age</span>
                    </label>
                    <label class="custom-field one">
                        <input type="text" required/>
                        <span class="placeholder">Occupation</span>
                    </label>
                </div>
                

                <div class="covid-info-container info-container">
                    <h4>Covid Information</h4>

                    <label class="custom-field one">
                        <input type="text" required/>
                        <span class="placeholder">No of days of Quarantine</span>
                    </label>
                    <div class="custom-select" style="width:100%;">
                        <select>
                          <option value="0">Covid Status:</option>
                          <option value="1">Positive</option>
                          <option value="2">Negative</option>
                          <option value="3">Under Investigation</option>
                       
                        </select>
                    </div>
                    
                    
                    
                    <div class="custom-select" style="width:100%;">
                        <select>
                          <option value="0">Covid case:</option>
                          <option value="1">Asymptomatic</option>
                          <option value="2">Symptomatic</option>
                       
                        </select>
                    </div>
                    <div class="custom-select" style="width:100%;">
                        <select>
                          <option value="0">Civil Status:</option>
                          <option value="1">Married</option>
                          <option value="2">Widow</option>
                          <option value="3">Single</option>
                       
                        </select>
                    </div>
                </div>

                <!-- ? covid travel histroy and interaction -->
                <div class="travel-history-container info-container">
                    <h4 class="mb-5">Travel Histroy</h4>
                    <div class="travel-detail">
                        <!-- <input type="date" id="locationwhen1" name="when"> -->
                        <input type="date"  class="locationwhen" name="when">
                        <label class="custom-field one">
                            <input type="text" required/>
                            <span class="placeholder">Location</span>
                        </label>
                    </div>

                    <div class="travel-record-more" onclick="more()">
                        <i class="fas fa-plus"></i>
                    </div>
                </div>
                

                <div class="interact-history-container info-container">
                    <h4 class="mb-5">Person Interacted</h4>
                    <div class="interact-detail">
                        <!-- <input type="date" id="locationwhen1" name="when"> -->
                        <input type="date"  class="interact-locationwhen" name="when">
                        <label class="custom-field one">
                            <input type="text" required/>
                            <span class="placeholder">Location</span>
                        </label>
                    </div>

                    <div class="interact-record-more" onclick="interactMore()">
                        <i class="fas fa-plus"></i>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn secondary-btn" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn primary-btn">Save changes</button>
        </div>
      </div>
    </div>
  </div>
            <!-- ? end of modal -->
        </div>

<?php 

    include('footer.php');
?>