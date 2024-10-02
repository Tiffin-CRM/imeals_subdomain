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



    <style>
        :root {
            --h1: bold 54px/60px var(--ff);
            --h2: bold 36px/48px var(--ff);
            --h3: bold 24px/36px var(--ff);
            --links: 18px/18px var(--ff);
            --p: 18px/30px var(--ff);
            --p1: 24px/30px var(--ff);
            --p2: 36px/48px var(--ff);
            --subtext: 12px/20px var(--ff);
            --transition: 0.3s ease-in-out;
            /* CSS HEX */
            --primary: #3e51b5;
            --text: #6b7280;
            --light: #ccc;
            --secondary: #2c2c2c;
        }

        body {
            background-color: #ffffff;
        }

        .full_section {
            max-width: 800px;
            padding: 15px;
            display: block;
            margin: 0 auto;
        }

        .input_field_container {
            margin: 14px auto;
        }

        input,
        select {
            width: 100%;
            padding: 12px 12px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            background: transparent;
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 400;
        }

        input:focus,
        select:focus {
            border-color: #3e51b5;
        }

        .submit_btn {
            width: 100%;
            background: var(--primary);
            color: white;
            padding: 16px 20px;
            margin: 25px 0;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
        }

        button:hover {
            scale: 1.009;
        }

        input[type=submit]:hover {
            background-color: #d33500;
        }

        label {
            display: block;
            font-size: 0.875rem;
            color: #2c2c2c;
            font-weight: 500;
            /* margin-bottom: 10px; */
        }



        .error_message {
            color: red;
            font-size: 12px;
            display: block;

        }

        .get_location_btn {
            width: 100%;
            color: #6b7280;
            padding: 14px 20px;
            margin: 10px 0;
            background-color: transparent;
            border: rgb(221, 221, 221) 1px solid;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
        }


        .enter_manually_btn {
            font-size: 0.875rem;
            color: #2c2c2c;
            font-weight: 500;
        }

        #add_note_btn_container {
            font-size: 14px;
            color: rgb(41, 41, 41);
            font-weight: 600;
            cursor: pointer;
        }


        img {
            max-width: 100%;
        }

        .page_info {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-size: 13px;
            gap: 5px;
        }

        .page_info h2 {
            font-size: 20px;
        }

        .page_info span {
            font-size: 14px;
            color: #6b7280;
        }

        a {
            color: #3e51b5;
            font-weight: 600;
        }

        .input_desc {
            font-size: 12px;
            color: #6b7280;
            font-weight: 400;
            margin-top: -59px;
        }

        .need_help_container {
            text-align: center;
            margin-bottom: 50px;
        }

        .extra_btn_container {
            margin: 20px auto;
        }

        .or_text {
            font-size: 14px;
            color: var(--text);
            font-weight: 500;
            margin-top: -11px;
            background-color: #ffffff;
            padding: 0px 10px;
        }

        hr {
            border-top: var(--primary);
        }

        .secondary_btn {
            background-color: transparent;
            border: 1px solid var(--light);
            color: var(--text);
            width: 100%;
            padding: 16px 20px;
            margin: 25px 0;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
        }

        .overlay {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1;
            justify-content: center;
            align-items: center;
        }

        .overlay-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            max-width: 800px;
            animation: slideIn 0.5s forwards;
            padding-bottom: 40px;

            /* Add animation */

        }

        @keyframes slideIn {
            from {
                transform: translateY(100%);
                /* Start from below the screen */
                opacity: 0;
                /* Start invisible */
            }

            to {
                transform: translateY(0);
                /* End in its place */
                opacity: 1;
                /* Fully visible */
            }
        }


        @media screen and (max-width: 600px) {
            .overlay-content {
                position: fixed;
                width: 98%;
                bottom: 0;
            }

        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@2.1.0/dist/iconify-icon.min.js"></script>
</head>

<body>
    <main>
        <section class="full_section">

            <div class="page_info">
                <img src="https://momscanteen.in/wp-content/uploads/2021/09/moms_canteen_logo.png" alt="" width="100px">
                <h2>Start Getting Healthy Meals</h2>
                <span>Enter your details to create your account with us</span>
                <span>Already have an account? <a href="#" id="login">Login</a></span>
            </div>
        </section>
        <section class="full_section">
            <div class="form_container">
                <form id="signup_form" action="#">
                    <div class="input_field_container">
                        <label for="name">Full Name</label>
                        <input type="text" name="name" id="name" placeholder="Enter Name Here" value="Shubham">
                        <small id="name_error" class="error_message"></small>

                    </div>
                    <div class="input_field_container">
                        <label for="phone">Phone Number</label>
                        <input type="number" name="phone" id="phone" placeholder="Enter Your Phone Number here"
                            value=9068062563>
                        <span class="input_desc">Without Country Code</span>
                        <small id="phone_error" class="error_message"></small>

                    </div>
                    <div class="input_field_container">
                        <label for="zoney">Select Zone/Area</label>
                        <select name="zone" id="zone">
                            <option value="">Select Area</option>
                            <option value="Area 1" selected>Area 1</option>
                            <option value="Area 2">Area 2</option>
                        </select>
                        <small id="zone_error" class="error_message"></small>
                    </div>
                    <div class="input_field_container">
                        <label for="location">Delivery Location</label>
                        <input type="hidden" name="location" id="location" placeholder="Latitude,Longitude"
                            value="5757, 5757">
                        <button type="button" class="get_location_btn r-flex ali-c jut-c gap-1" id="get_location_btn"
                            onclick="get_user_location()"> <iconify-icon icon="f7:location-fill"
                                height="14"></iconify-icon> Get Current Location
                        </button>
                        <span class="input_desc pointer" onclick="enableManualEntry(this)" id="manual_entry_desc">You
                            can
                            enter
                            it <span style="text-decoration: underline;">Manually</span> as well</span>
                        <small id="location_error" class="error_message"></small>
                    </div>
                    <div class="input_field_container">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address"
                            placeholder="Include Delivery Instructions or city level address" value="5757, 5757">
                        <small id="address_error" class="error_message"></small>
                    </div>
                    <div class="input_field_container">
                        <label for="diet_pref">Dietary Preference</label>
                        <br>
                        <div class="r-flex ali-c gap-2">
                            <div class="r-flex ali-c jut-c gap-1">
                                <input type="radio" id="veg" name="diet_pref" value="Vegetarian" checked>
                                <label for="veg">Vegetarian</label>
                            </div>
                            <div class="r-flex ali-c jut-c gap-1">
                                <input type="radio" id="non_veg" name="diet_pref" value="Non-Vegetarian">
                                <label for="non_veg">NonVeg</label>
                            </div>
                        </div>
                        <br>
                        <small id="diet_pref_error" class="error_message"></small>
                    </div>
                    <div class="input_field_container">
                        <button type="submit" class="submit_btn r-flex ali-c jut-c gap-1">Signup Now <iconify-icon
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
    // Function to get user location
    function get_user_location() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                console.log("Latitude: " + latitude);
                console.log("Longitude: " + longitude);
                document.getElementById("location").value = latitude + "," + longitude;
                document.getElementById("manual_entry_desc").innerHTML = "Fetched your Location as " + latitude + "," + longitude;
            }, function (error) {
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        alert("User denied the request for Geolocation.");
                        break;
                    case error.POSITION_UNAVAILABLE:
                        alert("Location information is unavailable.");
                        break;
                    case error.TIMEOUT:
                        alert("The request to get user location timed out.");
                        break;
                    case error.UNKNOWN_ERROR:
                        alert("An unknown error occurred.");
                        break;
                }
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }
    // Function to enable manual entry
    function enableManualEntry(caller) {
        document.getElementById("location").setAttribute("type", "text");
        caller.style.display = "none";
    }

    function show_this_hide_me(caller, ele) {
        document.getElementById(ele).style.display = "block";  // Show the target element
        caller.style.display = "none";  // Hide the calling element
    }


