document.addEventListener("DOMContentLoaded", function () {
  const dates = document.querySelectorAll(".calendar span");
  const times = document.querySelectorAll(".time-slots span");

  const selectedDate = document.getElementById("selectedDate");
  const selectedTime = document.getElementById("selectedTime");

  dates.forEach(date => {
    date.addEventListener("click", () => {
      dates.forEach(d => d.classList.remove("selected"));
      date.classList.add("selected");
      selectedDate.value = date.innerText;
    });
  });

  times.forEach(time => {
    time.addEventListener("click", () => {
      times.forEach(t => t.classList.remove("selected"));
      time.classList.add("selected");
      selectedTime.value = time.innerText;
    });
  });
});