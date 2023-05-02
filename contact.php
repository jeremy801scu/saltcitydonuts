<?php
	//Create Session
	if (!isset($_SESSION)) {
		session_start();
	}

    //Create variables to hold form data and errors
    $nameErr = $emailErr = $contBackErr = $phoneErr = "";
    $name = $email = $contBack = $comment = $phone = "";
    $formErr = false;

    //Validate form when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty(trim($_POST["name"]))) {
            $nameErr = "Name is required.";
            $formErr = true;
        } else {
            $name = cleanInput($_POST["name"]);
            //Use REGEX to accept only letters and white spaces
            if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                $nameErr = "Only letters and standard spaces allowed.";
                $formErr = true;
            }
        }

        if (empty($_POST["email"])) {
            $emailErr = "Email is required.";
            $formErr = true;
        } else {
            $email = cleanInput($_POST["email"]);
            // Check if e-mail address is formatted correctly
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Please enter a valid email address.";
                $formErr = true;
            }
        }

        if (!empty($_POST["phone"])) {
          $phone = cleanInput($_POST["phone"]);
          //Use REGEX to accept only digits and some special characters
          if (!preg_match("/^[0-9\-\+\(\)\s]*$/",$phone)) {
              $phoneErr = "Invalid phone number format.";
              $formErr = true;
          }
      }

        if (empty($_POST["contact-back"])) {
            $contBackErr = "Please let us know if we can contact you back.";
            $formErr = true;
        } else {
            $contBack = cleanInput($_POST["contact-back"]);
        }

        $comment = cleanInput($_POST["comments"]);
    }

    //Clean and sanitize form inputs
    function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /**
     * If no form errors occur, 
     * send the data to the database
     */
    if (($_SERVER["REQUEST_METHOD"] == "POST") && (!($formErr))){
		//Create Connection Variables
        $hostname = "php-mysql-exercisedb.slccwebdev.com";
        $username = "phpmysqlexercise";
        $password = "mysqlexercise";
        $databasename = "php_mysql_exercisedb";

        try {
            //Create new PDO Object with connection parameters
            $conn = new PDO("mysql:host=$hostname;dbname=$databasename",$username, $password);

            //Set PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

            $sql = "INSERT INTO Users_JeremySCD (name, email, contactBack, phone, comments) VALUES (:name, :email, :contactBack, :phone, :comment);";

            //Variable containing SQL command
            $stmt = $conn->prepare($sql);

            //Bind parameters
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':contactBack', $contBack, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);

            //Execute SQL statement on server
            $stmt->execute();

            //Build success message to display
            $_SESSION['message'] = '<p class="font-weight-bold">Thank you for your submission!</p><p class="font-weight-light" >Your request has been sent.</p>';

            $_SESSION['complete'] = true;

            //Redirect
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit;

        } catch (PDOException $error) {

            //Build error message to display
            $_SESSION['message'] =  "<p>We apologize, the form was not submitted successfully. Please try again later.</p>";
            // Uncomment code below to troubleshoot issues
            // echo '<script>console.log("DB Error: ' . addslashes($error->getMessage()) . '")</script>';
            $_SESSION['complete'] = true;
            //Redirect
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit;
        }

        $conn = null;
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="style.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2f1f1f7bb3.js" crossorigin="anonymous"></script>
    <title>Salt City Donuts</title>
</head>