</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fields = [
            { id: 'name', errorId: 'name_error', event: 'input', validation: value => value.trim() !== "" },
            { id: 'phone', errorId: 'phone_error', event: 'input', validation: value => value.trim().length > 5 },
            { id: 'zone', errorId: 'zone_error', event: 'change', validation: value => value !== "" },
            { id: 'address', errorId: 'address_error', event: 'input', validation: value => value.trim() !== "" },
        ];

        // Add event listeners for input validation
        fields.forEach(field => {
            document.getElementById(field.id).addEventListener(field.event, function () {
                if (field.validation(this.value)) {
                    document.getElementById(field.errorId).innerText = "";
                }
            });
        });

        // Handle location validation through button click
        const locationInput = document.getElementById('location');
        document.getElementById('get_location_btn').addEventListener('click', function () {
            // Assuming this button fetches and inserts the location value
            const locationValue = ""; // Replace this with the actual location fetching logic
            locationInput.value = locationValue;
            document.getElementById('location_error').innerText = ""; // Clear error if location is set
        });

        // Add event listener for dietary preference
        document.querySelectorAll('input[name="diet_pref"]').forEach(option => {
            option.addEventListener('change', function () {
                document.getElementById('diet_pref_error').innerText = "";
            });
        });

        // Form submission event listener
        document.getElementById('signup_form').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent form submission to allow validation
            let isValid = true;

            // Validate fields
            fields.forEach(field => {
                const value = document.getElementById(field.id).value;
                if (!field.validation(value)) {
                    document.getElementById(field.errorId).innerText = `Valid ${field.id.replace('_', ' ')} is required.`;
                    isValid = false;
                }
            });

            // Location Validation
            if (locationInput.value.trim() === "") {
                document.getElementById('location_error').innerText = "Delivery location is required.";
                isValid = false;
            }

            // Dietary Preference Validation
            const dietPref = document.querySelector('input[name="diet_pref"]:checked');
            if (!dietPref) {
                document.getElementById('diet_pref_error').innerText = "Please select a dietary preference.";
                isValid = false;
            }

            if (isValid) {
                // Create an object with the form values
                const formData = {
                    name: document.getElementById('name').value,
                    phone: document.getElementById('phone').value,
                    zone: document.getElementById('zone').value,
                    location: locationInput.value,
                    address: document.getElementById('address').value,
                    diet_pref: dietPref ? dietPref.value : null
                };


                const overlay_desc = document.getElementById('overlay_desc');
                const overlay_title = document.getElementById('overlay_title');
                const player = document.getElementById('lottiePlayer');
                document.getElementById("overlay").style.display = "flex"; // Show the overlay
                document.body.classList.add('noscroll'); // Prevent background scrolling

                const overlay_btn = document.getElementById('overlay_btn');
                overlay_title.innerText = "Checking Info...";
                overlay_desc.innerText = "Sending your details to account creation bot..."; // Show loading message
                overlay_desc.style.display = 'block'; // Make loading message visible

                // Submit the form data using Fetch API
                fetch('php/signup_info.php', {
                    method: 'POST',
                    mode: 'no-cors',
                    headers: {
                        'Content-Type': 'application/json' // Indicate we are sending JSON
                    },
                    body: JSON.stringify(formData), // Convert formData to JSON string
                })
                    .then(response => {
                        overlay_title.innerText = "Got Something...";
                        overlay_desc.innerText = "Showing it to you...";

                        // Check if the response is OK (status in the range 200-299)
                        if (response.ok) {
                            return response.text(); // or response.json() if your server returns JSON
                        } else {
                            throw new Error(`Error: ${response.status}`);
                        }
                    })
                    .then(data => {
                        player.load("https://lottie.host/dcc2ef95-baa4-4c58-bc6c-96cd7ad39738/Q5JyZC9T9T.json"); // New Lottie animation URL
                        player.play();
                        overlay_title.innerText = "Account created";
                        overlay_desc.innerText = "Your account has been created. Now Add your Meal Plan to it and balance as well";
                        overlay_btn.onclick = add_meal_plan;
                        overlay_btn.style.display = 'block';
                        console.log(data); // Log response from signup_info.php
                    })
                    .catch(error => {
                        player.load("https://lottie.host/56727919-60ee-4dae-9119-0f1b5883e8d9/y1MHYvXsoV.json"); // New Lottie animation URL
                        player.play();
                        overlay_title.innerText = "Ops Error Found..";
                        overlay_desc.innerText = "Error: " + error; // Show error message in loading
                        overlay_btn.style.display = 'block'; // Ensure the message is visible
                        overlay_btn.onclick = contact_support;
                        overlay_btn.innerText = 'Contact Support';
                        console.error("Error:", error); // Handle errors
                    });
            } else {
                console.log("Form is invalid. Correct the errors above.");
            }
        });
    });

    document.getElementById("login").addEventListener("click", function (event) {
        // document.getElementById("signup_form").style.display = "none";
        document.body.classList.add('noscroll'); // Prevent background scrolling
        document.getElementById("overlay").style.display = "flex"; // Show the overlay
    });

    document.getElementById("closeOverlay").addEventListener("click", function () {
        document.getElementById("overlay").style.display = "none"; // Hide the overlay
        document.body.classList.remove('noscroll'); // Prevent background scrolling
    });
    // document.getElementById("overlay").style.display = "flex"; // Show the overlay
    function changeLottie() {
        const player = document.getElementById('lottiePlayer');
        player.load("https://lottie.host/dcc2ef95-baa4-4c58-bc6c-96cd7ad39738/Q5JyZC9T9T.json");
    }

    function contact_support() {
        const phoneNumber = '9253029002';
        const message = 'Contact support.';
        const whatsappLink = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
        window.open(whatsappLink, '_blank');
    }

    function add_meal_plan() {
        alert('Thank you for adding your meal plan. You can now enjoy your meal plan. :)')
        window.open('add-plan.php');
    }


</script>

</html>