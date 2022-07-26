<div id="container">
    <div id="links_container">


        <div class="home">
            <a href="finance_officer_home.php"><img src="../../image/about.jpg" alt=""></a>
        </div>
        
        <div id="btn_group">

            <div class="btn-group">
                <button type="button" class=" dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">
                    voucher
                </button>
                <div class="dropdown-menu">
                <a class="dropdown-item" href="class_voucher_generate_form.php">generate class voucher</a>
                <a class="dropdown-item" href="class_voucher_details_form.php">voucher details</a>
                <a class="dropdown-item" href="student_number_in_voucher_form.php">number of student in voucher</a>
                <a class="dropdown-item" href="add_student_to_voucher_form.php">add student to voucher</a>
                </div>
            </div>
            
            <div class="btn-group">
                <button type="button" class="dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">payment
                </button>
                <div class="dropdown-menu">
                <a class="dropdown-item" href="student_school_fees_payment_form.php">fees payment</a>
                <a class="dropdown-item" href="class_school_fees_detail_form.php">class fees details</a>
                <a class="dropdown-item" href="single_student_school_fees_detail_form.php">single student fees details</a>
                </div>
            </div>

            <div class="btn-group">
                <button type="button" class="dropdown-toggle dropdown-toggle-split" data-toggle="dropdown">transaction
                </button>
                <div class="dropdown-menu">
                <a class="dropdown-item" href="deposit_form.php">deposit</a>
                <a class="dropdown-item" href="withdrawer_form.php">withdraw</a>
                <a class="dropdown-item" href="deposit_details_form.php">deposit details</a>
                <a class="dropdown-item" href="withdraw_details_form.php">withdraw details</a>
                </div>
            </div>

            


            

            

            <div class="btn-group">
                <a href="action_php/finance_officer_logout_action.php" class="logout">logout</a>
                
            </div>

        </div>

    </div>

</div>


<style>
    .home a img{
        width: 30px;
        height: 30px;
        border-radius: 100%; 
    }
</style>