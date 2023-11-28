<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat&family=Rajdhani:wght@300&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Montserrat&family=Prosto+One&family=Rajdhani:wght@300&display=swap');

:root{
    --navbar_bg: #fff;
    --navbar_color: #282828;
    --font_logo: 'Prosto One', sans-serif;
    --font_menu: 'Montserrat', sans-serif;
}

body, html{
    margin: 0;
    padding: 0;
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: var(--navbar_bg);
    color: var(--navbar_color);
    padding: 0px 100px;
    height: 60px;
    width: 100%;
    position: sticky;
    inset: 0;
    z-index: 10;
}

.logo {
    font-size: 24px;
    font-weight: bold;
    font-family: var(--font_logo);
}

.menu {
    list-style: none;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 50px;
    font-family: var(--font_menu);
}

.menu > a{
    color: var(--navbar_color);
    text-decoration: none;
}

.hamburger {
    display: none;
}

.search-container {
    display: flex;
    align-items: center;
    width: 250px;
    position: relative;
    justify-content: center;
}

.search-icon, .search-input, .search-btn {
    transition: opacity 0.5s ease, transform 0.5s ease, width 0.5s ease, padding 0.5s ease;
    position: absolute;
    opacity: 0;
}

.search-icon {
    border: 1px solid transparent;
    border-radius: 100%;
    height: 30px;
    width: 30px;
    cursor: pointer;
    transform: translateX(0);
    opacity: 1;
    background-image: url('assets/search-icon.svg');
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
}

.search-input {
    left: 0;
    right: 0;
    width: 0;
    padding: 0;
    border: none;
    pointer-events: none;
}

.search-btn {
    right: 0;
    width: 0;
    padding: 0;
    pointer-events: none;
}

.search-container.active .search-icon {
    opacity: 0;
    pointer-events: none;
    transform: translateX(-50%);
}

.search-container.active .search-input {
    width: 70%; /* Adjust width as needed */
    padding: 5px;
    pointer-events: auto;
    opacity: 1;
    border: 1px solid var(--navbar_color);
}

.search-container.active .search-btn {
    width: 30%;
    padding: 4px;
    pointer-events: auto;
    opacity: 1;
}

@media (max-width: 768px) {
    .navbar{
        padding: 0 25px;
    }

    .menu {
    position: absolute;
    top: 0;
    right: 0;
    width: 40vw;
    height: 100vh;
    background-color: var(--navbar_bg);
    opacity: 0;
    visibility: hidden;
    transition: visibility 0s 0.5s, opacity 0.5s ease;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 50px;
    z-index: -1;
}

.menu.open {
    opacity: 1;
    visibility: visible;
    transition: opacity 0.5s ease, visibility 0s 0s;
}

    .open {
        display: flex;
        flex-direction: column;
        position: absolute;
        height: 100vh;
        width: 40vw;
        top: 0;
        right: 0;
        background-color:var(--navbar_bg);
        justify-content: center;
        align-items: center;
        gap: 50px;
    }

    .hamburger {
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        width: 30px;
        height: 25px;
    }
    .hamburger span {
        background-color: var(--navbar_color);
        height: 3px;
        width: 100%;
        transition: all 0.3s ease;
    }
    .hamburger.active span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }
    
    .hamburger.active span:nth-child(2) {
        opacity: 0;
    }
    
    .hamburger.active span:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -6px);
    }
}
</style>
<div class="navbar">
    <div class="logo">LOGO</div>
    <?php
    include 'search.php'
    ?>
    <div class="menu">
        <a href="#">Menu 1</a>
        <a href="#">Menu 2</a>
        <a href="#">Menu 3</a>
        <div class="login">
        <a href="<?php echo isset($_SESSION['user_id']) ? 'logout.php' : 'login.php'; ?>" id="loginLogoutLink">
            <?php echo isset($_SESSION['user_id']) ? 'Logout' : 'Login or Register'; ?>
        </a>
        </div>
    </div>
    <div class="hamburger">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<script>
const searchContainer = document.querySelector('.search-container');
const searchIcon = document.querySelector('.search-icon');
const navbar = document.querySelector('.navbar');

searchIcon.addEventListener('click', () => {
    searchContainer.classList.add('active');
});

const hamburger = document.querySelector('.hamburger');
const menu = document.querySelector('.menu');

hamburger.addEventListener('click', () => {
    menu.classList.toggle('open');
    hamburger.classList.toggle('active');
});

window.addEventListener('click', (event) => {
    if (!navbar.contains(event.target)) {
        if (searchContainer.classList.contains('active')) {
            searchContainer.classList.remove('active');
        }
        if (menu.classList.contains('open')) {
            menu.classList.remove('open');
            hamburger.classList.remove('active');
        }
    }
});

window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
        if (searchContainer.classList.contains('active')) {
            searchContainer.classList.remove('active');
            searchResult.style.visibility = 'hidden';
        }
        if (menu.classList.contains('open')) {
            menu.classList.remove('open');
            hamburger.classList.remove('active');
        }
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const loginLink = document.querySelector('.login a');
    if (loginLink.textContent.trim() === 'Logout') {
        loginLink.style.color = 'red';
        loginLink.style.textDecoration = 'none';
    }
});
</script>