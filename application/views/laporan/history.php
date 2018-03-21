<div class="col-md-12 mb-4 mt-4">
    <?php
        if($this->session->userdata('adminRole') == TRUE):
            echo'<div class="alert alert-info" role="alert">';
            echo $this->session->userdata('adminRole');
            echo "</div>";
        endif;
    ?>
    <div class="jumbotron">
        <h1>Logged On!! History</h1>
        <?php
            echo "<pre>";
            print_r($this->session->all_userdata());
            echo "</pre>";
        ?>
    </div>
</div>
