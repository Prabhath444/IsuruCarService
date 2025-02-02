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
