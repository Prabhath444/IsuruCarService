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
  interval: 4000 // 4 seconds
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

// ..................customer dashboard

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

// ..................admin dashboard

function changeAdminDashboardContent(status) {

  var XHR = new XMLHttpRequest();

  XHR.open("POST", "http://localhost/IsuruCarService/admin/AJAX/dashboard.php", true);

  var formData = new FormData();
  formData.append("status", status);

  XHR.send(formData);
  XHR.onreadystatechange = function () {

    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("table").innerHTML = this.responseText;
    }
  };
}
// ..................admin payments

function changeAdminPaymentsContent(status) {

  var XHR = new XMLHttpRequest();

  XHR.open("POST", "http://localhost/IsuruCarService/admin/AJAX/payments.php", true);

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

// ............................Settle payment
function settlePayment(id) {

  var XHR = new XMLHttpRequest();
  XHR.open("POST", "http://localhost/IsuruCarService/admin/AJAX/settlePayments.php", true);

  var formData = new FormData();
  formData.append("rentID", id);
  XHR.send(formData);


  XHR.onreadystatechange = function () {

    if (this.readyState == 4 && this.status == 200) {

      try {

        var response = JSON.parse(XHR.responseText);

        if (response.error) {
          console.log(response.error);
        } else {

          document.getElementById('Email').value = response.Email;
          document.getElementById('vehicle').value = response.Make + " " + response.Model;
          document.getElementById('rentdate').value = response.Rental_date;
          document.getElementById('retdate').value = response.Return_date;
          document.getElementById('maxmilage').value = response.Total_KM;
          document.getElementById('rentId').value = response.Rental_ID;


          const addmilageInput = document.getElementById("addmilage");
          const totalKM = document.getElementById("totmilage");
          const totalAmount = document.getElementById("totamount");

          // Add an event listener to the input field
          totalKM.addEventListener("input", () => {
            const inputValue = totalKM.value;

            if (!isNaN(inputValue) && inputValue !== "") {
              const addmilage = parseFloat(inputValue) - parseFloat(response.Total_KM);
              const totAmount = parseFloat(inputValue) * parseFloat(response.Rental_rate);

              if (addmilage > 0) {
                addmilageInput.value = addmilage;
                totalAmount.value = totAmount;
              } else {
                addmilageInput.value = 0;
                totalAmount.value = parseFloat(response.Total_KM) * parseFloat(response.Rental_rate);
              }


            } else {
              totalAmount.value = 0;
            }
          });
        }

      } catch (e) {
        console.error("Error parsing JSON response:", e);
        alert("An unexpected error occurred. Please try again.");
      }


    }
  };

}

// .....................settle payment form submit process

function submitSettlePaymentForm() {
  var XHR = new XMLHttpRequest();

  XHR.open("POST", "http://localhost/IsuruCarService/admin/AJAX/settlePaymentProcess.php", true);

  var formData = new FormData(document.getElementById("settlepaymentform"));

  XHR.send(formData);

  XHR.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      try {

        localStorage.setItem("showToast", "true");
        window.location.reload();

      } catch (error) {
        console.error("Error parsing server response:", error);
        alert("Unexpected server response.");
      }
    }
  };

}

function lReload() {
  location.reload();
}

