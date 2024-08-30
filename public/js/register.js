const employerSingnUpBtn = document.querySelector('#employerSignUpBtn');
const registerCard = document.querySelector('#registerCard');
const employeeRegisterForm = document.querySelector('#employeeRegisterForm');
const employerRegisterForm = document.querySelector('#employerRegisterForm');
const container = document.querySelector('#container');

// employerSingnUpBtn.addEventListener('click',function(){
//   registerCard.style.display = 'none';
//   employeeRegisterForm.style.display = 'block';
// });


function showEmployerRegisterPage(){
  registerCard.style.display = 'none';
  employerRegisterForm.style.display = 'block';
  employeeRegisterForm.style.display = 'none';
       

}

function showEmployeeRegisterPage(){
  registerCard.style.display = 'none';
  employeeRegisterForm.style.display = 'block';
       
}

