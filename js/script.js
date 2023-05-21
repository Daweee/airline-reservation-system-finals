const flightTypeDropdown = document.getElementById("flighttype");

const returnDateContainer = document.getElementById("returnDateContainer");

flightTypeDropdown.addEventListener("change", function () {
  if (this.value === "oneway") {
    returnDateContainer.style.display = "none";
  } else {
    returnDateContainer.style.display = "block";
  }
});
