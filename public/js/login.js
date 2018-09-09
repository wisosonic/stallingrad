
setInterval(function() {
	swal({   
		title: "Votre session a expiré",   
		text: "",    
		type: "warning",   
		showCancelButton: false,   
		confirmButtonColor: "#ff803c",   
		confirmButtonText: "OK",
		allowOutsideClick: false,
		allowEscapeKey: false 
	}).then(function(){
		location.href='/' ;
	}).catch(swal.noop);
}, 1320000);

toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": true,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "0",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
};

function changeBorderColor(input) {
	document.getElementById(input).style.border = "2px solid #ebebeb";
}

function validateForm() {
	var errors = 0 ;
	var regexp = /^ *$/;

	email =  document.getElementsByName("email")[0].value;
	if (email.match(regexp)) {
		errors = errors + 1 ;
		document.getElementsByName("email")[0].style.border = "1px solid #B30000";
	};
	password =  document.getElementsByName("password")[0].value;
	if (password.match(regexp)) {
		errors = errors + 1 ;
		document.getElementsByName("password")[0].style.border = "1px solid #B30000";
	};
	if (errors > 0) {
	    toastr["error"]("Veuillez remplir tous les champs obligatoires !", "Attention !");
	    return true;
	} else {
	    return false;
	}
}

function sendlogin() {
	var errors = validateForm();
	if (errors) {
	    toastr["error"]("Veuillez remplir tous les champs obligatoires !", "Attention !");
	} else {
		form=document.getElementById("login_form");
		form.action="/login";
		form.submit();
	}
}

function logout() {
	form=document.getElementById("logout_form");
	swal({   
		title: "Attention",   
		text: "Êtes-vous sûr de vouloir vous déconnecter ?",
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#ff803c",   
		confirmButtonText: "Oui, me déconnecter!",
		cancelButtonText: "Non"
	}).then(function(){   
		form.action="/logout";
            	form.submit();
	}).catch(swal.noop);
}


