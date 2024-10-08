<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMeals User Registeration</title>
    <link rel="stylesheet"
        href="assets/base.css?<?php echo filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/base.css'); ?>">
    <link rel="stylesheet"
        href="assets/style.css?<?php echo filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/style.css'); ?>">
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
    <link rel="preload" href="https://lottie.host/0bce2892-f33a-4e03-8723-084484b362c7/sDnHjQ79oG.json" as="fetch"
        type="application/json" crossorigin="anonymous">
    <link rel="preload" href="https://lottie.host/dcc2ef95-baa4-4c58-bc6c-96cd7ad39738/Q5JyZC9T9T.json" as="fetch"
        type="application/json" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@2.1.0/dist/iconify-icon.min.js"></script>
    <script
        src="assets/login_script.js?<?php echo filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/login_script.js'); ?>"></script>

</head>
<style>
    .hideit {
        display: none;
    }
</style>
<style>
    .hideit {
        display: none;
    }

    .cur {
        cursor: pointer;
    }

    .response {
        text-align: center;
        font-size: 16px;
        color: #353535;
        font-weight: 500;
    }

    .lottieimg {
        display: flex;
        justify-content: center;
        align-items: center;
        /* height: 30vh; */
        margin: 20px auto;
        align-items: center;
        width: 70%;

    }

    /* Full-page overlay style */
    .loading-layer {
        display: none;
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        justify-content: center;
        align-items: center;
    }

    /* Loader animation style */
    .loader {
        border: 8px solid #f3f3f3;
        /* Light grey */
        border-top: 8px solid #3498db;
        /* Blue */
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 2s linear infinite;
    }

    /* Loader animation */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    body.has-top-bar {
        padding-top: 50px;
    }
