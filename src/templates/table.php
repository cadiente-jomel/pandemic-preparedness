
<table class="table-record">
    <tr class="table-row" id="table-header">
        <th class="table-header">ID</th>
        <th class="table-header">Full name</th>
        <th class="table-header">Age</th>
        <th class="table-header">Address</th>
        <th class="table-header">PUI</th>
        <th class="table-header">Action</th>
        </tr>
    <?php 
        include('../includes/db.ini.php');
        include('../includes/select.php');
    
    
    ?>
    <div class="modal modal-confirm" id="confirm-modal"tabindex="-1">
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
    <!-- <tr class="table-row">
    //     <td class="table-data">Jomel Cadiente</td>
    //     <td class="table-data">20</td>
    //     <td class="table-data">Purok 5</td>
    //     <td class="table-data"><i class="negative fas fa-times-circle"></i></td>
    //     <td class="table-data"><a href="#"><i class="far fa-edit"></i></a> | <a href="#"><i class="fas fa-trash"></i></a></td>
    // </tr> -->
</table>

