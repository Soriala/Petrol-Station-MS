
<div class="card h-100 d-flex flex-column">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Maintenance</h3>
        <div class="card-tools align-middle">
            <!-- <button class="btn btn-dark btn-sm py-1 rounded-0" type="button" id="create_new">Add New</button> -->
        </div>
    </div>
    <div class="card-body flex-grow-1">
        <div class="col-12 h-100">
            <div class="row h-100">
                <div class="col-md-6 h-100 d-flex flex-column">
                    <div class="w-100 d-flex border-bottom border-dark py-1 mb-1">
                        <div class="fs-5 col-auto flex-grow-1"><b>Petrol Type List</b></div>
                        <div class="col-auto flex-grow-0 d-flex justify-content-end">
                            <a href="javascript:void(0)" id="new_petrol_type" class="btn btn-dark btn-sm bg-gradient rounded-2" title="Add Pertol Type"><span class="fa fa-plus"></span></a>
                        </div>
                    </div>
                    <div class="h-100 overflow-auto border rounded-1 border-dark">
                        <ul class="list-group">
                            <?php 
                            $cat_qry = $conn->query("SELECT * FROM `petrol_type_list` order by `name` asc");
                            while($row = $cat_qry->fetchArray()):
                            ?>
                            <li class="list-group-item d-flex align-items-center">
                                <div class="col-8 flex-grow-1">
                                    <?php echo $row['name'] ?> <small><span class="text-muted">Current Price: </span><?php echo number_format($row['price'],2) ?></small>
                                </div>
                                <div class="col-2 pe-2 text-end">
                                    <?php 
                                        if(isset($row['status']) && $row['status'] == 1){
                                            echo "<small><span class='badge rounded-pill bg-success'>Active</span></small>";
                                        }else{
                                            echo "<small><span class='badge rounded-pill bg-danger'>Inactive</span></small>";
                                        }
                                    ?>
                                </div>
                                <div class="col-2 d-flex justify-content-end">
                                    <a href="javascript:void(0)" class="view_petrol_type btn btn-sm btn-info text-light bg-gradient py-0 px-1 me-1" title="View Pertol Type Details" data-id="<?php echo $row['petrol_type_id'] ?>" ><span class="fa fa-th-list"></span></a>
                                    <a href="javascript:void(0)" class="edit_petrol_type btn btn-sm btn-primary bg-gradient py-0 px-1 me-1" title="Edit Pertol Type Details" data-id="<?php echo $row['petrol_type_id'] ?>"  data-name="<?php echo $row['name'] ?>"><span class="fa fa-edit"></span></a>
                                    <a href="javascript:void(0)" class="delete_petrol_type btn btn-sm btn-danger bg-gradient py-0 px-1" title="Delete Pertol Type" data-id="<?php echo $row['petrol_type_id'] ?>"  data-name="<?php echo $row['name'] ?>"><span class="fa fa-trash"></span></a>
                                </div>
                            </li>
                            <?php endwhile; ?>
                            <?php if(!$cat_qry->fetchArray()): ?>
                                <li class="list-group-item text-center">No data listed yet.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        // Pertol Type Functions
        $('#new_petrol_type').click(function(){
            uni_modal('Add New Pertol Type',"manage_petrol_type.php")
        })
        $('.edit_petrol_type').click(function(){
            uni_modal('Edit Pertol Type Details',"manage_petrol_type.php?id="+$(this).attr('data-id'))
        })
        $('.view_petrol_type').click(function(){
            uni_modal('Pertol Type Details',"view_petrol_type.php?id="+$(this).attr('data-id'))
        })
        $('.delete_petrol_type').click(function(){
            _conf("Are you sure to delete <b>"+$(this).attr('data-name')+"</b> from Pertol Type List?",'delete_petrol_type',[$(this).attr('data-id')])
        })
    })
    function delete_petrol_type($id){
        $('#confirm_modal button').attr('disabled',true)
        $.ajax({
            url:'./Actions.php?a=delete_petrol_type',
            method:'POST',
            data:{id:$id},
            dataType:'JSON',
            error:err=>{
                console.log(err)
                alert("An error occurred.")
                $('#confirm_modal button').attr('disabled',false)
            },
            success:function(resp){
                if(resp.status == 'success'){
                    location.reload()
                }else{
                    alert("An error occurred.")
                    $('#confirm_modal button').attr('disabled',false)
                }
            }
        })
    }
   
</script>