</style>
<style>
    .top-bar {
        width: 100%;
        background: linear-gradient(90deg, #6078FE 0%, #2e069c 100%);
        color: white;
        padding: 15px;
        text-align: center;
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        font-family: Arial, sans-serif;
        font-size: 18px;
    }


    /* Style for the rotating circle */
    .circle {
        width: 16px;
        height: 16px;
        border: 3px solid white;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 1.2s cubic-bezier(0.68, -0.55, 0.27, 1.55) infinite;
        margin-right: 10px;
    }

    /* Keyframes for rotating animation */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Style for the animated dots */
    .dots::after {
        content: " ";
        animation: dots 1.5s ease-in-out infinite;
    }

    /* Keyframes for dots animation */
    @keyframes dots {

        0%,
        20% {
            content: "";
        }

        40% {
            content: ".";
        }

        60% {
            content: "..";
        }

        80%,
        100% {
            content: "...";
        }
    }

    .response_top_bar {
        background: rgb(212, 0, 0);
        color: rgb(255, 255, 255);
        font-weight: bolder;
        font-size: 12px;
    }
</style>

<body>
    <main>
        <div class="top-bar" style="display: none;" on>
            <div class="circle"></div>
            <span id="message">Automatically Login in</span>
            <span class="dots"></span>
        </div>
        <div class="top-bar response_top_bar" style="display:none;" id="response_top_bar">
            <span id="message">No Customer Found With this Phone Number</span>
        </div>
        <section class="full_section">
            <div class="page_info">
                <img src="https://momscanteen.in/wp-content/uploads/2021/09/moms_canteen_logo.png" alt="" width="100px">
                <h2 id="title">Login/Signup Now</h2>
                <span>Welcome to Mom's Canteen</span>
                <span>Enter your Phone number to login/signup</span>
            </div>
        </section>
        <section class="full_section">
            <div class="form_container">
                <div id="signup_form">
                    <div class="input_field_container">
                        <label for="phone">Phone Number</label>
                        <input type="number" name="phone" id="phoneNumber" placeholder="Enter Your Phone Number here"
                            value="9253029002" onclick="truecaller_push();" onchange="check_number_format();" required>
                        <span class="input_desc" id="phone_hint">Without Country Code</span>
                        <small id="phone_error" class="error_message"></small>
                    </div>
                    <div class="input_field_container">
                        <button type="submit" class="submit_btn r-flex ali-c jut-c gap-1" id="send_otp"
                            onclick="check_number()">Get OTP<iconify-icon icon="ooui:arrow-next-ltr"
                                height="14"></iconify-icon></button>
                    </div>
                    <div id="otp_section" class="hideit">
                        <div class="input_field_container">
                            <label for="otp">OTP</label>
                            <input type="number" name="otp" id="otpInput" placeholder="Enter 4 Digit OTP here"
                                min="1000" max="9999" maxlength="4" required>
                            <span class="input_desc" id="otp_hint" class="hideit response"></span>
                            <small id="otp_error" class="error_message"></small>
                        </div>
                        <div class="input_field_container">
                            <button class="submit_btn r-flex ali-c jut-c gap-1" onclick="getOTP()">Verify
                                OTP<iconify-icon icon="ooui:arrow-next-ltr" height="14"></iconify-icon></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="full_section">
            <div class="extra_btn_container">
                <div class="c-flex ali-c">
                    <hr style="width: 100%;">
                    <span class="or_text">OR</span>
                </div>
                <button class="secondary_btn">Check Our Plans</button>
            </div>
            <div class="need_help_container enter_manually_btn">
                <span>Need Help?</span>
                <a href="#">Contact Us</a>
            </div>
            <!-- <div class="need_help_container get_location_btn r-flex ali-c jut-sb gap-1 country_detail">
                <span>Country</span>
                <a href="#">India</a>
            </div> -->
            <div style="margin: 40px auto;text-align: center;">
                <!-- <span id="request_id" onclick="pushed_truecaller();get_truecaller_response();">Request Id</span> <br>
                <span id="userInfo">Response Here</span> -->
                <p id="show_response" class="response"> </p>
            </div>
        </section>
    </main>

    <div id="overlay" class="overlay">
        <div class="overlay-content page_info">
            <dotlottie-player id="lottiePlayer"
                src="https://lottie.host/0bce2892-f33a-4e03-8723-084484b362c7/sDnHjQ79oG.json" background="transparent"
                speed="1" style="width: 300px; height: 200px;" speed="2" loop autoplay></dotlottie-player>
            <h3 id="overlay_title">Signing Up...</h3>
            <br>
            <span id="overlay_desc">Your Details are being checked.. </span>
            <button id="overlay_btn" class="submit_btn" style="display: none;">Add Yor Meal Plan Now</button>
            <!-- <button onclick="changeLottie()">Change Lottie</button> -->
            <span id="closeOverlay" class="text_btn pointer">Close</span>
        </div>
    </div>
    <div id="loadingLayer" class="loading-layer">
        <div class="loader"></div>
    </div>
</body>

<script>
    const overlay_desc = document.getElementById('overlay_desc');
    const overlay_title = document.getElementById('overlay_title');
    const overlay_btn = document.getElementById('overlay_btn');


    function show_bottom_popup(title, desc) {
        document.getElementById("overlay").style.display = "flex"; // Show the overlay
        document.body.classList.add('noscroll'); // Prevent background scrolling
        overlay_title.innerText = title;
        overlay_desc.innerText = desc; // Show loading message
    }
    function overlay_lottie(url) {
        const player = document.getElementById('lottiePlayer');
        const defaultUrl = "https://lottie.host/dcc2ef95-baa4-4c58-bc6c-96cd7ad39738/Q5JyZC9T9T.json";
        player.load(url || defaultUrl);
    }


    (function () {
        let cookieEnabled = false;
        let localStorageEnabled = false;
        let sessionSupported = false;

        // Check if cookies are supported
        try {
            document.cookie = "testcookie=1; max-age=60";
            cookieEnabled = document.cookie.indexOf("testcookie=1") !== -1;
        } catch (e) {
            cookieEnabled = false;
        }

        // Check if localStorage is supported
        try {
            localStorage.setItem("testLS", "1");
            localStorageEnabled = localStorage.getItem("testLS") === "1";
        } catch (e) {
            localStorageEnabled = false;
        }

        // Check if sessionStorage is supported
        try {
            sessionStorage.setItem("testSession", "1");
            sessionSupported = sessionStorage.getItem("testSession") === "1";
        } catch (e) {
            sessionSupported = false;
        }

        // Run the check only if not already tested
        try {
            if (!localStorage.getItem("browserChecked")) {
                if (!cookieEnabled || !localStorageEnabled || !sessionSupported) {
                    alert(
                        "Your browser doesn't fully support cookies, local storage, or session persistence. Some features may not work."
                    );
                }
                localStorage.setItem("browserChecked", "true");
            }
        } catch (e) {
            // If localStorage access fails, still alert the user
            if (!cookieEnabled || !localStorageEnabled || !sessionSupported) {
                alert(
                    "Your browser doesn't fully support cookies, local storage, or session persistence. Some features may not work."
                );
            }
        }
    })();

    // Get the URL parameters
    const urlParams = new URLSearchParams(window.location.search);

    // Check if the parameter 'response' equals 'Phone Not Found'
    if (urlParams.get('show_response') === 'Phone Not Found') {
        // Apply display: flex to the element with id #response_top_bar
        document.getElementById('response_top_bar').style.display = 'flex';
        document.body.classList.add("has-top-bar");
    }

</script>
<script>
    document.getElementById("title").addEventListener("click", function (event) {
        document.body.classList.add('noscroll'); // Prevent background scrolling
        document.getElementById("overlay").style.display = "flex"; // Show the overlay
    });
    document.getElementById("closeOverlay").addEventListener("click", function () {
        document.getElementById("overlay").style.display = "none"; // Hide the overlay
        document.body.classList.remove('noscroll'); // Prevent background scrolling
    });
</script>

</html>