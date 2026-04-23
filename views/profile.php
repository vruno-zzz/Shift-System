<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: log-in.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="../STYLES/profile.css">
</head>
<body>

<div class="container">

    <div class="top-left">
        <h1><?= htmlspecialchars($_SESSION['user_name']); ?></h1>
    </div>

    <div class="top-right">
        <div class="avatar"></div>
    </div>

    <div class="bottom-left">
        <button class="btn" id="openModal">Solicitar Turno</button>
        <button class="btn" id="openDetails">Detalles de Turnos</button>
    </div>

    <div class="bottom-right">
        <h3>Turnos Futuros</h3>

<?php if (empty($futureShifts)): ?>
    <p>No tenés turnos futuros.</p>
<?php else: ?>
    <?php foreach ($futureShifts as $shift): ?>
        <div class="turno-card">
            <p><strong>Fecha:</strong> <?= $shift['day'] ?></p>
            <p><strong>Hora:</strong> <?= $shift['hour'] ?></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
    </div>

</div>
<!-- MODAL AGENDAR TURNO -->
<div class="modal" id="shiftModal">
    <div class="modal-content">

        <span class="close-btn" id="closeModal">&times;</span>
        <h2>Agendar Turno</h2>

        <div class="calendar-header">
            <button id="prevMonth">&#10094;</button>
            <h3 id="monthYear"></h3>
            <button id="nextMonth">&#10095;</button>
        </div>

        <div class="calendar" id="calendar"></div>

        <div class="time-section">
            <label>Hora:</label>
            <select id="timeSelect">
                <option value="">Seleccione hora</option>
            </select>
        </div>

        <div class="desc-section">
            <label>Descripción:</label>
            <textarea id="description" maxlength="350" placeholder="Máximo 350 caracteres"></textarea>
            <small id="charCount">0 / 350</small>
        </div>

        <button class="btn confirm-btn" id="confirmShift">Confirmar Turno</button>

    </div>
</div>
<!-- MODAL DETALLES TURNOS -->
<div class="modal" id="detailsModal">
    <div class="details-content">
        <span class="close-btn" id="closeDetails">&times;</span>
        <h2>Mis Turnos</h2>

        <div id="shiftList">
   <?php
        if ($allShifts) {
            foreach ($allShifts as $shift) {
             echo "
               <div class='shift-card'>
                <p><strong>Fecha:</strong> {$shift['day']}</p>
                <p><strong>Hora:</strong> {$shift['hour']}</p>
                <p class='status {$shift['status']}'>{$shift['status']}</p>
                </div>";
                }
            } else {
                echo "<p>No tienes turnos registrados.</p>";
            }
        ?>
        </div>
    </div>
</div>

<script>
const modal = document.getElementById("shiftModal");
const openBtn = document.getElementById("openModal");
const closeBtn = document.getElementById("closeModal");

openBtn.onclick = () => modal.style.display = "flex";
closeBtn.onclick = () => modal.style.display = "none";
window.onclick = (e) => { if(e.target == modal) modal.style.display = "none"; }

const calendar = document.getElementById("calendar");
const monthYear = document.getElementById("monthYear");
const timeSelect = document.getElementById("timeSelect");
const description = document.getElementById("description");
const charCount = document.getElementById("charCount");

let currentDate = new Date();
let selectedDate = null;

function generateCalendar(date){
    calendar.innerHTML = "";
    const year = date.getFullYear();
    const month = date.getMonth();

    monthYear.textContent = date.toLocaleString('default',{month:'long'}) + " " + year;

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month+1, 0).getDate();

    for(let i=0;i<firstDay;i++){
        calendar.innerHTML += "<div></div>";
    }

    for(let day=1;day<=daysInMonth;day++){
        const dayDate = new Date(year, month, day);
        const dayOfWeek = dayDate.getDay();

        const div = document.createElement("div");
        div.textContent = day;

        if(dayOfWeek === 0 || dayOfWeek === 6){
            div.classList.add("disabled");
        }else{
            div.classList.add("active");
            div.onclick = () => {
                document.querySelectorAll(".calendar div").forEach(d=>d.classList.remove("selected"));
                div.classList.add("selected");
                selectedDate = dayDate;
            }
        }

        calendar.appendChild(div);
    }
}

document.getElementById("prevMonth").onclick = () => {
    currentDate.setMonth(currentDate.getMonth()-1);
    generateCalendar(currentDate);
}
document.getElementById("nextMonth").onclick = () => {
    currentDate.setMonth(currentDate.getMonth()+1);
    generateCalendar(currentDate);
}

for(let hour=8;hour<=19;hour++){
    let option = document.createElement("option");
    option.value = hour + ":00";
    option.textContent = hour + ":00";
    timeSelect.appendChild(option);
}

description.addEventListener("input",()=>{
    charCount.textContent = description.value.length + " / 350";
});

generateCalendar(currentDate);
document.getElementById("confirmShift").addEventListener("click", function(){

    if(!selectedDate){
        alert("Seleccione un día");
        return;
    }

    if(!timeSelect.value){
        alert("Seleccione una hora");
        return;
    }

    const formData = new FormData();
    formData.append("day", selectedDate.toISOString().split("T")[0]);
    formData.append("hour", timeSelect.value);

    fetch("../controller/shiftsController.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        modal.style.display = "none";
    })
    .catch(error => {
        console.error(error);
    });

});
const detailsModal = document.getElementById("detailsModal");
const openDetails = document.getElementById("openDetails");
const closeDetails = document.getElementById("closeDetails");

openDetails.onclick = () => detailsModal.style.display = "flex";
closeDetails.onclick = () => detailsModal.style.display = "none";

window.addEventListener("click", function(e){
    if(e.target == detailsModal){
        detailsModal.style.display = "none";
    }
});
</script>
</body>
</html>