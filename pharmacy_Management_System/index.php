<?php
    session_start();
    $sessionId = $_SESSION['id'] ?? '';
    $sessionRole = $_SESSION['role'] ?? '';
    echo "$sessionId $sessionRole";
    if ( !$sessionId && !$sessionRole ) {
        header( "location:login.php" );
        die();
    }

    ob_start();

    include_once "config.php";
    $connection = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
    if ( !$connection ) {
        echo mysqli_error( $connection );
        throw new Exception( "Database cannot Connect" );
    }

    $id = $_REQUEST['id'] ?? 'dashboard';
    $action = $_REQUEST['action'] ?? '';
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


.topber {
  position: fixed;
  width: 100%;
  top: 0;
  left: 0;
  padding-left: 300px;
  right: 0;
  z-index: 999;
  -webkit-box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
          box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
  background-color: #fff;
}

.topber__title {
  height: 12.5vh;
  float: left;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: normal;
      -ms-flex-direction: row;
          flex-direction: row;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  padding-left: 1rem;
}

.topber__title--text {
  font-size: 30px;
  font-weight: bold;
}

.topber__profile {
  height: 12.5vh;
  float: right;
  padding-right: 10px;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: normal;
      -ms-flex-direction: row;
          flex-direction: row;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  padding: 2rem;
}

.topber__profile--icon {
  color: #224abe;
  font-size: 20px;
}

.topber__profile button {
  color: #4e73df;
  line-height: 10px;
  font-weight: bold;
}

.topber__profile button:hover {
  color: crimson;
}

