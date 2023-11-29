<?php 
    session_start();
?>
<style>
    .profile-container{
        background-color: #fff;
        width: 250px;
        position: absolute;
        top: 40px;
        right: 0;
        border: 2px solid #ddd;
        border-radius: 5px;
        display: none;
    }
    .user_detail{
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
    }
    .user_profile{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: start;
        gap: 20px;
        padding: 20px;
    }

    .user_profile a{
        text-decoration: none;
        color: #000;
    }

    .user_profile a:hover{
        color: #ddd;
    }

    .login a{
        text-decoration: none;
    }
</style>
<div class="user_detail">
    <div class="img">
        <img src="assets/user.png" alt="user">
    </div>
    <div class="username">
        <p>User Name</p>
    </div>
    <div class="login">
        <a href="<?php echo isset($_SESSION['user_id']) ? 'logout.php' : 'login.php'; ?>" id="loginLogoutLink">
            <?php echo isset($_SESSION['user_id']) ? 'Logout' : 'Sign Up'; ?>
        </a>
    </div>
</div>
<div class="user_profile">
    <a href="#">Purchases</a>
    <a href="#">Your Details</a>
    <a href="#">Preferences</a>
    <a href="#">Payment Options</a>
</div>