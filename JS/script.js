// ..............datepickers
$(document).ready(function () {
  $('#rentaldate').flatpickr({
    dateFormat: 'Y-m-d', // Sets the date format to 'yyyy-mm-dd'
    allowInput: true, // Allows manual input for flexibility
    clickOpens: true, // Opens calendar on click
    onClose: function () { // Mimics autoclose by closing on selection
      this.close();
    }
  });
});

$(document).ready(function () {
  $('#returndate').flatpickr({
    dateFormat: 'Y-m-d', // Sets the date format to 'yyyy-mm-dd'
    allowInput: true, // Allows manual input for flexibility
    clickOpens: true, // Opens calendar on click
    onClose: function () { // Mimics autoclose by closing on selection
      this.close();
    }
  });
});



// ..... Loading Spinner .....
const spinnerBg = document.getElementById('spinner');

window.addEventListener('load', () => { //set the opacity to 0 after page complete loading.


  setTimeout(() => {
    spinnerBg.style.opacity = '0';
    spinnerBg.classList.remove('d-block'); // Remove the 'd-block' class
    spinnerBg.classList.add('d-none'); // Add the 'd-none' class
  }, 250);

});



//.....Navbar.....

//navbar shadow
const navc = document.getElementById('nav-container');

window.addEventListener('scroll', () => {
  if (window.scrollY >= 50) {
    navc.classList.add('nav-shadow');
  } else {
    navc.classList.remove('nav-shadow');
    navc.classList.add('no-nav-shadow');
  }
});

//.....carousal....

var myCarousel = document.querySelector('#carouselExampleRide');
var carousel = new bootstrap.Carousel(myCarousel, {
  interval: 4000 // 5 seconds
});


// ...............date picker

$(document).ready(function () {

  $('#dateInput').datepicker({
    format: 'mm/dd/yyyy', // Change the format as needed
    autoclose: true // Close the datepicker after selection
  });

  $('#dateInput2').datepicker({
    format: 'mm/dd/yyyy',
    autoclose: true
  });
});

//..............scroll to vehicle
function scrollToVehicles() {
  var element = document.getElementById("vehicles");

  var elementPosition = element.getBoundingClientRect().top;

  var offsetPosition = window.scrollY + elementPosition - 140;

  window.scrollTo({
    top: offsetPosition,
    behavior: "smooth"
  });
}
//..............scroll to Home
function scrollToHome() {

  window.scrollTo({
    top: 0,
    behavior: "smooth"
  });
}

//..........Scroll to contact us
function scrollToContactUs() {

  window.scrollTo({

    top: document.body.scrollHeight,
    behavior: "smooth"
  });
}


//..................button links

function goToLogin() {
  window.location.href = 'login.php';

}

// ..................dashboard

function changeDashboardContent(status) {

  var XHR = new XMLHttpRequest();

  XHR.open("POST", "http://localhost/IsuruCarService/dashboard/AJAX/dashboard.php", true);

  var formData = new FormData();
  formData.append("status", status);

  XHR.send(formData);
  XHR.onreadystatechange = function () {

    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("table").innerHTML = this.responseText;
    }
  };
}

// ............................profile

var el = document.getElementById("wrapper");
var toggleButton = document.getElementById("menu-toggle");

toggleButton.onclick = function () {
  el.classList.toggle("toggled");
};



function updateDetails(event) {

  var XHR = new XMLHttpRequest();

  XHR.open("POST", "http://localhost/IsuruCarService/dashboard/updateDetails.php", true);

  var formData = new FormData();
  var sts = 0;


  if (document.getElementsByName('email')[0].value != "") {

    formData.append("email", document.getElementsByName('email')[0].value);
  }

  if (document.getElementsByName('fname')[0].value != "") {

    formData.append("fname", document.getElementsByName('fname')[0].value);
  }

  if (document.getElementsByName('lname')[0].value != "") {

    formData.append("lname", document.getElementsByName('lname')[0].value);
  }

  if (document.getElementsByName('address')[0].value != "") {

    formData.append("address", document.getElementsByName('address')[0].value);
  }

  if (document.getElementsByName('lnumber')[0].value != "") {

    formData.append("lnumber", document.getElementsByName('lnumber')[0].value);
  }

  if (document.getElementsByName('pnumber')[0].value != "") {

    formData.append("pnumber", document.getElementsByName('pnumber')[0].value);
  }



  XHR.send(formData);
  XHR.onreadystatechange = function () {

    if (this.readyState == 4 && this.status == 200) {


      try {
        var response = JSON.parse(this.responseText);

        if ('Email' in response && response.Email) {
          document.getElementsByName("email")[0].placeholder = response.Email;
        }

        if ('Lname' in response && response.Lname) {
          document.getElementsByName("lname")[0].placeholder = response.Lname;
        }

        if ('Address' in response && response.Address) {
          document.getElementsByName("address")[0].placeholder = response.Address;
        }

        if ('License_number' in response && response.License_number) {
          document.getElementsByName("lnumber")[0].placeholder = response.License_number;
        }

        if ('Phone_number' in response && response.Phone_number) {
          document.getElementsByName("pnumber")[0].placeholder = response.Phone_number;
        }

        if ('Fname' in response && response.Fname) {
          document.getElementsByName("fname")[0].placeholder = response.Fname;
        }



      } catch (error) {
        console.error("Error parsing JSON response:", error);
      }

    }
  };


  localStorage.setItem("showToast", "true");


}







// ....................Booking Page


function bookingProcess(event) {

  event.preventDefault();

  var returndate = document.getElementById("returndate").value;
  var rnumber = document.getElementById("rnumber").value;
  var rentaldate = document.getElementById("rentaldate").value;

  if (!rnumber || !rentaldate || !returndate) {
    alert("Please fill out all required fields.");
    return;
  }

  var XHR = new XMLHttpRequest();
  XHR.open("POST", "http://localhost/IsuruCarService/dashboard/AJAX/bookingProcess.php", true);
  var formData = new FormData();

  formData.append("rnumber", rnumber);
  formData.append("rentaldate", rentaldate);
  formData.append("returndate", returndate);

  XHR.send(formData);

  XHR.onreadystatechange = function () {

    if (this.readyState == 4 && this.status == 200) {

      localStorage.setItem("showToast", "true");

      updateNotifications(-1);
      window.location.reload();

    }
  };
}



function addRegistrationNumber(rnumber) {

  rnum = document.getElementById("rnumber");
  rnum.value = rnumber;

}

//..............................Notifications

function updateNotifications(id) {

  var XHR = new XMLHttpRequest();
  XHR.open("POST", "http://localhost/IsuruCarService/dashboard/AJAX/notifications.php", true);
  var formData = new FormData();
  formData.append("id", id);

  XHR.send(formData);

  XHR.onreadystatechange = function () {

    if (this.readyState == 4 && this.status == 200) {

      notificationCount.innerHTML = XHR.responseText;


    }
  };

  if (id != -1) {

    const notifi = document.getElementById(id);
    notifi.classList.replace("notifi", "notifi-read");

  }

  var notificationCount = document.getElementById("notifications");


  if (notificationCount.innerText == 0) {

    notificationCount.style.display = "none";
  } else {
    notificationCount.style.display = "block";
  }

}


