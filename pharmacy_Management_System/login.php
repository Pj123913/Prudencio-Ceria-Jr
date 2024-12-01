<?php
    session_start();
    $sessionId = $_SESSION['id'] ?? '';
    $sessionRole = $_SESSION['role'] ?? '';
    if ( $sessionId && $sessionRole ) {
        header( "location:index.php" );
        die();
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        *,
*::before,
*::after {
  margin: 0;
  padding: 0;
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
}

body {
  font-family: "Raleway", sans-serif;
}

a {
  text-decoration: none !important;
}

button:focus,
button:active .btn:active .btn.active {
  outline: 0px !important;
  -webkit-box-shadow: none !important;
          box-shadow: none !important;
}

.main {
  height: 100vh;
  width: 100%;
  background: #3f5efb;
  background: radial-gradient(circle, #3b57e2 0%, #c53652 100%);
}

.main__form {
  position: absolute;
  width: 600px;
  padding: 5rem 3rem;
  -webkit-box-shadow: 0 0.25rem 2.75rem 0 white;
          box-shadow: 0 0.25rem 2.75rem 0 white;
  top: 50%;
  -webkit-transform: translate(-50%, -50%);
          transform: translate(-50%, -50%);
  left: 50%;
}

.main__form--title {
  font-size: 30px;
  font-weight: bold;
  padding: 10px 0;
  color: #fff;
}

.main__form .input {
  position: relative;
  display: block;
}

.main__form .input #left {
  color: #4e73df;
  border-color: #ccc;
  -webkit-transition: border-color 0.5s;
  transition: border-color 0.5s;
  left: 5px;
  padding-right: 3px;
  border-right-width: 1px;
  border-right-style: solid;
  position: absolute;
  top: 5px;
  width: 40px;
  height: 40px;
  font-size: 18px;
  line-height: 40px;
  text-align: center;
}

.main__form .input .right {
  color: #4e73df;
  border-color: #ccc;
  -webkit-transition: border-color 0.5s;
  transition: border-color 0.5s;
  right: 5px;
  padding-right: 3px;
  border-left-width: 1px;
  border-left-style: solid;
  position: absolute;
  top: 5px;
  width: 40px;
  height: 40px;
  cursor: pointer;
  font-size: 18px;
  line-height: 40px;
  text-align: center;
}

.main__form .input input,
.main__form .input select {
  padding-left: 50px !important;
  display: block;
  width: 100%;
  height: 50px !important;
  padding: 8px 10px;
  margin: 10px 0;
  outline: none;
  border: 2px solid #ccc;
  background: #f4f4f4;
  color: #384047;
  -webkit-appearance: normal;
     -moz-appearance: normal;
          appearance: normal;
  -webkit-transition: 0.5s ease;
  transition: 0.5s ease;
  color: #384047;
  font-weight: 500;
  letter-spacing: 1px;
}

.main__form .input input::-webkit-input-placeholder,
.main__form .input select::-webkit-input-placeholder {
  -webkit-transition: 0.5s ease;
  transition: 0.5s ease;
  color: #384047;
  font-weight: 500;
  letter-spacing: 1px;
}

.main__form .input input:-ms-input-placeholder,
.main__form .input select:-ms-input-placeholder {
  -webkit-transition: 0.5s ease;
  transition: 0.5s ease;
  color: #384047;
  font-weight: 500;
  letter-spacing: 1px;
}

.main__form .input input::-ms-input-placeholder,
.main__form .input select::-ms-input-placeholder {
  -webkit-transition: 0.5s ease;
  transition: 0.5s ease;
  color: #384047;
  font-weight: 500;
  letter-spacing: 1px;
}

.main__form .input input::placeholder,
.main__form .input select::placeholder {
  -webkit-transition: 0.5s ease;
  transition: 0.5s ease;
  color: #384047;
  font-weight: 500;
  letter-spacing: 1px;
}

.main__form .input input:focus, .main__form .input input:hover,
.main__form .input select:focus,
.main__form .input select:hover {
  border: 2px solid #36b9cc;
  -webkit-transition: all 0.5s ease;
  transition: all 0.5s ease;
  color: #384047;
  background-color: #f4f4f4;
  -webkit-box-shadow: inset 3px 5px 5px 0 rgba(0, 0, 0, 0.1);
          box-shadow: inset 3px 5px 5px 0 rgba(0, 0, 0, 0.1);
}

.main__form input[type="submit"] {
  width: 100%;
  letter-spacing: 1px;
  font-weight: bold;
  font-size: 20px;
  color: #fff;
  text-align: center;
  margin-top: 10px;
  padding: 14px 0;
  -webkit-transition: 0.5s ease;
  transition: 0.5s ease;
  border: 1px solid #4e73df;
  background-color: #4e73df;
}

.main__form input[type="submit"]:hover {
  color: #36b9cc;
  background-color: #fff;
  font-weight: 800;
  letter-spacing: 3px;
}

*,
*::before,
*::after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: "Raleway", sans-serif;
}