<body id="menu-body">
    <nav class="navbar bg-body-tertiary sticky-top">
        <div class="container">
          <a class="navbar-brand logo" href="#">Salt City <span>Donuts</span>
          <img src="images/DL3.png" id="donutlogo" alt="donut"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                <a href="order.html" class="btn btn-primary">ORDER NOW</a>
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="index.html">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="menu.html">Menu</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="about.html">About</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="contact.php">Contact Us</a>
                </li>
              </ul>

              <div class="social-nav">
                <h1>FOLLOW US</h1>
                <ul>
                  <li><a href="https://twitter.com/?lang=en" id="social-twi"><i class="fa-brands fa-twitter"></i></a></li>
                  <li><a href="https://www.instagram.com/" id="social-gram"><i class="fa-brands fa-square-instagram"></i></a></li>
                  <li><a href="https://www.facebook.com/" id="social-face"><i class="fa-brands fa-facebook"></i></a></li>
                  <li><a href="https://www.yelp.com/" id="social-yelp"><i class="fa-brands fa-yelp"></i></a></li>
                </ul>
              </div>

            </div>
          </div>
        </div>
      </nav>

      <div class="menu-title">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Contact</h1>
                </div>
            </div>
        </div>
      </div>

      <div class="contact-form">
        <div class="container">
          <div class="row">

            <div class="col md 6">
                          			    <!-- Contact Form Section -->

				<section id="contact">
			<div class="container py-5">
				<!-- Section Title -->
				<div class="row justify-content-center text-center">
					<div class="col-md-6">
						<h2 class="display-4 font-weight-bold">Contact US</h2>
						<hr />
					</div>
				</div>
				<!-- Contact Form Row -->
				<div class="row justify-content-center">
					<div class="col-6">
					
						<!-- Contact Form Start -->
						<form id="contactForm" action=<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "#contact"); ?> method="POST" novalidate>
							
							<!-- Name Field -->
							<div class="form-group">
								<label for="name">Full Name:</label>
								<span class="text-danger">*<?php echo $nameErr; ?></span>
								<input type="text" class="form-control" id="name" placeholder="Full Name" name="name" value="<?php if(isset($name)) {echo $name;}?>"" />							
							</div>
							
							<!-- Email Field -->
							<div class="form-group">
								<label for="email">Email address:</label>
								<span class="text-danger">*<?php echo $emailErr; ?></span>
								<input type="email" class="form-control" id="email" placeholder="name@example.com" name="email" value="<?php if(isset($email)) {echo $email;} ?>" />
							</div>

              <div class="form-group">
								<label for="tel">Phone Number</label>
								<span class="text-danger">*<?php echo $phoneErr; ?></span>
								<input type="tel" class="form-control" id="tel" placeholder="555-555-5555" name="Phone" value="<?php if(isset($phone)) {echo $phone;} ?>" />
							</div>
							
							<!-- Radio Button Field -->
							<div class="form-group">
								<label class="control-label">Can we contact you back?</label>
								<span class="text-danger">*<?php echo $contBackErr; ?></span>
								<div class="form-check">
									<input type="radio" class="form-check-input" name="contact-back" id="yes" value="Yes"  <?php if ((isset($contBack)) && ($contBack == "Yes")) {echo "checked";}?>/>
									<label class="form-check-label" for="yes" >Yes</label>
								</div>
								<div class="form-check">
									<input type="radio" class="form-check-input" name="contact-back" id="no" value="No" <?php if ((isset($contBack)) && ($contBack == "No")) {echo "checked";}?>/>
									<label class="form-check-label" for="no" >No</label>
								</div>
							</div>
							
							<!-- Comments Field -->
							<div class="form-group">
								<label for="comments">Comments:</label>
								<textarea id="comments" class="form-control" rows="3" name="comments"><?php if (isset($comment)) {echo $comment;} ?></textarea>
							</div>

							<!-- Required Fields Note-->
							<div class="text-danger text-right">* Indicates required fields</div>
							
							<!-- Submit Button -->
							<button class="btn btn-primary mb-2" type="submit" role="button" name="submit">Submit</button>
						</form>						
					</div>
				</div>
			</div>

            <!-- Thank you Modal -->
			<div class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="thankYouModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h3 class="modal-title" id="thankYouModalLabel">Thank you!</h3>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<?php echo $_SESSION['message']; ?>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<!-- Show thank you message -->
		<?php 
            if (isset($_SESSION['complete']) && $_SESSION['complete']) {
                echo "<script>$('#thankYouModal').modal('show');</script>";
                session_unset(); 
            };
        ?>
            </div>

            <div class="col-md 6">
              HELLO
            </div>

          </div>
        </div>
      </div>


      <div class="home-now">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <p class="card-text">Donuts: the only circle of trust you'll ever need.</p>
                  <a href="order.html" class="btn btn-primary">Order Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
  
        <div class="home-footer">
          <div class="container">
            <div class="row">
              <div class="col-md-4" id="footer-about">
                <h4>About Us</h4>
                <p>Salt City Donuts is a community-driven donut shop serving up fresh, delicious donuts daily. Come and taste our unique flavors and experience the warmth of our friendly atmosphere.</p>
              </div>
              <div class="col-md-4" id="footer-contact">
                <h4>Contact Us</h4>
                <p>1234 Fake Street, Salt Lake City</p>
                <p>Phone: (801) 555-5555</p>
                <p>Email: fake@saltcitydonuts.com</p>
              </div>
              <div class="col-md-4" id="footer-social">
                <div class="social-header">
                  <h4>Follow Us</h4>
                </div>
                <div class="social-links">
                  <ul class="social-footer">
                    <li><a href="https://twitter.com/?lang=en" id="social-twi"><i class="fa-brands fa-twitter"></i></a></li>
                    <li><a href="https://www.instagram.com/" id="social-gram"><i class="fa-brands fa-square-instagram"></i></a></li>
                    <li><a href="https://www.facebook.com/" id="social-face"><i class="fa-brands fa-facebook"></i></a></li>
                    <li><a href="https://www.yelp.com/" id="social-yelp"><i class="fa-brands fa-yelp"></i></a></li>
                  </ul>
                </div>
              </div>
  
                <div class="copyright">
                  COPYRIGHT 2023, Mark Jeremy Johnson. All Rights Reserved.
                </div>
  
              </div>
            </div>
          </div>
        </div>
  
  
      <script src="script.js"></script>
      <script src="js/owl.carousel.min.js"></script>
      <script src="js/jquery-3.6.1.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
  </html>