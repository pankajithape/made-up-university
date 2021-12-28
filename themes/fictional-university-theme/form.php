<?php
/**
 * Template Name: Contact form
 */

get_header();
?>

<hr>
<hr>
<hr>
<div class='container'>
    <form method='POST'>
        <div class='form-group'>
            <label for='email'>Email address:</label>
            <input type='email' class='form-control' placeholder='Enter email' name='email'>
        </div>
        <div class='form-group'>
            <label for='pwd'>Name:</label>
            <input type='text' class='form-control' placeholder='Enter Name' name='names'>
        </div>
        <div class='form-group'>
            <label for='comment'>Comment:</label>
            <textarea class='form-control' rows='5' name='messages'></textarea>
        </div>
        <button type='submit' name='insert' class='btn btn-primary'>Submit</button>
    </form>

</div>

<?php
  if(isset($_POST['insert'])){
    global $wpdb;

    $a = $_POST['email'];
    $b = $_POST['names'];
    $c = $_POST['messages'];
  
    $sql = $wpdb->insert(
      'form_table',
      array(
        'email' => $a,
        'name' => $b,
        'message' => $c,
      )
      
    );

    if($sql == true){
      echo '<script> alert("Inserted") </script>';
    }else{
      echo '<script> alert("Not Inserted") </script>';
    }

    
  }
?>

<?php get_footer();
?>