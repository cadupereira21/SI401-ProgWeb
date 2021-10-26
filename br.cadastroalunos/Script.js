
let numPessoasCadastradas = 0;
let pessoasCadastradas = [];

function Person(name, ra, sex, age, address, cellphone, email){
    this.name = name;
    this.ra = ra;
    this.sex = sex;
    this.age = age;
    this.address = address;
    this.cellphone = cellphone;
    this.email = email;
}

function Register(){
    let name = document.forms["cadastro"]["name"].value;
    let ra = document.forms["cadastro"]["ra"].value;
    let sex = document.forms["cadastro"]["sex"].value;
    let age = document.forms["cadastro"]["age"].value;
    let address = document.forms["cadastro"]["address"].value;
    let cellphone = document.forms["cadastro"]["cellphone"].value;
    let email = document.forms["cadastro"]["email"].value;

    try{
        let person = Person(name, ra, sex, age, address, cellphone, email);
        pessoasCadastradas[numPessoasCadastradas++] = person;
        console.log("Pessoa cadastrada com sucesso!");
        console.log("Nome: " + name + " | RA: " + ra + " | Sexo: " + sex + " | Idade: " + age + " | Endereço: " + address + " | Telefone: "
                    + cellphone + " | Email: " + email);
    } catch (e){
        console.log("ERROR: " + e);
    }
}

function GetRegisteredPersons(){
    for(let i = 0; i < numPessoasCadastradas; i++){
        console.log("Nome: " + pessoasCadastradas[i].name + " | RA: " + pessoasCadastradas[i].ra + " | Sexo: " + pessoasCadastradas[i].sex + " | Idade: " + pessoasCadastradas[i].age
            + " | Endereço: " + pessoasCadastradas[i].address + " | Telefone: " + pessoasCadastradas[i].cellphone + " | Email: " + pessoasCadastradas[i].email);
    }
}