function IsNum(v)

{
   var ValidChars = "0123456789";
   var IsNumber=true;
   var Char;

 
   for (i = 0; i < v.length && IsNumber == true; i++) 
      { 
      Char = v.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         IsNumber = false;
         }
      }
   return IsNumber;
   
}

function valida(form) {
if (form.topic_subject.value=="") {
alert("Preencha o Assunto corretamente.");
form.topic_subject.focus();
return false;
}
var filtro_mail = /^.+@.+\..{2,3}$/
if (!filtro_mail.test(form.email.value) || form.email.value=="") {
alert("Preencha o e-mail corretamente.");
form.email.focus();
return false;
}

if (form.idade.value=="" || !IsNum(form.idade.value)) {
alert("Preencha a idade corretamente.");
form.idade.focus();
return false;
}

if (form.endereco.value=="" || form.endereco.value.length < 8) {
alert("Preencha o endereço corretamente.");
form.endereco.focus();
return false;
}

if (form.tel.value=="") {
alert("Preencha o telefone corretamente.");
form.tel.focus();
return false;
}

if (form.data_nascimento.value=="" || form.data_nascimento.value.length != 10) {
alert("Preencha a data de nascimento corretamente.");
form.data_nascimento.focus();
return false;
}

if (form.senha.value=="" || form.senha.value.length < 6) {
alert("Preencha a senha corretamente.");
form.senha.focus();
return false;
}

if (form.conf_senha.value=="" || form.conf_senha.value.length < 6) {
alert("Preencha a confirmação de senha corretamente.");
form.conf_senha.focus();
return false;
}

if (form.senha.value!=form.conf_senha.value) {
alert("A senha e a confirmação tem de ser iguais.");
form.conf_senha.focus();
return false;
}

if (form.sexo[0].checked==false && form.sexo[1].checked==false) {
alert("Selecione o sexo.");
return false;
}
