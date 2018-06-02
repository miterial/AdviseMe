// Get the modal
window.onload = function(){
	var modal = document.getElementById('modal-registration');
	var modalLogin = document.getElementById('modal-login');

	// Get the button that opens the modal
	var btn = document.getElementById("regBtn");
	var btnAuth = document.getElementById("authBtn");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];
	var spanLogin = document.getElementsByClassName("close")[1];

	// When the user clicks the button, open the modal 
	btn.onclick = function() {
	    modal.style.display = "block";
	}
	btnAuth.onclick = function() {
	    modalLogin.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
	    modal.style.display = "none";
	}
	spanLogin.onclick = function() {
	    modalLogin.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	    if (event.target == modal || event.target == modalLogin) {
	        modal.style.display = "none";
	    	modalLogin.style.display = "none";
	    }
	}
}