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


function ajax(data) {
    $.ajax('./jquery/siteIncrement.php',{type: 'GET', data: {data: data} });
    //$.ajax({type: 'GET', url: 'siteIncrement.php', data: {url: 'test'} });

  }
  function site(statut){
              xmlhttp = new XMLHttpRequest();
              xmlhttp.open("GET","siteIncrement.php?data="+statut);
              xmlhttp.send();
              /*
              xmlhttp.addEventListener("load", function () {

                window.location.href=window.location.href;
              });*/
    }
