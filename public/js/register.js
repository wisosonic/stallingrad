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

$('#email_confirmation').bind("paste",function(e) {
    e.preventDefault();
});
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
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};

var valid = false ;

function validateEmailConfirmation() {
	var email = $("#email").val();
	var confirm_email = $("#email_confirmation").val();
	
	if (email==confirm_email) {
		return true;
	} else {
	    	toastr["error"]("Votre adresse mail ne correspond pas au champ de confirmation!", "Oops !");
	    	$("#email").css("border","1px solid red");
	    	$("#email_confirmation").css("border","1px solid red");
		return  false ;
	}
}

function validatePasswordConfirmation() {
	var pass = $("#password").val();
	var confirm_pass = $("#password_confirmation").val();
	
	if (pass==confirm_pass){
		return true;
	} else {
	    	toastr["error"]("Votre mot de passe ne correspond pas au champ de confirmation!", "Oops !");
	    	$("#password").css("border","1px solid red");
	    	$("#password_confirmation").css("border","1px solid red");
		return  false ;
	}
}

function validateForm() {
	var errors = 0;
	var email = document.getElementById("email");
	var email_confirmation = document.getElementById("email_confirmation");
	var password = document.getElementById("password");
	var password_confirmation = document.getElementById("password_confirmation");
	var gender_p = document.getElementById("gender_p");
	//var status_p = document.getElementById("status_p");
	var man = document.getElementById("gender_man").checked;
	var women = document.getElementById("gender_woman").checked;
	var fname =  document.getElementById("fname");
	var lname =  document.getElementById("lname");
	//var amateur = document.getElementById("amateur").checked;
	//var professional = document.getElementById("professional").checked;
	var address =  document.getElementById("address");
	var city =  document.getElementById("city");
	var postal =  document.getElementById("postal");
	var country =  document.getElementById("country");
	var phone =  document.getElementById("phone");
	
	if (email.value == "") {
		email.style.border = "1px solid red";
		errors = errors + 1 ;
	} else {
		email.style.border = "none";
	}
	if (email_confirmation.value == "") {
		email_confirmation.style.border = "1px solid red";
		errors = errors + 1 ;
	} else {
		email_confirmation.style.border = "none";
	}
	if (password.value == "") {
		password.style.border = "1px solid red";
		errors = errors + 1 ;
	} else {
		password.style.border = "none";
	}
	if (password_confirmation.value == "") {
		password_confirmation.style.border = "1px solid red";
		errors = errors + 1 ;
	} else {
		password_confirmation.style.border = "none";
	}

	if(! man && ! women) {
		gender_p.style.border = "1px solid red";
		errors = errors + 1 ;
        } else {
		gender_p.style.border = "none";
	}
	if (fname.value == "") {
		fname.style.border = "1px solid red";
		errors = errors + 1 ;
	} else {
		fname.style.border = "none";
	}
	if (lname.value == "") {
		lname.style.border = "1px solid red";
		errors = errors + 1 ;
	} else {
		lname.style.border = "none";
	}
	//if(! amateur && ! professional) {
		//status_p.style.border = "1px solid red";
		//errors = errors + 1 ;
        //} else {
		//status_p.style.border = "none";
	//}
	if (address.value == "") {
		address.style.border = "1px solid red";
		errors = errors +  1 ;
	} else {
		address.style.border = "none";
	}
	if (city.value == "") {
		city.style.border = "1px solid red";
		errors = errors + 1 ;
	} else {
		city.style.border = "none";
	}
	if (postal.value == "") {
		postal.style.border = "1px solid red";
		errors = errors + 1 ;
	} else {
		postal.style.border = "none";
	}
	if (phone.value == "") {
		phone.style.border = "1px solid red";
		errors = errors + 1 ;
	} else {
		phone.style.border = "none";
	}
	if (country.value == "") {
		country.style.border = "1px solid red";
		errors = errors + 1 ;
	} else {
		country.style.border = "none";
	}
	return errors;
}

function sendForm() {
	errors = validateForm() ;
	if (errors == 0) {
		if (validateEmailConfirmation() && validatePasswordConfirmation() && valid) {
			form=document.getElementById("register_form");
			form.action = "/register";
			form.submit();
		}
	} else {
		toastr["error"]("Veuillez remplir tous les champs obligatoires !", "Attention !");	
	}
}


$("#email").change(function(){
    var re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    var email = $("#email").val();
    if (email == "") {
        $("#availability").html("");
        $("#availability").css('color', 'black');
        valid = false ;
    } else if (re.test(email)) {
        $.ajax({
            type: "POST",
            url: "/checkemailavailability",
            data: {
                    _token : token ,
                    email : email
                  },
            success: function(availability){
                if (availability=='true') {
                    $("#availability").html("L'adresse mail est disponible");
                    $("#availability").css('color', '#3F917E');
                    valid = true ;
                } else {
                    $("#availability").html("Cette adresse mail a déjà été enregistrée!");
                    $("#availability").css('color', 'red');
                    valid = false ;
                }
            },
            error: function(xhr, status, error) {
              console.log(xhr.responseText);
            }
        });
    } else {
        $("#availability").html("Merci de fournir une adresse mail valide!");
        $("#availability").css('color', 'red');
	valid = false ;
    }
});
