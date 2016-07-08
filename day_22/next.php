<html>

<?php

    session_start();
    echo $_SESSION['username']; ?><br><?php
    echo $_SESSION['email']; ?><br><?php
    echo $_SESSION['country']; ?><br><?php
    echo $_SESSION['profpic']; ?><br><?php
    if($_SESSION['profpic'] == ''){

    }
    else{?>
        <img style = "width: 15%;" src="uploads2/<?php echo $_SESSION['profpic']; ?>">
    <?php } ?>


</html>