//.............................addExpenses
function addExpenses() {

  const description = document.getElementById("Description").value.trim();
  const date = document.getElementById("date").value.trim();
  const amount = document.getElementById("amount").value.trim();
  const vehicle = document.getElementById("Vehicle").value.trim();

  const errorMsgElement = document.getElementById("errormsg");

  let isValid = true;
  let errorMessage = "";


  if (vehicle === "") {
    isValid = false;
    errorMessage = "Vehicle Registration Number is required.";
  }

  const amountRegex = /^[1-9]\d*(\.\d{1,2})?$/;
  if (!amountRegex.test(amount)) {
    isValid = false;
    errorMessage = "Amount must be a valid positive number.";
  }


  const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
  if (!dateRegex.test(date)) {
    isValid = false;
    errorMessage = "Date is required";
  }

  if (description === "") {
    isValid = false;
    errorMessage = "Description is required.";
  }



  if (!isValid) {
    errorMsgElement.innerHTML = errorMessage;
    errorMsgElement.style.display = "block";
    return;
  }

  var XHR = new XMLHttpRequest();
  XHR.open("POST", "http://localhost/IsuruCarService/admin/AJAX/expenses.php", true);

  var formData = new FormData();
  formData.append("Description", description);
  formData.append("date", date);
  formData.append("amount", amount);
  formData.append("vehicleReg", vehicle);
  XHR.send(formData);

  XHR.onload = function () {
    if (XHR.status === 200) {

      //alert(this.responseText);
      localStorage.setItem("showToast", "true");

      window.location.reload();


    } else {
      alert("Error: Could not add expenses.");
    }
  };

  XHR.onerror = function () {
    alert("Network error occurred.");
  };
}

//......................Delete Expense

var exampleModal = document.getElementById('deleteExp');

if (exampleModal) {
    exampleModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        if (button) {
            var RegNumber = button.getAttribute('data-id');
            var ExpenseName = button.getAttribute('data-name');

            let modalText = document.getElementById("modal-text");
            if (modalText) {
                modalText.innerText = "Are you sure you want to delete Expense " + ExpenseName;
            }

            let confirmButton = document.getElementById("confirmDeleteVehicle");
            if (confirmButton) {
                confirmButton.setAttribute("data-id", RegNumber);
            }
        }
    });

    var confirmDeleteButton = document.getElementById("confirmDeleteVehicle");
    if (confirmDeleteButton) {
        confirmDeleteButton.addEventListener("click", function () {
            var vehicleId = this.getAttribute("data-id");

            var XHR = new XMLHttpRequest();

            XHR.open("POST", "http://localhost/IsuruCarService/admin/AJAX/deleteVehicle.php", true);
            var formData = new FormData();
            formData.append("vehId", vehicleId);
            XHR.send(formData);

            XHR.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {

                    if(this.responseText){
                        alert(this.responseText);
                    }
                    window.location.reload();
                }
            };


        });
    }
}



//....................Delete Expenses
function deleteExpense(id) {

  var XHR = new XMLHttpRequest();
  XHR.open("POST", "http://localhost/IsuruCarService/admin/AJAX/deleteExpense.php", true);

  var formData = new FormData();
  formData.append("ID", id);
  XHR.send(formData);

  XHR.onload = function () {
    if (XHR.status === 200) {

      //alert(this.responseText);
      localStorage.setItem("showToast", "true");

      window.location.reload();


    } else {
      alert("Error: Could not add expenses.");
    }
  };

  XHR.onerror = function () {
    alert("Network error occurred.");
  };
}

function generateReport() {
  const rentals = [
      { car: "Toyota Corolla", customer: "John Doe", days: 5, pricePerDay: 40 },
      { car: "Honda Civic", customer: "Jane Smith", days: 3, pricePerDay: 50 },
      { car: "Ford Mustang", customer: "Mike Johnson", days: 7, pricePerDay: 70 },
      { car: "Tesla Model 3", customer: "Emma Brown", days: 2, pricePerDay: 100 }
  ];

  let totalCars = rentals.length;
  let totalRevenue = 0;
  let tableBody = "";

  rentals.forEach(rental => {
      let totalCost = rental.days * rental.pricePerDay;
      totalRevenue += totalCost;
      
      tableBody += `
          <tr>
              <td>${rental.car}</td>
              <td>${rental.customer}</td>
              <td>${rental.days}</td>
              <td>$${rental.pricePerDay}</td>
              <td>$${totalCost}</td>
          </tr>
      `;
  });

  document.getElementById("reportTable").innerHTML = tableBody;
  document.getElementById("totalCars").innerText = totalCars;
  document.getElementById("totalRevenue").innerText = totalRevenue;
}


