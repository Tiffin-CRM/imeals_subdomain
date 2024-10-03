function trucaller_got_number() {
  show_bottom_popup(
    "Getting Your Account Info..",
    "Checking if you have an account with us..."
  );
  check_if_account();
  page_loading(false);
}

function account_found() {
  overlay_lottie(
    "https://lottie.host/dcc2ef95-baa4-4c58-bc6c-96cd7ad39738/Q5JyZC9T9T.json"
  );
  show_bottom_popup(
    "Account Found..Loging In",
    "We are redirecting you to Login Page."
  );
}
function account_not_found() {
  show_bottom_popup(
    "Account Not Found..",
    "If You want to create an account with us, click on Create Account."
  );
  overlay_btn.innerHTML = "Create Account";
  overlay_btn.onclick = function () {
    window.location.href = "/signup.php";
  };
  overlay_btn.style.display = "block";
}
function check_if_account() {
  // var phoneNumber = localStorage.getItem("phone");
  var phoneNumbervalue = document.getElementById("phoneNumber").value;
  // var token = localStorage.getItem("token");

  // Ensure phoneNumber and token are available
  if (!phoneNumbervalue) {
    alert("Phone number is missing.");
    return;
  }

  fetch("/php/check_account.php", {
    method: "POST",
    body: JSON.stringify({ phone: phoneNumbervalue }),
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok " + response.statusText);
      }
      return response.json();
    })
    .then((data) => {
      console.log(data); // Log the response from the server
      // alert(data.message); // Show message received from server

      if (data.usertype === "existing") {
        account_found();
      } else if (data.usertype === "new") {
        account_not_found();
      } else {
        console.error("Unexpected usertype:", data.usertype);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("There was a problem with the request.");
    });
}

