function formhash(form, password)
{
  var p = document.createElement("input");

  form.appendChild(p);
  p.name = "p";
  p.type = "hidden";
  p.value = hex_sha512(password.value);

  password.value = "";
  form.submit();
}

function regformhash(form, username, password, confirmation, email, first_name, last_name, age, phone, address)
{
  if(username.value == "" || password.value == "" || confirmation.value == "" || email.value == "" ||
    first_name.value == "" || last_name.value == "" || age.value == "" || phone.value == "" || address.value == "")
  {
    alert("You did not provide all of the required information!");
    return false;
  }

  regex = /^\w+$/;
  if(!regex.test(form.username.value))
  {
    alert("Username is invalid! Can only contain letters, numbers, and underscores.");
    form.username.focus();
    return false;
  }

  if(password.value.length < 6)
  {
    alert("Passwords must be at least 6 characters long.");
    form.password.focus();
    return false;
  }

  if(password.value != confirmation.value)
  {
    alert("Your password and confirmation do not match.");
    form.password.focus();
    return false;
  }

  var p = document.createElement("input");

  form.appendChild(p);
  p.name = "p";
  p.type = "hidden";
  p.value = hex_sha512(password.value);

  password.value = "";
  form.submit();
}
