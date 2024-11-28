$(document).ready(function () {
    document
        .getElementById("searchInput")
        .addEventListener("input", function () {
            const searchValue = this.value.toLowerCase();
            const employeeItems = document.querySelectorAll(".employee-item");

            employeeItems.forEach((item) => {
                const name = item.getAttribute("data-name").toLowerCase();
                const nip = item.getAttribute("data-nip").toLowerCase();
                const email = item.getAttribute("data-email").toLowerCase();

                // Check if search value matches any attribute
                if (
                    name.includes(searchValue) ||
                    nip.includes(searchValue) ||
                    email.includes(searchValue)
                ) {
                    item.style.display = ""; // Show
                } else {
                    item.style.display = "none"; // Hide
                }
            });
        });
});
