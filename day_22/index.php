<html>

<head>
    <title>Web page</title>
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <script>
   function previewFile(){
       var preview = document.querySelector('img'); //selects the query named img
       var file    = document.querySelector('input[type=file]').files[0]; //sames as here
       var reader  = new FileReader();

       reader.onloadend = function () {
           preview.src = reader.result;
       }

       if (file) {
           reader.readAsDataURL(file); //reads the data as a URL
       } else {
           preview.src = "";
       }
  }

  previewFile();  //calls the function named previewFile()
  </script>
</head>

<?php

session_start();

$name = $email = $password = $confirmpassword = $country = $country = "";
$nameErr = $emailErr = $passwordErr = $agreeErr = "";
$flag = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $target_dir = "uploads2/";
	$target_file = $target_dir . basename($_FILES["file1"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    	//echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    	$uploadOk = 0;
	}
// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
    	echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
	}
	else {
    	if (move_uploaded_file($_FILES["file1"]["tmp_name"], $target_file)) {
    	} 
   		else {
        	//echo "Sorry, there was an error uploading your file.";
    	}
	}

    if (empty($_POST["username"])) {
        $nameErr = "Username is required";
    }
    else{
        $name = $_POST["username"]; 
        if(!preg_match("/^[a-zA-Z0-9]*$/", $name) || (strlen($name) < 4) || (strlen($name) > 12)){
            $nameErr = "Invalid Username";
        }
        else
                $flag++;
    }

    if (empty($_POST["email"])) {
        $emailErr = "E-mail is required";
    }
    else{
        $email = $_POST["email"];   
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
        else
            $flag++;
    }

    $password = htmlspecialchars($_POST["password"]);
    $confirmpassword = htmlspecialchars($_POST["confirmpassword"]);

    if (empty($_POST["email"]) && empty($_POST["email"])) {
        $passwordErr = "Password is required";
    }
    else{
        if($password !== $confirmpassword){
            $passwordErr = "Different passwords";
            $confirmpassword = "";
        }
        else if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{4,12}$/', $password)) {
                $passwordErr = 'Invalid password';
                $password = "";
        }
        else
            $flag++;
    }

    if ($nameErr == "" && $emailErr == "" && $passwordErr == "" && $agreeErr == "") {
        $_SESSION["username"] = $_POST["username"];
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["country"] = $_POST["country"];
        $_SESSION["profpic"] = $_FILES["file1"]["name"];
        header('Location: next.php');
    }
}


?>
  	<body>
        <div id = "blank"></div>
        <div id = "fill">
            <div id = "container">
                <h1>SPORTIFY.in</h1>
                <h2>Join Our Community</h2>
                <form id = "doc" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "post" enctype="multipart/form-data" onsubmit="return checkForm(this);">
                  <div class="image-upload">
                    <img src="assets/placeholder.png"/><br>
    					      <label class = "image" for="file1">
        					     <span>Upload Image</span>
    					      </label><br>
                    <input id="file1" name = "file1" type="file" value="Upload image" onchange="previewFile()"/>
                  </div>
					        <div class = "form1">
	                	<input class = "holder" type="text" name="username" placeholder = "Username" value = "<?php echo $name; ?>" >
	                    <span class = "error"><?php echo "$nameErr"; ?> </span>
	                    <br>
	                    <input class = "holder" type="text" name="email" placeholder = "Email ID" value = "<?php echo $name; ?>" >
	                    <span class = "error"><?php echo "$emailErr"; ?> </span>
	                    <br>
	                    <input class = "holder" type="password" name="password" placeholder = "Password" >
	                    <span class = "error"> <?php echo "$passwordErr"; ?> </span>
	                    <br>
	                    <input class = "holder" type="password" name="confirmpassword" placeholder = "Confirm Password"><br><br>
	                    <select class = "holder" name = "country">
	                        <option class = "country" selected disabled hidden>Select Country</option>
	                        <option class = "country" value="usa">United States of America</option>
	                        <option class = "country" value="canada">Canada</option>
	                    </select> <br><br>
	                    <input type="radio" id="agree" name="agree" />
	                    <label for="agree"><span class ="radiospan"></span>Agreed Terms &amp; Conditions</label>
	                    <button name="signup">SIGN UP</button>
	                </div>
                </form>
            </div>
            <div class = "footer">
                <p>Already joined with us? <a>LOGIN</a> </p>
            </div> 
        </div>
  	</body>

    <script type="text/javascript">

  function checkForm(form)
  {
    if(form.username.value == "") {
      alert("Error: Username cannot be blank!");
      form.username.focus();
      return false;
    }

    if(form.email.value == "") {
      alert("Error: E-mail cannot be blank!");
      form.username.focus();
      return false;
    }

    re = /^\w+$/;
    if(!re.test(form.username.value)) {
      alert("Error: Username must contain only letters and numbers!");
      form.username.focus();
      return false;
    }

    re = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
    if(!re.test(form.email.value)){
      alert("Error: Invalid email");
      form.email.focus();
      return false;
    }

    if(form.password.value != "" && form.password.value == form.confirmpassword.value) {
      if(form.password.value.length < 4) {
        alert("Error: Password must contain at least four characters!");
        form.password.focus();
        return false;
      }
      
      re = /[0-9]/;
      if(!re.test(form.password.value)) {
        alert("Error: password must contain at least one number!");
        form.password.focus();
        return false;
      }
      re = /[a-z]/;
      if(!re.test(form.password.value)) {
        alert("Error: password must contain at least one lowercase letter !");
        form.password.focus();
        return false;
      }
      re = /[A-Z]/;
      if(!re.test(form.password.value)) {
        alert("Error: password must contain at least one uppercase letter!");
        form.password.focus();
        return false;
      }

      re = /[!@#$%^&*()~_+}{]/;
      if(!re.test(form.password.value)) {
        alert("Error: password must contain at least one special character!");
        form.password.focus();
        return false;
      }
    } 
    else {
      alert("Error: Please check that you've entered and confirmed your password!");
      form.pwd1.focus();
      return false;
    }

    alert("You entered a valid password: " + form.pwd1.value);
    return true;
  }

</script>

    
</html>