.topber__profile .dropdown-menu {
  margin-top: 10px;
  -webkit-box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
          box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.topber__profile .dropdown-menu a:focus,
.topber__profile .dropdown-menu a:active {
  color: crimson;
}

.topber__profile .dropdown-menu a:hover {
  color: crimson;
}

.sideber {
  position: fixed;
  top: 0;
  overflow-y: auto;
  left: 0;
  bottom: 0;
  width: 300px;
  height: 100vh;
  padding: 40px 20px 20px 20px;
  background-color: #4e73df;
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(10%, #4e73df), to(#224abe));
  background-image: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
  background-size: cover;
  -webkit-transition: left 0.5s ease;
  transition: left 0.5s ease;
  z-index: 999;
}

.sideber__ber {
  list-style: none;
}

.sideber__panel {
  font-size: 20px;
  color: #fff;
  line-height: 1.2rem;
  padding-bottom: 30px;
}

.sideber__panel i {
  color: #fff;
}

.sideber__item {
  padding: 10px;
}

.sideber__item a {
  color: rgba(255, 255, 255, 0.55);
  font-size: 16px;
  letter-spacing: 1px;
  font-weight: 500;
}

.sideber__item a i {
  color: rgba(255, 255, 255, 0.55);
  padding: 0 10px;
}

.sideber__item:hover a,
.sideber__item.active a,
.sideber__item.active i,
.sideber__item:hover i {
  color: #fff;
  -webkit-transition: 0.3s ease;
  transition: 0.3s ease;
}

.sideber__item--modify {
  padding: 40px 10px 10px 10px;
}

.sideber footer {
  position: absolute;
  bottom: 0;
  font-size: 16px;
  color: #fff;
}

.sideber footer span {
  font-size: 20px;
}


.main {
  margin-left: 300px;
  margin-top: 10vh;
  padding: 2rem;
}

.main .dashboard {
  display: block;
}

.main .dashboard .total__box {
  border: 3px solid #4e73df;
  padding: 20px 10px;
  background-color: #4e73df;
  color: white;
  -webkit-transition: 0.3s ease;
  transition: 0.3s ease;
  cursor: pointer;
}

.main .dashboard .total__box:hover {
  color: #4e73df;
  background-color: #fff;
}

.main__table {
  margin: 50px 70px;
  -webkit-box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
          box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
  overflow-x: auto;
}

.main__table .table {
  font-size: 18px;
  font-weight: 400;
}

.main__table .table th {
  color: #ffffff;
  background: #224abe;
}

.main__table .table th.name {
  min-width: 150px;
}

.main__table .table th.phone {
  min-width: 180px;
}

.main__table .table tr:nth-child(even) {
  background: #f8f8f8;
}

.main__form {
  max-width: 600px;
  padding: 5rem 3rem;
  -webkit-box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
          box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
  margin: 5rem auto;
}

.main__form--title {
  font-size: 30px;
  font-weight: bold;
  padding: 10px 0;
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
}

.main__form .input input::-webkit-input-placeholder,
.main__form .input select::-webkit-input-placeholder {
  color: #ccc;
  font-weight: bold;
  letter-spacing: 1px;
}

.main__form .input input:-ms-input-placeholder,
.main__form .input select:-ms-input-placeholder {
  color: #ccc;
  font-weight: bold;
  letter-spacing: 1px;
}

.main__form .input input::-ms-input-placeholder,
.main__form .input select::-ms-input-placeholder {
  color: #ccc;
  font-weight: bold;
  letter-spacing: 1px;
}

.main__form .input input::placeholder,
.main__form .input select::placeholder {
  color: #ccc;
  font-weight: bold;
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

.main__form .input input:focus::-webkit-input-placeholder, .main__form .input input:hover::-webkit-input-placeholder,
.main__form .input select:focus::-webkit-input-placeholder,
.main__form .input select:hover::-webkit-input-placeholder {
  -webkit-transition: 0.5s ease;
  transition: 0.5s ease;
  color: #384047;
  font-weight: bold;
  letter-spacing: 1px;
}

.main__form .input input:focus:-ms-input-placeholder, .main__form .input input:hover:-ms-input-placeholder,
.main__form .input select:focus:-ms-input-placeholder,
.main__form .input select:hover:-ms-input-placeholder {
  -webkit-transition: 0.5s ease;
  transition: 0.5s ease;
  color: #384047;
  font-weight: bold;
  letter-spacing: 1px;
}

.main__form .input input:focus::-ms-input-placeholder, .main__form .input input:hover::-ms-input-placeholder,
.main__form .input select:focus::-ms-input-placeholder,
.main__form .input select:hover::-ms-input-placeholder {
  -webkit-transition: 0.5s ease;
  transition: 0.5s ease;
  color: #384047;
  font-weight: bold;
  letter-spacing: 1px;
}

.main__form .input input:focus::placeholder, .main__form .input input:hover::placeholder,
.main__form .input select:focus::placeholder,
.main__form .input select:hover::placeholder {
  -webkit-transition: 0.5s ease;
  transition: 0.5s ease;
  color: #384047;
  font-weight: bold;
  letter-spacing: 1px;
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

.main__form img {
  width: 200px;
  height: 200px;
}

.main__form #pimg {
  cursor: pointer;
  border: 7px solid #224abe;
}

.main__form .pimgedit {
  z-index: 5;
  width: 40px;
  height: 40px;
  line-height: 40px;
  font-size: 16px;
  background-color: #224abe;
  color: #fff;
  border-radius: 50%;
  margin-left: -30px;
  cursor: pointer;
}

.main .myProfile__title {
  padding-bottom: 50px;
}

.main .myProfile h4 {
  font-size: 25px;
  padding: 5px 20px;
}

.main .myProfile .updateMyProfile {
  margin-top: 20px;
  padding: 5px 0;
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


.topber {
  position: fixed;
  width: 100%;
  top: 0;
  left: 0;
  padding-left: 300px;
  right: 0;
  z-index: 999;
  box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
  background-color: #fff;

  &__title {
    height: 12.5vh;
    float: left;
    display: flex;
    flex-direction: row;
    align-items: center;
    padding-left: 1rem;

    &--text {
      font-size: 30px;
      font-weight: bold;
    }
  }

  &__profile {
    height: 12.5vh;
    float: right;
    padding-right: 10px;
    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 2rem;

    &--icon {
      color: #224abe;
      font-size: 20px;
    }

    button {
      color: #4e73df;
      line-height: 10px;
      font-weight: bold;

      &:hover {
        color: crimson;
      }
    }
    .dropdown-menu {
      margin-top: 10px;
      box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
      a:focus,
      a:active {
        color: crimson;
      }

      a:hover {
        color: crimson;
      }
    }
  }
}


.sideber {
  position: fixed;
  top: 0;
  overflow-y: auto;
  left: 0;
  bottom: 0;
  width: 300px;
  height: 100vh;
  padding: 40px 20px 20px 20px;
  background-color: #4e73df;
  background-image: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
  background-size: cover;
  transition: left 0.5s ease;
  z-index: 999;

  &__ber {
    list-style: none;
  }

  &__panel {
    font-size: 20px;
    color: #fff;
    line-height: 1.2rem;
    padding-bottom: 30px;

    i {
      color: #fff;
    }
  }

  &__item {
    padding: 10px;

    a {
      color: rgba(255, 255, 255, 0.55);
      font-size: 16px;
      letter-spacing: 1px;
      font-weight: 500;
      i {
        color: rgba(255, 255, 255, 0.55);
        padding: 0 10px;
      }
    }

    &:hover a,
    &.active a,
    &.active i,
    &:hover i {
      color: #fff;
      transition: 0.3s ease;
    }

    &--modify {
      padding: 40px 10px 10px 10px;
    }
  }

  footer {
    position: absolute;
    bottom: 0;
    font-size: 16px;
    color: #fff;
    span {
      font-size: 20px;
    }
  }
}



.main {
  margin-left: 300px;
  margin-top: 10vh;
  padding: 2rem;

 
  .dashboard {
    display: block;
    .total {
      &__box {
        border: 3px solid #4e73df;
        padding: 20px 10px;
        background-color: #4e73df;
        color: white;
        transition: 0.3s ease;
        cursor: pointer;

        &:hover {
          color: #4e73df;
          background-color: #fff;
        }
      }
    }
  }



  &__table {
    margin: 50px 70px;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    overflow-x: auto;
    .table {
      font-size: 18px;
      font-weight: 400;

      th {
        color: #ffffff;
        background: #224abe;
        &.name {
          min-width: 150px;
        }
        &.phone {
          min-width: 180px;
        }
      }

      tr:nth-child(even) {
        background: #f8f8f8;
      }
    }
  }

  form {
    max-width: 600px;
    padding: 5rem 3rem;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    margin: 5rem auto;

    &--title {
      font-size: 30px;
      font-weight: bold;
      padding: 10px 0;
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

        &::placeholder {
          color: #ccc;
          font-weight: bold;
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

        &:focus::placeholder,
        &:hover::placeholder {
          transition: 0.5s ease;
          color: #384047;
          font-weight: bold;
          letter-spacing: 1px;
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

    img {
      width: 200px;
      height: 200px;
    }

    #pimg {
      cursor: pointer;
      border: 7px solid #224abe;
    }

    .pimgedit {
      z-index: 5;
      width: 40px;
      height: 40px;
      line-height: 40px;
      font-size: 16px;
      background-color: #224abe;
      color: #fff;
      border-radius: 50%;
      margin-left: -30px;
      cursor: pointer;
    }
  }



  .myProfile {
    &__title {
      padding-bottom: 50px;
    }

    h4 {
      font-size: 25px;
      padding: 5px 20px;
    }

    .updateMyProfile {
      margin-top: 20px;
      padding: 5px 0;
    }
  }
}

    </style>
    <title>Dashboard</title>
</head>

<body>

    <section class="topber">
        <div class="topber__title">
            <span class="topber__title--text">
                <?php
                    if ( 'dashboard' == $id ) {
                        echo "DashBoard";
                    } elseif ( 'addManager' == $id ) {
                        echo "Add Manager";
                    } elseif ( 'allManager' == $id ) {
                        echo "Managers";
                    } elseif ( 'addPharmacist' == $id ) {
                        echo "Add Pharmacist";
                    } elseif ( 'allPharmacist' == $id ) {
                        echo "Pharmacists";
                    } elseif ( 'addSalesman' == $id ) {
                        echo "Add Salesman";
                    } elseif ( 'allSalesman' == $id ) {
                        echo "Salesmans";
                    } elseif ( 'userProfile' == $id ) {
                        echo "Your Profile";
                    } elseif ( 'editManager' == $action ) {
                        echo "Edit Manager";
                    } elseif ( 'editPharmacist' == $action ) {
                        echo "Edit Pharmacist";
                    } elseif ( 'editSalesman' == $action ) {
                        echo "Edit Salesman";
                    }
                ?>

            </span>
        </div>

        <div class="topber__profile">
            <?php
                $query = "SELECT fname,lname,role,avatar FROM {$sessionRole}s WHERE id='$sessionId'";
                $result = mysqli_query( $connection, $query );

                if ( $data = mysqli_fetch_assoc( $result ) ) {
                    $fname = $data['fname'];
                    $lname = $data['lname'];
                    $role = $data['role'];
                    $avatar = $data['avatar'];
                ?>
                <img src="assets/img/<?php echo "$avatar"; ?>" height="25" width="25" class="rounded-circle" alt="profile">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php
                        echo "$fname $lname (" . ucwords( $role ) . " )";
                        }
                    ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="index.php">Dashboard</a>
                        <a class="dropdown-item" href="index.php?id=userProfile">Profile</a>
                        <a class="dropdown-item" href="logout.php">Log Out</a>
                    </div>
                </div>
        </div>
    </section>

    <section id="sideber" class="sideber">
        <ul class="sideber__ber">
            <h3 class="sideber__panel"><i id="left" class="fas fa-laugh-wink"></i> PMS</h3>
            <li id="left" class="sideber__item<?php if ( 'dashboard' == $id ) {
                                                  echo " active";
                                              }?>">
                <a href="index.php?id=dashboard"><i id="left" class="fas fa-tachometer-alt"></i>Dashboard</a>
            </li>
            <?php if ( 'admin' == $sessionRole ) {?>
                <!-- Only For Admin -->
                <li id="left" class="sideber__item sideber__item--modify<?php if ( 'addManager' == $id ) {
                                                                            echo " active";
                                                                        }?>">
                    <a href="index.php?id=addManager"><i id="left" class="fas fa-user-plus"></i></i>Add Manager</a>
                </li><?php }?>
            <li id="left" class="sideber__item<?php if ( 'allManager' == $id ) {
    echo " active";
}?>">
                <a href="index.php?id=allManager"><i id="left" class="fas fa-user"></i>All Manager</a>
            </li>
            <?php if ( 'admin' == $sessionRole || 'manager' == $sessionRole ) {?>
                <!-- For Admin, Manager -->
                <li id="left" class="sideber__item sideber__item--modify<?php if ( 'addPharmacist' == $id ) {
                                                                            echo " active";
                                                                        }?>">
                    <a href="index.php?id=addPharmacist"><i id="left" class="fas fa-user-plus"></i></i>Add
                        Pharmacist</a>
                </li><?php }?>
            <li id="left" class="sideber__item<?php if ( 'allPharmacist' == $id ) {
    echo " active";
}?>">
                <a href="index.php?id=allPharmacist"><i id="left" class="fas fa-user"></i>All Pharmacist</a>
            </li>
            <?php if ( 'admin' == $sessionRole || 'manager' == $sessionRole || 'pharmacist' == $sessionRole ) {?>
               
                <li id="left" class="sideber__item sideber__item--modify<?php if ( 'addSalesman' == $id ) {
                                                                            echo " active";
                                                                        }?>">
                    <a href="index.php?id=addSalesman"><i id="left" class="fas fa-user-plus"></i>Add Salesman</a>
                </li><?php }?>
            <li id="left" class="sideber__item<?php if ( 'allSalesman' == $id ) {
    echo " active";
}?>">
                <a href="index.php?id=allSalesman"><i id="left" class="fas fa-user"></i>All Salesman</a>
            </li>
        </ul>
        <footer class="text-center"><span>PMS</span><br>©2024 PMS All right reserved.</footer>
    </section>
   
    <section class="main">
        <div class="container">

            
            <?php if ( 'dashboard' == $id ) {?>
                <div class="dashboard p-5">
                    <div class="total">
                        <div class="row">
                            <div class="col-3">
                                <div class="total__box text-center">
                                    <h1>2453</h1>
                                    <h2>Total Sell</h2>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="total__box text-center">
                                    <h1>
                                        <?php
                                            $query = "SELECT COUNT(*) totalManager FROM managers;";
                                                $result = mysqli_query( $connection, $query );
                                                $totalManager = mysqli_fetch_assoc( $result );
                                                echo $totalManager['totalManager'];
                                            ?>
                                    </h1>
                                    <h2>Manager</h2>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="total__box text-center">
                                    <h1>
                                        <?php
                                            $query = "SELECT COUNT(*) totalPharmacist FROM pharmacists;";
                                                $result = mysqli_query( $connection, $query );
                                                $totalPharmacist = mysqli_fetch_assoc( $result );
                                                echo $totalPharmacist['totalPharmacist'];
                                            ?>

                                    </h1>
                                    <h2>Pharmacist</h2>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="total__box text-center">
                                    <h1><?php
                                            $query = "SELECT COUNT(*) totalSalesman FROM salesmans;";
                                                $result = mysqli_query( $connection, $query );
                                                $totalSalesman = mysqli_fetch_assoc( $result );
                                            echo $totalSalesman['totalSalesman'];
                                            ?></h1>
                                    <h2>Salesman</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }?>
         
            <div class="manager">
                <?php if ( 'allManager' == $id ) {?>
                    <div class="allManager">
                        <div class="main__table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Avater</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <?php if ( 'admin' == $sessionRole ) {?>
                                            
                                            
                                            
                                        <?php }?>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                        $getManagers = "SELECT * FROM managers";
                                            $result = mysqli_query( $connection, $getManagers );

                                        while ( $manager = mysqli_fetch_assoc( $result ) ) {?>

                                        <tr>
                                            <td>
                                                <center><img class="rounded-circle" width="40" height="40" src="assets/img/<?php echo $manager['avatar']; ?>" alt=""></center>
                                            </td>
                                            <td><?php printf( "%s %s", $manager['fname'], $manager['lname'] );?></td>
                                            <td><?php printf( "%s", $manager['email'] );?></td>
                                            <td><?php printf( "%s", $manager['phone'] );?></td>
                                            <?php if ( 'admin' == $sessionRole ) {?>
                                                
                                                <td><?php printf( "<a href='index.php?action=editManager&id=%s'><i class='fas fa-edit'></i></a>", $manager['id'] )?></td>
                                                <td><?php printf( "<a class='delete' href='index.php?action=deleteManager&id=%s'><i class='fas fa-trash'></i></a>", $manager['id'] )?></td>
                                            <?php }?>
                                        </tr>

                                    <?php }?>

                                </tbody>
                            </table>


                        </div>
                    </div>
                <?php }?>

                <?php if ( 'addManager' == $id ) {?>
                    <div class="addManager">
                        <div class="main__form">
                            <div class="main__form--title text-center">Add New Manager</div>
                            <form action="add.php" method="POST">
                                <div class="form-row">
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-user-circle"></i>
                                            <input type="text" name="fname" placeholder="First name" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-user-circle"></i>
                                            <input type="text" name="lname" placeholder="Last Name" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-envelope"></i>
                                            <input type="email" name="email" placeholder="Email" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-phone-alt"></i>
                                            <input type="number" name="phone" placeholder="Phone" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-key"></i>
                                            <input id="pwdinput" type="password" name="password" placeholder="Password" required>
                                            <i id="pwd" class="fas fa-eye right"></i>
                                        </label>
                                    </div>
                                    <input type="hidden" name="action" value="addManager">
                                    <div class="col col-12">
                                        <input type="submit" value="Submit">
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                <?php }?>

                <?php if ( 'editManager' == $action ) {
                        $managerId = $_REQUEST['id'];
                        $selectManagers = "SELECT * FROM managers WHERE id='{$managerId}'";
                        $result = mysqli_query( $connection, $selectManagers );

                    $manager = mysqli_fetch_assoc( $result );?>
                    <div class="addManager">
                        <div class="main__form">
                            <div class="main__form--title text-center">Update Manager</div>
                            <form action="add.php" method="POST">
                                <div class="form-row">
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-user-circle"></i>
                                            <input type="text" name="fname" placeholder="First name" value="<?php echo $manager['fname']; ?>" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-user-circle"></i>
                                            <input type="text" name="lname" placeholder="Last Name" value="<?php echo $manager['lname']; ?>" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-envelope"></i>
                                            <input type="email" name="email" placeholder="Email" value="<?php echo $manager['email']; ?>" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-phone-alt"></i>
                                            <input type="number" name="phone" placeholder="Phone" value="<?php echo $manager['phone']; ?>" required>
                                        </label>
                                    </div>
                                    <input type="hidden" name="action" value="updateManager">
                                    <input type="hidden" name="id" value="<?php echo $managerId; ?>">
                                    <div class="col col-12">
                                        <input type="submit" value="Update">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php }?>

                <?php if ( 'deleteManager' == $action ) {
                        $managerId = $_REQUEST['id'];
                        $deleteManager = "DELETE FROM managers WHERE id ='{$managerId}'";
                        $result = mysqli_query( $connection, $deleteManager );
                        header( "location:index.php?id=allManager" );
                }?>
            </div>
         
            <div class="pharmacist">
                <?php if ( 'allPharmacist' == $id ) {?>
                    <div class="allPharmacist">
                        <div class="main__table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Avatar</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <?php if ( 'admin' == $sessionRole || 'manager' == $sessionRole ) {?>
                                           
                                           
                                        <?php }?>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                        $getPharmacist = "SELECT * FROM pharmacists";
                                            $result = mysqli_query( $connection, $getPharmacist );

                                        while ( $pharmacist = mysqli_fetch_assoc( $result ) ) {?>

                                        <tr>
                                            <td>
                                                <center><img class="rounded-circle" width="40" height="40" src="assets/img/<?php echo $pharmacist['avatar']; ?>" alt=""></center>
                                            </td>
                                            <td><?php printf( "%s %s", $pharmacist['fname'], $pharmacist['lname'] );?></td>
                                            <td><?php printf( "%s", $pharmacist['email'] );?></td>
                                            <td><?php printf( "%s", $pharmacist['phone'] );?></td>
                                            <?php if ( 'admin' == $sessionRole || 'manager' == $sessionRole ) {?>
                                                
                                                <td><?php printf( "<a href='index.php?action=editPharmacist&id=%s'><i class='fas fa-edit'></i></a>", $pharmacist['id'] )?></td>
                                                <td><?php printf( "<a class='delete' href='index.php?action=deletePharmacist&id=%s'><i class='fas fa-trash'></i></a>", $pharmacist['id'] )?></td>
                                            <?php }?>
                                        </tr>

                                    <?php }?>

                                </tbody>
                            </table>


                        </div>
                    </div>
                <?php }?>

                <?php if ( 'addPharmacist' == $id ) {?>
                    <div class="addPharmacist">
                        <div class="main__form">
                            <div class="main__form--title text-center">Add New Pharmacist</div>
                            <form action="add.php" method="POST">
                                <div class="form-row">
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-user-circle"></i>
                                            <input type="text" name="fname" placeholder="First name" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-user-circle"></i>
                                            <input type="text" name="lname" placeholder="Last Name" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-envelope"></i>
                                            <input type="email" name="email" placeholder="Email" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-phone-alt"></i>
                                            <input type="number" name="phone" placeholder="Phone" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-key"></i>
                                            <input id="pwdinput" type="password" name="password" placeholder="Password" required>
                                            <i id="pwd" class="fas fa-eye right"></i>
                                        </label>
                                    </div>
                                    <input type="hidden" name="action" value="addPharmacist">
                                    <div class="col col-12">
                                        <input type="submit" value="Submit">
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                <?php }?>

                <?php if ( 'editPharmacist' == $action ) {
                        $pharmacistID = $_REQUEST['id'];
                        $selectPharmacist = "SELECT * FROM pharmacists WHERE id='{$pharmacistID}'";
                        $result = mysqli_query( $connection, $selectPharmacist );

                    $pharmacist = mysqli_fetch_assoc( $result );?>
                    <div class="addManager">
                        <div class="main__form">
                            <div class="main__form--title text-center">Update Pharmacist</div>
                            <form action="add.php" method="POST">
                                <div class="form-row">
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-user-circle"></i>
                                            <input type="text" name="fname" placeholder="First name" value="<?php echo $pharmacist['fname']; ?>" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-user-circle"></i>
                                            <input type="text" name="lname" placeholder="Last Name" value="<?php echo $pharmacist['lname']; ?>" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-envelope"></i>
                                            <input type="email" name="email" placeholder="Email" value="<?php echo $pharmacist['email']; ?>" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-phone-alt"></i>
                                            <input type="number" name="phone" placeholder="Phone" value="<?php echo $pharmacist['phone']; ?>" required>
                                        </label>
                                    </div>
                                    <input type="hidden" name="action" value="updatePharmacist">
                                    <input type="hidden" name="id" value="<?php echo $pharmacistID; ?>">
                                    <div class="col col-12">
                                        <input type="submit" value="Update">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php }?>

                <?php if ( 'deletePharmacist' == $action ) {
                        $pharmacistID = $_REQUEST['id'];
                        $deletePharmacist = "DELETE FROM pharmacists WHERE id ='{$pharmacistID}'";
                        $result = mysqli_query( $connection, $deletePharmacist );
                        header( "location:index.php?id=allPharmacist" );
                }?>
            </div>
           
            <div class="salesman">
                <?php if ( 'allSalesman' == $id ) {?>
                    <div class="allSalesman">
                        <div class="main__table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Avatar</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <?php if ( 'admin' == $sessionRole || 'manager' == $sessionRole || 'pharmacist' == $sessionRole ) {?>
                                          
                                        <?php }?>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                        $getSalesman = "SELECT * FROM salesmans";
                                            $result = mysqli_query( $connection, $getSalesman );

                                        while ( $salesman = mysqli_fetch_assoc( $result ) ) {?>

                                        <tr>
                                             <td>
                                                <center><img class="rounded-circle" width="40" height="40" src="assets/img/<?php echo $salesman['avatar']; ?>" alt=""></center>
                                            </td>
                                            <td><?php printf( "%s %s", $salesman['fname'], $salesman['lname'] );?></td>
                                            <td><?php printf( "%s", $salesman['email'] );?></td>
                                            <td><?php printf( "%s", $salesman['phone'] );?></td>
                                            <?php if ( 'admin' == $sessionRole || 'manager' == $sessionRole || 'pharmacist' == $sessionRole ) {?>
                                                
                                                <td><?php printf( "<a href='index.php?action=editSalesman&id=%s'><i class='fas fa-edit'></i></a>", $salesman['id'] )?></td>
                                                <td><?php printf( "<a class='delete' href='index.php?action=deleteSalesman&id=%s'><i class='fas fa-trash'></i></a>", $salesman['id'] )?></td>
                                            <?php }?>
                                        </tr>

                                    <?php }?>

                                </tbody>
                            </table>


                        </div>
                    </div>
                <?php }?>

                <?php if ( 'addSalesman' == $id ) {?>
                    <div class="addSalesman">
                        <div class="main__form">
                            <div class="main__form--title text-center">Add New Salesman</div>
                            <form action="add.php" method="POST">
                                <div class="form-row">
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-user-circle"></i>
                                            <input type="text" name="fname" placeholder="First name" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-user-circle"></i>
                                            <input type="text" name="lname" placeholder="Last Name" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-envelope"></i>
                                            <input type="email" name="email" placeholder="Email" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-phone-alt"></i>
                                            <input type="number" name="phone" placeholder="Phone" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-key"></i>
                                            <input id="pwdinput" type="password" name="password" placeholder="Password" required>
                                        </label>
                                    </div>
                                    <input type="hidden" name="action" value="addSalesman">
                                    <div class="col col-12">
                                        <input type="submit" value="Submit">
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                <?php }?>

                <?php if ( 'editSalesman' == $action ) {
                        $salesmanID = $_REQUEST['id'];
                        $selectSalesman = "SELECT * FROM salesmans WHERE id='{$salesmanID}'";
                        $result = mysqli_query( $connection, $selectSalesman );

                    $salesman = mysqli_fetch_assoc( $result );?>
                    <div class="addManager">
                        <div class="main__form">
                            <div class="main__form--title text-center">Update Salesman</div>
                            <form action="add.php" method="POST">
                                <div class="form-row">
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-user-circle"></i>
                                            <input type="text" name="fname" placeholder="First name" value="<?php echo $salesman['fname']; ?>" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-user-circle"></i>
                                            <input type="text" name="lname" placeholder="Last Name" value="<?php echo $salesman['lname']; ?>" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-envelope"></i>
                                            <input type="email" name="email" placeholder="Email" value="<?php echo $salesman['email']; ?>" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-phone-alt"></i>
                                            <input type="number" name="phone" placeholder="Phone" value="<?php echo $salesman['phone']; ?>" required>
                                        </label>
                                    </div>
                                    <input type="hidden" name="action" value="updateSalesman">
                                    <input type="hidden" name="id" value="<?php echo $salesmanID; ?>">
                                    <div class="col col-12">
                                        <input type="submit" value="Update">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php }?>

                <?php if ( 'deleteSalesman' == $action ) {
                        $salesmanID = $_REQUEST['id'];
                        $deleteSalesman = "DELETE FROM salesmans WHERE id ='{$salesmanID}'";
                        $result = mysqli_query( $connection, $deleteSalesman );
                        header( "location:index.php?id=allSalesman" );
                        ob_end_flush();
                }?>
            </div>
           
            <?php if ( 'userProfile' == $id ) {
                    $query = "SELECT * FROM {$sessionRole}s WHERE id='$sessionId'";
                    $result = mysqli_query( $connection, $query );
                    $data = mysqli_fetch_assoc( $result )
                ?>
                <div class="userProfile">
                    <div class="main__form myProfile">
                        <form action="index.php">
                            <div class="main__form--title myProfile__title text-center">My Profile</div>
                            <div class="form-row text-center">
                                <div class="col col-12 text-center pb-3">
                                    <img src="assets/img/<?php echo $data['avatar']; ?>" class="img-fluid rounded-circle" alt="">
                                </div>
                                <div class="col col-12">
                                    <h4><b>Full Name : </b><?php printf( "%s %s", $data['fname'], $data['lname'] );?></h4>
                                </div>
                                <div class="col col-12">
                                    <h4><b>Email : </b><?php printf( "%s", $data['email'] );?></h4>
                                </div>
                                <div class="col col-12">
                                    <h4><b>Phone : </b><?php printf( "%s", $data['phone'] );?></h4>
                                </div>
                                <input type="hidden" name="id" value="userProfileEdit">
                                <div class="col col-12">
                                    <input class="updateMyProfile" type="submit" value="Update Profile">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php }?>

            <?php if ( 'userProfileEdit' == $id ) {
                    $query = "SELECT * FROM {$sessionRole}s WHERE id='$sessionId'";
                    $result = mysqli_query( $connection, $query );
                    $data = mysqli_fetch_assoc( $result )
                ?>


                <div class="userProfileEdit">
                    <div class="main__form">
                        <div class="main__form--title text-center">Update My Profile</div>
                        <form enctype="multipart/form-data" action="add.php" method="POST">
                            <div class="form-row">
                                <div class="col col-12 text-center pb-3">
                                    <img id="pimg" src="assets/img/<?php echo $data['avatar']; ?>" class="img-fluid rounded-circle" alt="">
                                    <i class="fas fa-pen pimgedit"></i>
                                    <input onchange="document.getElementById('pimg').src = window.URL.createObjectURL(this.files[0])" id="pimgi" style="display: none;" type="file" name="avatar">
                                </div>
                                <div class="col col-12">
                                <?php if ( isset( $_REQUEST['avatarError'] ) ) {
                                            echo "<p style='color:red;' class='text-center'>Please make sure this file is jpg, png or jpeg</p>";
                                    }?>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-user-circle"></i>
                                        <input type="text" name="fname" placeholder="First name" value="<?php echo $data['fname']; ?>" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-user-circle"></i>
                                        <input type="text" name="lname" placeholder="Last Name" value="<?php echo $data['lname']; ?>" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-envelope"></i>
                                        <input type="email" name="email" placeholder="Email" value="<?php echo $data['email']; ?>" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-phone-alt"></i>
                                        <input type="number" name="phone" placeholder="Phone" value="<?php echo $data['phone']; ?>" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-key"></i>
                                        <input id="pwdinput" type="password" name="oldPassword" placeholder="Old Password" required>
                                        <i id="pwd" class="fas fa-eye right"></i>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-key"></i>
                                        <input id="pwdinput" type="password" name="newPassword" placeholder="New Password" required>
                                        <p>Type Old Password if you don't want to change</p>
                                        <i id="pwd" class="fas fa-eye right"></i>
                                    </label>
                                </div>
                                <input type="hidden" name="action" value="updateProfile">
                                <div class="col col-12">
                                    <input type="submit" value="Update">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php }?>
         

        </div>

    </section>
    <script src="assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="./assets/js/app.js"></script>
</body>

</html>