a {
  text-decoration: none !important;
}

button:focus,
button:active .btn:active .btn.active {
  outline: 0px !important;
  box-shadow: none !important;
}

.main {
  height: 100vh;
  width: 100%;
  background: rgb(63, 94, 251);
  background: radial-gradient(
    circle,
    rgb(59, 87, 226) 0%,
    rgb(197, 54, 82) 100%
  );

  &__form {
    position: absolute;
    width: 600px;
    padding: 5rem 3rem;
    box-shadow: 0 0.25rem 2.75rem 0 rgba(255, 255, 255, 1);
    top: 50%;
    transform: translate(-50%, -50%);
    left: 50%;
    &--title {
      font-size: 30px;
      font-weight: bold;
      padding: 10px 0;
      color: #fff;
    }

    .input {
      position: relative;
      display: block;

      #left {
        color: #4e73df;
        border-color: #ccc;
        transition: border-color 0.5s;
        left: 5px;
        padding-right: 3px;
        border-right-width: 1px;
        border-right-style: solid;
        position: absolute;
        top: 5px;
        width: 40px;
        height: 40px;
        font-size: 18px;
        line-height: 40px;
        text-align: center;
      }

      .right {
        color: #4e73df;
        border-color: #ccc;
        transition: border-color 0.5s;
        right: 5px;
        padding-right: 3px;
        border-left-width: 1px;
        border-left-style: solid;
        position: absolute;
        top: 5px;
        width: 40px;
        height: 40px;
        cursor: pointer;
        font-size: 18px;
        line-height: 40px;
        text-align: center;
      }

      input,
      select {
        padding-left: 50px !important;
        display: block;
        width: 100%;
        height: 50px !important;
        padding: 8px 10px;
        margin: 10px 0;
        outline: none;
        border: 2px solid #ccc;
        background: #f4f4f4;
        color: #384047;
        appearance: normal;

        transition: 0.5s ease;
        color: #384047;
        font-weight: 500;
        letter-spacing: 1px;

        &::placeholder {
          transition: 0.5s ease;
          color: #384047;
          font-weight: 500;
          letter-spacing: 1px;
        }

        &:focus,
        &:hover {
          border: 2px solid #36b9cc;
          transition: all 0.5s ease;
          color: #384047;
          background-color: #f4f4f4;
          box-shadow: inset 3px 5px 5px 0 rgba(0, 0, 0, 0.1);
        }
      }
    }

    input[type="submit"] {
      width: 100%;
      letter-spacing: 1px;
      font-weight: bold;
      font-size: 20px;
      color: #fff;
      text-align: center;
      margin-top: 10px;
      padding: 14px 0;
      transition: 0.5s ease;
      border: 1px solid #4e73df;
      background-color: #4e73df;

      &:hover {
        color: #36b9cc;
        background-color: #fff;
        font-weight: 800;
        letter-spacing: 3px;
      }
    }
  }
}
</style>

    <title>Dashboard</title>
</head>

<body>

  
    <section class="main">
        <div class="container">

            <div class="main__form">
                <div class="main__form--title text-center">Log In</div>
                <form action="login_core.php" method="GET">
                    <div class="form-row">
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-envelope left"></i>
                                <input type="text" name="email" placeholder="Email" required>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-key"></i>
                                <input id="pwdinput" type="password" name="password" placeholder="Password" required>
                                <i id="pwd" class="fas fa-eye right"></i>
                            </label>
                        </div>
                        <div class="col col-12">
                            <label class="input">
                                <i id="left" class="fas fa-male left"></i>
                                <select name="role" id="Role">
                                    <option value="admins">Admin</option>
                                    <option value="managers">Manager</option>
                                    <option value="pharmacists">Pharmacist</option>
                                    <option value="salesmans">Salesman</option>
                                </select>
                            </label>
                        </div>
                            <input type="hidden" name="action" value="login">
                            <?php if ( isset( $_REQUEST['error'] ) ) {
                                    echo "<h5 class='text-center' style='color:red;'>Email, Password & Role Doesn't match Or Something is Wrong</h5>";
                            }?>
                        <div class="col col-12">
                        <input type="submit" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

   
    <script src="assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="./assets/js/app.js"></script>
</body>

</html>