//................................Add vehicle

function addVehicle(event) {

  event.preventDefault();

  var vmodel = document.getElementById("vemodel").value;
  var vmake = document.getElementById("vemake").value;
  var rnumber = document.getElementById("renumber").value;
  var rrate = document.getElementById("rerate").value;
  var type = document.getElementById("vtype").value;
  var year = document.getElementById("vyear").value;
  var description = document.getElementById("vdescription").value;
  var img = document.getElementById("vimg").files[0];

  const decimalRegex = /^\d+(\.\d{1,4})?$/; // Matches up to 4 decimal places
  const yearRegex = /^(19|20)\d{2}$/; // Matches a year between 1900 and 2099

  var errmsg
  if (!vmodel) {
    alert("Vehicle Model is required.");
    return;
  }
  if (!vmake) {
    alert("Vehicle Make is required.");
    return;
  }
  if (!rnumber) {
    alert("Registration Number is required.");
    return;
  }
  if (!rrate || !decimalRegex.test(rrate)) {
    alert("Rental Rate must be a decimal number with up to 4 decimal points.");
    return;
  }
  if (!type) {
    alert("Vehicle Type is required.");
    return;
  }
  if (!year || !yearRegex.test(year)) {
    alert("Year must be a valid year (e.g., 2023).");
    return;
  }
  if (!description) {
    alert("Description is required.");
    return;
  }
  if (!img) {
    alert("An image is required.");
    return;
  }


  var XHR = new XMLHttpRequest();
  XHR.open("POST", "http://localhost/IsuruCarService/admin/AJAX/addvehicle.php", true);
  var formData = new FormData();

  formData.append("vmodel", vmodel);
  formData.append("vmake", vmake);
  formData.append("rnumber", rnumber);
  formData.append("rrate", rrate);
  formData.append("type", type);
  formData.append("year", year);
  formData.append("description", description);
  formData.append("img", img);


  XHR.send(formData);

  XHR.onreadystatechange = function () {

    if (this.readyState == 4 && this.status == 200) {

      //alert(this.responseText);
      localStorage.setItem("showToast", "true");

      window.location.reload();
    }
  };
}

function vehicleInfo(rNumber) {

  //alert('connected');
  var XHR = new XMLHttpRequest();
  XHR.open("POST", "http://localhost/IsuruCarService/admin/AJAX/vehicleInfo.php", true);
  var formData = new FormData();

  formData.append("rnumber", rNumber);

  XHR.send(formData);

  XHR.onreadystatechange = function () {

    if (this.readyState == 4 && this.status == 200) {

      var response = JSON.parse(this.responseText);

      alert(this.responseText);
      document.getElementsByName("model")[0].placeholder = response.Model;
      document.getElementsByName("make")[0].placeholder = response.Make;
      document.getElementsByName("rnumber")[0].placeholder = response.Registration_number;
      document.getElementsByName("type")[0].placeholder = response.Type;
      document.getElementsByName("year")[0].placeholder = response.Year;
      document.getElementsByName("rrate")[0].placeholder = response.Rental_rate;


    }
  };


}

// .................view customer details

function customerDetails(id) {
  var XHR = new XMLHttpRequest();

  XHR.open("POST", "http://localhost/IsuruCarService/admin/AJAX/customerDetails.php", true);
  var formData = new FormData();

  formData.append("id", id);
  XHR.send(formData);

  XHR.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {

      var response = JSON.parse(this.responseText);



      document.getElementsByName("name")[0].value = response.Fname+" "+response.Lname;
      document.getElementsByName("email")[0].value = response.Email;
      document.getElementsByName("address")[0].value = response.Address;
      document.getElementsByName("lnumber")[0].value = response.License_number;
      document.getElementsByName("rdate")[0].value = response.Registration_date;
      document.getElementsByName("pnumber")[0].value = response.Phone_number;
    }
  };

}






