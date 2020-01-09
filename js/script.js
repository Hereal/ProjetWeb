function openForm() {
  document.getElementById("filter").style.display = "block";
  document.getElementById("filterButton").style.display = "none";
  document.getElementById("mapid").style.marginLeft = "286px";
}

function closeForm() {
  document.getElementById("filter").style.display = "none";
  document.getElementById("filterButton").style.display = "block";
  document.getElementById("mapid").style.marginLeft = "31px";
}


function hidemap() {
  document.getElementById("mapid").style.display = "none";
}
