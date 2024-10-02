<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMeals User Registeration</title>
    <link rel="stylesheet"
        href="/assets/base.css?<?php echo filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/base.css'); ?>">
    <link rel="stylesheet"
        href="/assets/style.css?<?php echo filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/style.css'); ?>">
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
    <link rel="preload" href="https://lottie.host/0bce2892-f33a-4e03-8723-084484b362c7/sDnHjQ79oG.json" as="fetch"
        type="application/json" crossorigin="anonymous">
    <link rel="preload" href="https://lottie.host/dcc2ef95-baa4-4c58-bc6c-96cd7ad39738/Q5JyZC9T9T.json" as="fetch"
        type="application/json" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@2.1.0/dist/iconify-icon.min.js"></script>
</head>

<body>
    <main>
        <section class="full_section">

            <div class="page_info">
                <img src="https://momscanteen.in/wp-content/uploads/2021/09/moms_canteen_logo.png" alt="" width="100px">
                <h2>Login/Signup</h2>
                <span>Welcome to Mom's Canteen</span>
                <span>Enter your Phone number to login/signup</span>
            </div>
        </section>
        <section class="full_section">
            <div class="form_container">
                <form id="signup_form" action="#">

                    <div class="input_field_container">
                        <label for="phone">Phone Number</label>
                        <input type="number" name="phone" id="phone" placeholder="Enter Your Phone Number here"
                            value=9068062563>
                        <span class="input_desc">Without Country Code</span>
                        <small id="phone_error" class="error_message"></small>
                    </div>
                    <div class="input_field_container">
                        <button type="submit" class="submit_btn r-flex ali-c jut-c gap-1">Get OTP<iconify-icon
                                icon="ooui:arrow-next-ltr" height="14"></iconify-icon></button>
                    </div>
                </form>
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
            <div class="need_help_container">
                <span>Need Help?</span>
                <a href="#">Contact Us</a>
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
            <span id="closeOverlay">Close</span>
        </div>
    </div>
</body>

<script>

    function sendOTP() {
        var phoneNumber = document.getElementById("phoneNumber").value;
        document.getElementById("phoneNumber").disabled = true;
        document.getElementById("send_otp").classList.add("hideit");
        document.getElementById("otp_section").classList.remove("hideit");

        fetch("php/send_otp.php", {
            method: "POST",
            body: JSON.stringify({ phoneNumber: phoneNumber }),
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data); // Log the response from the server
            })
            .catch((error) => console.error("Error:", error));
    }

    function getOTP() {
        var enteredOTP = document.getElementById("otpInput").value;

        var otpPattern = /^\d{4}$/;
        if (!otpPattern.test(enteredOTP)) {
            alert("Please enter a valid otp"); // Display error message
        } else {
            fetch("php/verify_otp.php", {
                method: "POST",
                body: JSON.stringify({ otp: enteredOTP }),
                headers: {
                    "Content-Type": "application/json",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    console.log("Response from server:", data); // Log response data for debugging

                    if (
                        data.hasOwnProperty("message") &&
                        data.message === "OTP Verified successfully!"
                    ) {
                        console.log(
                            "OTP verification successful. Redirecting to logged-in page..."
                        );
                        window.location.href = "user.php";
                    } else {
                        // If OTP verification fails, display an error message to the user
                        document.getElementById("resultMessage").innerText = data.message;
                        document.getElementById("resultMessage").classList.remove("hideit");
                    }
                })
                .catch((error) => console.error("Error:", error));
        }
    }

    function check_number() {
        var phoneNumber = document.getElementById("phoneNumber").value;
        // Regular expression to validate phone number format (E.164 format)
        var phoneNumberPattern = /^\d{10}$/;

        if (phoneNumberPattern.test(phoneNumber)) {
            sendOTP(); // If phone number format is correct, proceed to send OTP
        } else {
            alert("Please enter a valid phone number"); // Display error message
        }
    }
</script>

</html>
</body>

</html>