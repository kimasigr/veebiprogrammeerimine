window.onload = function(){
	document.getElementById("submit").disabled = true;
	document.getElementById("fileToUpload").addEventListener("change", checkSize);
}

function checkSize(){
	var fileToUpload = document.getElementById("fileToUpload").files[0];
	if(fileToUpload.size <= 2097152){
		document.getElementById("submit").disabled = false;
		document.getElementById("filesSizeError").innerHTML = "";
	} else {
		document.getElementById("submit").disabled = true;
		document.getElementById("filesSizeError").innerHTML = "Valisid liiga suure faili! Palun vali vali pilt mahuga <2MB";
	}
}