function sendOTP() {
  var phoneNumber = document.getElementById("phoneNumber").value;
  document.getElementById("phone_hint").style.display = "initial";
  document.getElementById("phone_hint").innerHTML = "Sending OTP";
  document.getElementById("phoneNumber").disabled = true;
  document.getElementById("send_otp").classList.add("hideit");
  document.getElementById("otp_section").classList.remove("hideit");

  fetch("https://momscanteen.imeals.in/php/send_otp.php", {
    method: "POST",
    body: JSON.stringify({ phoneNumber: phoneNumber }),
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.json())
    .then((data) => {
      document.getElementById("phone_hint").innerHTML = "OTP Sent";
      console.log(data);
      // Parse the payload string into a JSON object
      var payload = JSON.parse(data.payload);
      // Check if otp exists
      if (payload && payload.otp) {
        alert(payload.otp); // Display the OTP
      } else {
        alert("OTP not found in response");
      }
    })
    .catch((error) => console.error("Error:", error));
}

function getOTP() {
  var enteredOTP = document.getElementById("otpInput").value;
  var otpPattern = /^\d{4}$/;
  if (!otpPattern.test(enteredOTP)) {
    document.getElementById("otp_error").innerHTML = "Please enter a valid otp";
  } else {
    fetch("https://momscanteen.imeals.in/php/verify_otp.php", {
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
          // window.location.href = "user.php";
          document.getElementById("otp_error").style.display = "none";
          document.getElementById("phone_error").style.display = "none";
          document.getElementById("otp_hint").style.display = "initial";
          document.getElementById("otp_hint").innerHTML = "OTP Verified";

          trucaller_got_number();
        } else {
          // If OTP verification fails, display an error message to the user
          document.getElementById("otp_error").innerText = data.message;
          document.getElementById("otp_error").classList.remove("hideit");
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
    document.getElementById("phone_error").innerHTML =
      "Please enter a valid Phone Number";
    document.getElementById("phone_hint").style.display = "none";
  }
}
function check_number_format() {
  var phoneNumber = document.getElementById("phoneNumber").value;
  var phoneNumberPattern = /^\d{10}$/;
  if (phoneNumberPattern.test(phoneNumber)) {
    document.getElementById("phone_error").style.display = "none";
  }
}

let truecaller_request_id = null; // Initialize as null
let isSuccess = false; // Global success flag
let retryCount = 0; // Retry attempt counter
let pushed_truecaller = false;
function try_truecaller_login() {
  const partnerName = "Imeals";
  const privacyUrl = "https://imeals.in/privacy-policy";
  const termsUrl = "https://imeals.in/terms";
  const loginPrefix = "proceed";
  const loginSuffix = "verifymobile";
  const ctaPrefix = "proceedwith";
  const ctaColor = encodeURIComponent("default");
  const ctaTextColor = encodeURIComponent("default");
  const btnShape = "round";
  const skipOption = "manualdetails";
  const ttl = 60000;
  const randomid = Math.floor(Math.random() * 1000000);
  truecaller_request_id = randomid + Date.now(); // Set global request ID
  // document.getElementById("request_id").innerHTML = truecaller_request_id;
  // Properly formatted URL
  window.location = `truecallersdk://truesdk/web_verify?type=btmsheet&requestNonce=${truecaller_request_id}&partnerKey=Wxruhf8a1644c5276496993024a726dc506f1&partnerName=${partnerName}&lang=en&privacyUrl=${privacyUrl}&termsUrl=${termsUrl}&loginPrefix=${loginPrefix}&loginSuffix=${loginSuffix}&ctaPrefix=${ctaPrefix}&ctaColor=${ctaColor}&ctaTextColor=${ctaTextColor}&btnShape=${btnShape}&skipOption=${skipOption}&ttl=${ttl}`;
  setTimeout(function () {
    if (document.hasFocus()) {
      // Truecaller app not present on the device and you redirect the user
      // to your alternate verification page
    } else {
      page_loading(true);
      // Add an event listener to the window for the 'focus' event
      window.addEventListener("focus", function () {
        get_truecaller_response();
      });
    }
  }, 600);
}

// Add event listener to the button
function get_truecaller_response() {
  if (truecaller_request_id) {
    page_loading(true);
    // Make a POST request to the PHP endpoint to fetch user info
    fetch("https://imeals.in/truecaller/get_response.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        truecaller_request_id,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "ok") {
          // Display the user info in HTML
          isSuccess = true;
          const userInfo = data.data;
          // Store data in localStorage
          localStorage.setItem("userInfoData", JSON.stringify(userInfo));
          localStorage.setItem("token", userInfo.token);
          localStorage.setItem("phone", userInfo.phoneNumber);
          localStorage.setItem("name", userInfo.fullName);
          localStorage.setItem("email", userInfo.email);
          document.getElementById("phoneNumber").value = parseInt(
            userInfo.phoneNumber,
            10
          );
          trucaller_got_number();
        } else {
          // Display error message
          retryRequest(retryCount + 1); // Call retryRequest
        }
      })
      .catch((error) => {
        console.error("Fetch error:", error);
      });
    page_loading(false);
  } else {
    // Display an error if truecaller_request_id is empty
    document.getElementById(
      "userInfo"
    ).innerHTML = `<p style="color: red;">Please enter a Request ID.</p>`;
    page_loading(false);
  }
}

function retryRequest(attempt) {
  const maxAttempts = 30;
  const interval = attempt <= 20 ? 3000 : attempt <= 25 ? 6000 : 60000;

  if (attempt <= maxAttempts && !isSuccess) {
    setTimeout(() => {
      retryCount = attempt; // Update retry count
      get_truecaller_response(); // Retry fetching response
    }, interval);
  }
}
function page_loading(isLoading) {
  var loadingLayer = document.getElementById("loadingLayer");
  if (isLoading) {
    loadingLayer.style.display = "flex";
  } else {
    loadingLayer.style.display = "none";
  }
}
function truecaller_push() {
  if (!pushed_truecaller) {
    // Check if the user is on a mobile device and using Android
    var isAndroid = /Android/i.test(navigator.userAgent);

    if (isAndroid) {
      try_truecaller_login();
      pushed_truecaller = true;
    }
  }
}
