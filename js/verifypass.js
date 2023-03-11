function verifyPassword() {
  //Check password and retyped password
  var pw1 = document.getElementById("password");
  var pw2 = document.getElementById("repassword");
  if (pw1 != pw2) {
    swal("Passwords did not match!");
  } else {
    alert("Password created successfully");
  }

  //minimum password length validation
  if (pw1.length < 12) {
    alert("Password length must be atleast 12 characters!");
  }
}
