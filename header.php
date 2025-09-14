<?php
session_start();

// Инициализация автозагрузчика
require_once 'app/core/Database.php';

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

    <!-- CSS -->
    <link rel="stylesheet" media="(min-width: 570px)" href="assets/css/main.css">
    <link rel="stylesheet" media="(max-width: 570px)" href="assets/css/mobile.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">

    <title>NEWS</title>
</head>
<body>

<header class="header">
    <div class="logoholder">
        <a href="#">
            <img class="hamburger" src="resources/Hamburger_icon1.png" alt="Menu">
        </a>
        <a href="/index.php">
            <div class="mains">NEWS</div>
        </a>
    </div>
    <ol id="menu" class="ol1">
        <li><a class="li1" href="">
                <svg width="98" height="98" viewBox="0 0 98 98" fill="none" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g filter="url(#filter0_d_123_52)">
                        <rect x="4" width="90" height="90" fill="url(#pattern0_123_52)" shape-rendering="crispEdges"/>
                    </g>
                    <defs>
                        <filter id="filter0_d_123_52" x="0" y="0" width="98" height="98" filterUnits="userSpaceOnUse"
                                color-interpolation-filters="sRGB">
                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                           result="hardAlpha"/>
                            <feOffset dy="4"/>
                            <feGaussianBlur stdDeviation="2"/>
                            <feComposite in2="hardAlpha" operator="out"/>
                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_123_52"/>
                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_123_52" result="shape"/>
                        </filter>
                        <pattern id="pattern0_123_52" patternContentUnits="objectBoundingBox" width="1" height="1">
                            <use xlink:href="#image0_123_52" transform="scale(0.0111111)"/>
                        </pattern>
                        <image id="image0_123_52" width="90" height="90"
                               xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAABaCAYAAAA4qEECAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAv0lEQVR4nO3awWrCQABF0Ys7/XxrqV9pu2m3kUDWYmahAz0H8gOXMAN5KQAAAAAAAADe6lR9Vj/V4ulRg+/qUh1HQl/Fbe8Ltjbb5VD9Cd3e0L9bO6GbLLSjo6HQXw1YD/aP7aB3Gfawwa06j16GAAAAAAD/nHG2p7/DG2d77WhhnO01oY2zTRp65b+OjLPLZIOxcRYAAAAAYJxxNuPsMsHHfuNs7wttnG3S0CvjbMbZZYLz2DgLAAAAAAAA0GTuqD9gUMDt6+cAAAAASUVORK5CYII="/>
                    </defs>
                </svg>
            </a>
            <ol class="ol2">
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    <a href="#">For you</a>
                </li>
                <li>
                    <a href="#">Following</a>
                </li>
                <li>
                    <a href="#">World</a>
                </li>
                <li>
                    <a href="aboutus.html">About us</a>
                </li>
            </ol>
        </li>
    </ol>
    <div class="nav">
        <ul><li>
                <a href="index.php">
                    <h3>Home</h3>
                </a>
                </a></li>
            <li><a href="#fy"><h3>For you</h3></a></li>
            <li><h3>Following</h3></li>
            <li><h3>World</h3></li>
            <a href="aboutus.html">
                <li id="right"><h3>About us</h3></li>
            </a>
        </ul>
    </div>
    <div class="rightpanel">
        <input id="mobsearch" class="rpl" type="text" placeholder="Search">
        <svg class="rpl" width="51" height="44" viewBox="0 0 51 44" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path d="M12.75 0C9.24375 0 6.12 1.46625 3.76125 3.76125C1.46625 6.05625 0 9.18 0 12.75C0 16.2563 1.46625 19.38 3.76125 21.7388L25.5 43.4775L47.2388 21.7388C49.5337 19.4438 51 16.32 51 12.75C51 9.24375 49.5337 6.12 47.2388 3.76125C44.9437 1.46625 41.82 0 38.25 0C34.7438 0 31.62 1.46625 29.2613 3.76125C26.9663 6.05625 25.5 9.18 25.5 12.75C25.5 9.24375 24.0338 6.12 21.7388 3.76125C19.4438 1.46625 16.32 0 12.75 0Z"
                  fill="black"/>
        </svg>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/profile.php">
                <svg class="rpl" width="52" height="46" viewBox="0 0 52 46" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.307 0V6.43568H45.0497V38.6141H19.307V45.0497H51.4854V0H19.307ZM25.7427 12.8714V19.307H0V25.7427H25.7427V32.1784L38.6141 22.5249L25.7427 12.8714Z"
                          fill="black"/>
                </svg>
            </a>
            <a href="/logout.php" class="logout-link">Logout</a>
        <?php else: ?>
            <a href="#" class="btn--show-modal-window">
                <svg class="rpl" width="52" height="46" viewBox="0 0 52 46" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.307 0V6.43568H45.0497V38.6141H19.307V45.0497H51.4854V0H19.307ZM25.7427 12.8714V19.307H0V25.7427H25.7427V32.1784L38.6141 22.5249L25.7427 12.8714Z"
                          fill="black"/>
                </svg>
            </a>
        <?php endif; ?>
    </div>
</header>

<!-- Modal window -->
<div class="modal-window hidden">
    <button class="btn--close-modal-window">×</button>
    <!-- Toggle buttons -->
    <div class="modal-toggle">
        <button class="toggle-btn active" data-tab="login">Login</button>
        <button class="toggle-btn" data-tab="register">Register</button>
    </div>
    <!-- Login Form -->
    <form class="modal__form login-form" style="display: flex;">
        <label for="login-email">Email</label>
        <input type="email" id="login-email" name="email" placeholder="Enter your email" required>
        <label for="login-password">Password</label>
        <input type="password" id="login-password" name="password" placeholder="Enter your password" required>
        <button type="submit" class="btn">Login →</button>
    </form>
    <!-- Register Form -->
    <form class="modal__form register-form" style="display: none;">
        <label for="register-name">Full Name</label>
        <input type="text" id="register-name" name="name" placeholder="Enter your full name" required>
        <label for="register-email">Email</label>
        <input type="email" id="register-email" name="email" placeholder="Enter your email" required>
        <label for="register-phone">Phone Number</label>
        <input type="tel" id="register-phone" name="phone" class="phone" placeholder="Enter your phone">
        <label for="register-password">Password</label>
        <input type="password" id="register-password" name="password" placeholder="Create password" required>
        <label for="register-confirm-password">Confirm Password</label>
        <input type="password" id="register-confirm-password" name="confirm_password" placeholder="Confirm password" required>
        <button type="submit" class="btn">Register →</button>
    </form>
</div>
<div class="overlay hidden"></div>

<!-- Sliding Left Menu -->
<div class="slide-menu hidden">
    <div class="slide-menu__content">
        <button class="btn--close-slide-menu">×</button>
        <nav class="slide-nav">
            <ul>
                <li><a href="/category.php">Political</a></li>
                <li><a href="#">Nature</a></li>
                <li><a href="#">Society</a></li>
                <li><a href="#">World</a></li>
                <li><a href="#">Technology</a></li>
                <li><a href="#">Culture</a></li>
                <li><a href="#">Sports</a></li>
            </ul>
        </nav>
    </div>
</div>

<!-- Overlay for blur -->
<div class="slide-overlay hidden"></div>

<main>