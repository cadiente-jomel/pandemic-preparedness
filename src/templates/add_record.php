<div class="modal fade" data-backdrop="static" id="add-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Record</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <form class="add-form" action="../includes/create_record.php" method="POST" style="width: 100%">
                <div class="personal-info-container info-container">
                    <h4>Personal Info</h4>

                    <label class="custom-field one">
                        <input class="first-name" type="text" name="first-name" required/>
                        <span class="placeholder">First name</span>
                    </label>
                    <label class="custom-field one">
                        <input class="last-name" type="text" name="last-name" required/>
                        <span class="placeholder">Last name</span>
                    </label>
                    
                    <label class="custom-field one">
                        <input class="age" type="number" name="age" required/>
                        <span class="placeholder">Age</span>
                    </label>
                    <label class="custom-field one">
                        <input class="occupation" type="text" name="occupation" required/>
                        <span class="placeholder">Occupation</span>
                    </label>
                    <label class="custom-field one">
                        <input class="address" type="text" name="address" required/>
                        <span class="placeholder">Address</span>
                    </label>
                </div>
                

                <div class="covid-info-container info-container">
                    <h4>Covid Information</h4>

                    <label class="custom-field one">
                        <input class="days" type="number" name="days" required/>
                        <span class="placeholder">No of days of Quarantine</span>
                    </label>
                    <!--<div class="custom-select" style="width:100%;">
                    <span class="previous text-hide">Previous data recorded: <span class="previous-value">Nah</span></span> -->
                    <div class="select-container">
                        <select name="covid-status"
                        class="covid-status">
                          <option value="NA">Covid Status:</option>
                          <option value="Positive">Positive</option>
                          <option value="Negative">Negative</option>
                          <option value="Under Investigation">Under Investigation</option>
                       
                        </select>
                    <!-- </div> -->
                    
                    
                    
                    <!-- <div  class="custom-select" style="width:100%;">
                    <span class="previous text-hide">Previous data recorded: <span class="previous-value">Nah</span></span> -->
                        <select name="covid-case"
                        class="covid-case">
                          <option value="NA">Covid case:</option>
                          <option value="Asymptomatic">Asymptomatic</option>
                          <option value="Symptomatic">Symptomatic</option>
                       
                        </select>
                    <!-- </div> -->
                    <!-- <div class="custom-select" style="width:100%;">
                    <span class="previous text-hide">Previous data recorded: <span class="previous-value">Nah</span></span> -->
                        <select name="civil-status" class="civil-status" >
                          <option value="NA">Civil Status:</option>
                          <option value="Married">Married</option>
                          <option value="Widow">Widow</option>
                          <option value="Single">Single</option>
                       
                        </select>
                    
                    
                    </div>
                    <!-- </div> -->
                </div>

                <!-- ? covid travel histroy and interaction -->
                <div class="travel-history-container info-container">
                    <h4 class="mb-5">Travel Histroy</h4>
                    <!-- <div class="travel-detail">
                        <input type="date" id="locationwhen1" name="when">
                        <input type="date"  class="locationwhen" name="travel-when">
                        <label class="custom-field one">
                            <input class="travel-location" type="text" name="travel-location" required/>
                            <span class="placeholder" >Location</span>
                        </label>
                    </div> -->

                    <div class="travel-record-more">
                        <i class="fas fa-plus"></i>
                    </div>
                </div>
                

                <div class="interact-history-container info-container">
                    <h4 class="mb-5">Person Interacted</h4>
                    <!-- <div class="interact-detail">
                        <input type="date" id="locationwhen1" name="when">
                        <input type="date"  class="interact-locationwhen" name="contact-when">
                        <label class="custom-field one">
                            <input class="contact-name" name="contact-name" type="text" required/>
                            <span class="placeholder">Person's Name</span>
                        </label>
                        <label class="custom-field one">
                            <input class="contact-location" name="contact-location" type="text" required/>
                            <span class="placeholder">Location</span>
                        </label>
                    </div> -->

                    <div class="interact-record-more">
                        <i class="fas fa-plus"></i>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn secondary-btn modal-close" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn primary-btn">Save changes</button>
        </div>
            </form>
      </div>
    </div>
  </div>


<div class="modal modal-confirm" id="history-modal"tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Row</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <div class="modal-body">
                <p>Deleting this record will result to data lost are you sure you want to continue?</p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-cancel" data-bs-dismiss="modal">Cancel</button>
                <a href="../includes/delete_record.php" type="button" class="btn btn-primary btn-confirm-delete">Confirm</a>
            </div>
        </div>
    </div>
</div>