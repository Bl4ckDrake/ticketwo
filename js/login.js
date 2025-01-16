const login = async (e) => {
  e.preventDefault();

  let email = document.getElementById("loginEmail");
  let password = document.getElementById("loginPassword");

  console.log(email.value);
  console.log(password.value);

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "http://localhost:8000/api/login", true);
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.onload = function () {
    console.log(xhr.responseText);
  };
  xhr.send(
    JSON.stringify({ email: "john.doe@example.com", password: "Test123@" })
  );
};

const register = async (e) => {
  e.preventDefault();
};

document
  .getElementById("loginSubmit")
  .addEventListener("click", (e) => login(e));

document
  .getElementById("registerSubmit")
  .addEventListener("click", (e) => register(e));
