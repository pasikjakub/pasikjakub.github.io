const forms = document.querySelector(".forms"),
pwShowHide = document.querySelectorAll(".eye-icon"),
links = document.querySelectorAll(".link");

pwShowHide.forEach(eyeIcon => {
eyeIcon.addEventListener("click", () => {
  let pwFields = eyeIcon.parentElement.parentElement.querySelectorAll(".password");
  
  pwFields.forEach(password => {
      if(password.type === "password"){
          password.type = "text";
          eyeIcon.classList.replace("la-eye", "la-eye-slash");
          return;
      }
      password.type = "password";
      eyeIcon.classList.replace("la-eye-slash", "la-eye");
  })
  
})
}) 

links.forEach(link => {
    link.addEventListener("click", e => {
        e.preventDefault();
        forms.classList.toggle("show-signup")
    })
})




function changeFun(){
    const heart = document.getElementById("heart").classList;
    const favbtn = document.getElementById("favbtn").classList;

    if(heart.contains("las")){
        favbtn.remove("active")
        heart.replace("las", "lar")
        document.getElementById("favbtn").innerHTML =
        document.getElementById("favbtn").innerHTML.replace("Usuń z listy ulubionych", "Dodaj do listy ulubionych");
    }
    else{
        heart.replace("lar", "las")
        favbtn.add("active")
        document.getElementById("favbtn").innerHTML =
        document.getElementById("favbtn").innerHTML.replace("Dodaj do listy ulubionych", "Usuń z listy ulubionych");
    }
    
}

function cartShow(){
    const cBar = document.getElementById("c-bar");

    cBar = cBar.style.display = "block";
}

 

function cartClose() {
    const cBar = document.getElementById("c-bar");


    cBar = cBar.style.display = "none";
 
}