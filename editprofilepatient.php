<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();
if(!$user_home->is_logged_in())
{
    $user_home->redirect('index.php');
}

$userID = $_SESSION['userSession'];

$stmt = $user_home->runQuery("SELECT * FROM users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$query = $user_home->runQuery("SELECT * FROM users WHERE userID = $userID ");
$query->execute(array($_SESSION['userSession']));
$row2 = $query->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['btn-save']))
{
    $name = trim($_POST['name']);
    $birth_date = trim($_POST['birth_date']);
    $sex = trim($_POST['sex']);
    $ethnicity = trim($_POST['ethnicity']);
    $address = trim($_POST['address']);
    $phone_no = trim($_POST['phone_no']);

    if($user_home->updateUser($userID, $name, $sex, $address, $phone_no) && $user_home->updatePatient($userID, $birth_date, $ethnicity))
    {
        echo " yay you did it";
        $user_home->redirect('home.php');
    }
    else
    {
        die("fml you failed");
    }

}
?>

<!doctype html>
<html>


<head>
    <title>Profile Information</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="main2.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
</head>

<body>

<div class="container">
    <div class="backer">
        <center><img src="SH_T_trimmed.png" class="img-rounded" alt="Cinque Terre" width="304" height="236"></center>
    </div>

    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">Profile</a></li>
        <li role="presentation"><a href="searchapp.php">Search for Appointment</a></li>
        <li role="presentation"><a href="medicalhistory.html">Medical History</a></li>
        <li role="presentation"><a href="logout.php">Logout</a></li>

        <p class="navbar-text">Signed in as <?php echo $row2['userName']; ?></p>
    </ul>

    <ol class="breadcrumb">
        <br>
        <li><a href="#">Edit Profile Information</a></li>
        <li><a href="home.php">View Profile</a></li>
        <br><br>

        <form action="" method="POST">
        <!-- Profile Information: User input -->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Username:</label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo $row2['userName']; ?>
                </p>
                <small id="helpInline" class="text-muted">
                    (If you need to change your username, please contact the administrator)
                </small>
            </div>
        </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Email:</label>
                <div class="col-sm-10">
                    <p class="form-control-static"><?php echo $row2['userEmail']; ?>
                    </p>
                    <small id="helpInline" class="text-muted">
                        (If you need to change your email, please contact the administrator)
                    </small>
                </div>
            </div>

        <div class="form-group row">
            <label for="nameInput" class="col-sm-2 col-sm-form-label">Full Name:</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" placeholder="Enter your full name" name="name" required>
            </div>
        </div>

        <!-- ADD DATE PICKER LATER TO MAKE ENTRY FANCY -->
        <div class="form-group row">
            <label for="birthdayInput" class="col-sm-2 col-sm-form-label">Date of Birth:</label>
            <div class="col-sm-4">
                <input class="form-control" type="date" name="birth_date" id="example-name-input" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="sexInput" class="col-sm-2 col-sm-form-label">Sex:</label>
            <div class="col-sm-4">
                <label class="radio-inline"><input type="radio" name="sex" <?php if (isset($sex) && $sex=="male") echo "checked";?> value="Male" required>Male</label>
                <label class="radio-inline"><input type="radio" name="sex" <?php if (isset($sex) && $sex=="female") echo "checked";?> value="Female">Female</label>
            </div>
        </div>

        <!-- COULD USE DROP DOWN MENU -->
        <div class="form-group row">
            <label for="REInput" class="col-sm-2 col-sm-form-label">Ethnicity:</label>

            <div class="col-sm-4">
                <select name="ethnicity">
                    <option value="African">African</option>
                    <option value="Hispanic/Latino">Hispanic/Latino</option>
                    <option value="Native American">Native American</option>
                    <option value="Pacific Islander/Hawaiian">Pacific Islander/Hawaiian</option>
                    <option value="White">White</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="addressInput" class="col-sm-2 col-sm-form-label">Street Address:</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="address" placeholder="Enter your full address" id="example-name-input" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="phoneInput" class="col-sm-2 col-sm-form-label">Phone Number:</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="phone_no" placeholder="Enter your phone number" id="example-name-input" required>
            </div>
        </div>

        <button class="btn btn-info" type="submit" name='btn-save'>Save Profile</button>
        </form>
    </ol>
</div>

</div>


</div>
</div>

</body>


</html>