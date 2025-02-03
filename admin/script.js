//..........................delete customer


var exampleModal = document.getElementById('deleteCus');

if (exampleModal) {
    exampleModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        if (button) {
            var customerId = button.getAttribute('data-id');
            var customerName = button.getAttribute('data-name');

            let modalText = document.getElementById("modal-text");
            if (modalText) {
                modalText.innerText = "Are you sure you want to delete customer " + customerName;
            }

            let confirmButton = document.getElementById("confirmDelete");
            if (confirmButton) {
                confirmButton.setAttribute("data-id", customerId);
            }
        }
    });

    var confirmDeleteButton = document.getElementById("confirmDelete");
    if (confirmDeleteButton) {
        confirmDeleteButton.addEventListener("click", function () {
            var customerId = this.getAttribute("data-id");

            var XHR = new XMLHttpRequest();

            XHR.open("POST", "http://localhost/IsuruCarService/admin/AJAX/deleteCustomer.php", true);
            var formData = new FormData();
            formData.append("cusId", customerId);
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
//..........................delete Vehicle


var exampleModal = document.getElementById('deleteVeh');

if (exampleModal) {
    exampleModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        if (button) {
            var RegNumber = button.getAttribute('data-id');
            var vehicleName = button.getAttribute('data-name');

            let modalText = document.getElementById("modal-text");
            if (modalText) {
                modalText.innerText = "Are you sure you want to delete Vehicle " + vehicleName;
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


// .................view vehicle details

function vehicleDetails(id) {
    var XHR = new XMLHttpRequest();
  
    XHR.open("POST", "http://localhost/IsuruCarService/admin/AJAX/vehicleInfo.php", true);
    var formData = new FormData();
  
    formData.append("id", id);
    XHR.send(formData);
  
    XHR.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        
        var response = JSON.parse(this.responseText);
        
        document.getElementsByName("model")[0].value = (response[0].Model);
        document.getElementsByName("make")[0].value = (response[0].Make);
        document.getElementsByName("rnumber")[0].value = response[0].Registration_number;
        document.getElementsByName("type")[0].value = response[0].Type;
        document.getElementsByName("rrate")[0].value = response[0].Rental_rate;
        document.getElementsByName("year")[0].value = response[0].Year;
      }
    };
  
  }
