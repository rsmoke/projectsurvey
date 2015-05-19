<!DOCTYPE HTML>
<html>
<head>
<style>
span
{width="100"; height="14";border:1px solid #fff;}
div, header
{border:1px solid #aaaaaa;}
#origin
{background-color:#8EAEE3; width:700px; height:80px; margin:10px;padding:10px;}
#destiny
{width:700px; height:80px; margin:10px;padding:10px;}
footer, header
{clear: both; }
</style>
<script type="text/javascript">
var newQuery = "Select ";
sessionStorage.setItem("query", newQuery);

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    var query = '';
    var out = document.getElementById('output');
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    ev.target.appendChild(document.getElementById(data));
    if (ev.target.id != "origin"){
      newQuery += data + ", ";
      // Save data to the current session's store
      sessionStorage.setItem("query", newQuery);
      out.innerHTML = sessionStorage.getItem("query");
    }
    if (ev.target.id == "origin"){
      currentQuery = sessionStorage.getItem("query");
      newQuery = currentQuery.replace(data + ',', '');
      // Save data to the current session's store
      sessionStorage.setItem("query", newQuery);
      out.innerHTML = sessionStorage.getItem("query");
    }
}
</script>
</head>
<body>

<header id="origin" ondrop="drop(event)" ondragover="allowDrop(event)">
<span draggable="true" ondragstart="drag(event)" id="dept">Department</span>
<span draggable="true" ondragstart="drag(event)" id="deptContactUniqname">Contact</span>
<span draggable="true" ondragstart="drag(event)" id="projSiteRole">Site Role</span>
<span draggable="true" ondragstart="drag(event)" id="projType">Type</span>
<span draggable="true" ondragstart="drag(event)" id="blog">Is a blog</span>
<span draggable="true" ondragstart="drag(event)" id="chatroom">Is a chatroom</span>
<span draggable="true" ondragstart="drag(event)" id="communications">Is for communications</span>
<span draggable="true" ondragstart="drag(event)" id="coursework">Is for communications</span>
<span draggable="true" ondragstart="drag(event)" id="filesharing">Is for filesharing</span>
<span draggable="true" ondragstart="drag(event)" id="filestorage">Is for filestorage</span>
<span draggable="true" ondragstart="drag(event)" id="informational">Is ionformational</span>
<span draggable="true" ondragstart="drag(event)" id="otherusage">Other use</span>

<!--   <img src="../img/lsa_mis.png" draggable="true" ondragstart="drag(event)" id="drag0" width="88" height="31">
  <img src="../img/lsa_mis.png" draggable="true" ondragstart="drag(event)" id="drag1" width="88" height="31">
  <img src="../img/lsa_mis.png" draggable="true" ondragstart="drag(event)" id="drag2" width="88" height="31">
  <img src="../img/lsa_mis.png" draggable="true" ondragstart="drag(event)" id="drag3" width="88" height="31">
  <img src="../img/lsa_mis.png" draggable="true" ondragstart="drag(event)" id="drag4" width="88" height="31">
  <img src="../img/lsa_mis.png" draggable="true" ondragstart="drag(event)" id="drag5" width="88" height="31">
  <img src="../img/lsa_mis.png" draggable="true" ondragstart="drag(event)" id="drag6" width="88" height="31">
  <img src="../img/lsa_mis.png" draggable="true" ondragstart="drag(event)" id="drag7" width="88" height="31">
  <img src="../img/lsa_mis.png" draggable="true" ondragstart="drag(event)" id="drag8" width="88" height="31">
  <img src="../img/lsa_mis.png" draggable="true" ondragstart="drag(event)" id="drag9" width="88" height="31"> -->

</header>

<div id="destiny" ondrop="drop(event)" ondragover="allowDrop(event)"></div>

<footer id="message"><hr>Query: <span id="output"></span> FROM tbl_projects WHERE ...

</footer>



</body>
</html>
