<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/Product.php'; ?>

        <div class="grid_10">
            <div class="box round first grid">
                <h2>Update Schedule</h2>
                <div class="block copyblock"> 
                    
                    
                    <form action="" method="post">
                        <table class="form">                    
                            <tr>
                                <td>
                                    <input id="date" type="text" name="date" id="date">
                                </td>
                            </tr>
                            <tr> 
                                <td>
                                    <input type="submit" name="submit" Value="Save" />
                                </td>
                            </tr>
                        </table>
                    </form>
                    
                </div>
            </div>
        </div>
       <script>
           $( "#date" ).datepicker();
       </script> 
<?php include 'inc/footer.php'; ?>