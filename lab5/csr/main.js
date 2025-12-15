const contentTabs=document.querySelectorAll('.tab-content');
const typesUrl=`http://localhost/lab5/api/types.php`;
const typesTableBody=document.querySelector('#typeTable tbody');
const typesForm=document.getElementById('typeForm');
const purposeUrl=`http://localhost/lab5/api/purpose.php`;
const purposeTableBody=document.querySelector('#purposeTable tbody');
const purposeForm=document.getElementById('purposeForm');
const propertiesUrl=`http://localhost/lab5/api/properties.php`;
const propertiesTableBody=document.querySelector('#propertyTable tbody');
const propertiesForm=document.getElementById('propertyForm');
const saltsUrl=`http://localhost/lab5/api/salts.php`;
const saltsTableBody=document.querySelector('#saltTable tbody');
const saltsForm=document.getElementById('saltForm');
const loginForm=document.getElementById('loginForm');
const profileUrl=`http://localhost/lab5/api/profile.php`;
function getLoginInfo(){
    fetch(profileUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if(!data.login){
            document.getElementById('loginContainer').style.display='block';
            document.getElementById('contentContainer').style.display='none';
        } else{
            document.getElementById('loginContainer').style.display='none';
            document.getElementById('contentContainer').style.display='block';
            displayTypes();
            displayPurpose();
            displayProperties();
            displaySalts();
        }
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}
function showContentTab(target){
    for(let i=0;i<contentTabs.length;i++){
        contentTabs[i].style.display='none';
    }
    document.querySelector(target).style.display='block';
}
showContentTab('#typeContent');
function displayTypes(){
    fetch(typesUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        let types=data.types;
        let content=``;
        for (let i=0;i<types.length;i++){
            content+=`<tr>
                    <td>${types[i].id}</td>
                    <td>${types[i].name}</td>
                    <td>
                        <a class="btn btn-warning edit-type-btn" data-id="${types[i].id}" href="#">Редагувати</a>
                        <a class="btn btn-danger delete-type-btn" data-id="${types[i].id}" href="#">Видалити</a>
                    </td>
                </tr>`;
        }
        typesTableBody.innerHTML=content;
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}
function displayPurpose(){
    fetch(purposeUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        let purpose=data.purpose;
        let content=``;
        for (let i=0;i<purpose.length;i++){
            content+=`<tr>
                    <td>${purpose[i].id}</td>
                    <td>${purpose[i].name}</td>
                    <td>
                        <a class="btn btn-warning edit-purpose-btn" data-id="${purpose[i].id}" href="#">Редагувати</a>
                        <a class="btn btn-danger delete-purpose-btn" data-id="${purpose[i].id}" href="#">Видалити</a>
                    </td>
                </tr>`;
        }
        purposeTableBody.innerHTML=content;
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}
function displayProperties(){
    fetch(propertiesUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        let properties=data.properties;
        let content=``;
        for (let i=0;i<properties.length;i++){
            content+=`<tr>
                    <td>${properties[i].id}</td>
                    <td>${properties[i].name}</td>
                    <td>${properties[i].units}</td>
                    <td>
                        <a class="btn btn-warning edit-property-btn" data-id="${properties[i].id}" href="#">Редагувати</a>
                        <a class="btn btn-danger delete-property-btn" data-id="${properties[i].id}" href="#">Видалити</a>
                    </td>
                </tr>`;
        }
        propertiesTableBody.innerHTML=content;
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}
function displaySalts(){
    fetch(saltsUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        let salts=data.salts;
        let content=``;
        for (let i=0;i<salts.length;i++){
            let propertiesContent=``;
            for (const [key, value] of Object.entries(salts[i].properties)) {
                propertiesContent+=`${key}: ${value} </br>`;
            }
            content+=`<tr>
                    <td>${salts[i].id}</td>
                    <td>${salts[i].name}</td>
                    <td>${salts[i].formula}</td>
                    <td>${salts[i].type}</td>
                    <td>${salts[i].purpose}</td>
                    <td>${salts[i].matking}</td>
                    <td>${propertiesContent}</td>
                    <td>
                        <a class="btn btn-warning edit-salt-btn" data-id="${salts[i].id}" href="#">Редагувати</a>
                        <a class="btn btn-danger delete-salt-btn" data-id="${salts[i].id}" href="#">Видалити</a>
                    </td>
                </tr>`;
        }
        saltsTableBody.innerHTML=content;
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
}
 typesForm.addEventListener("submit", function(event) {
        event.preventDefault(); 
        const dataToSend = {
            name: document.querySelector('#typeForm input[name="name"]').value,
            id:document.querySelector('#typeForm input[name="id"]').value
        };
        let options={}
        if(dataToSend['id']){
            options = {
                method: 'UPDATE',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        } else{
            options = {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        }
        
        fetch(typesUrl, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            typesForm.reset();
            document.querySelector('#typeForm input[name="id"]').value='';
            displayTypes();
        });

    });
    loginForm.addEventListener("submit", function(event) {
        event.preventDefault(); 
        const dataToSend = {
            login: document.querySelector('#loginForm input[name="login"]').value,
            password:document.querySelector('#loginForm input[name="password"]').value
        };
        let options = {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        fetch(profileUrl, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
            })
            .then(data => {
                if(!data.login){
                    document.getElementById('loginContainer').style.display='block';
                    document.getElementById('contentContainer').style.display='none';
                    document.getElementById('loginError').innerHTML='Неправильний логін або пароль';
                } else{
                    document.getElementById('loginContainer').style.display='none';
                    document.getElementById('contentContainer').style.display='block';
                    document.getElementById('loginError').innerHTML='';
                    displayTypes();
                    displayPurpose();
                    displayProperties();
                    displaySalts();
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    });
     purposeForm.addEventListener("submit", function(event) {
        event.preventDefault(); 
        const dataToSend = {
            name: document.querySelector('#purposeForm input[name="name"]').value,
            id:document.querySelector('#purposeForm input[name="id"]').value
        };
        let options={}
        if(dataToSend['id']){
            options = {
                method: 'UPDATE',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        } else{
            options = {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        }
        
        fetch(purposeUrl, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            purposeForm.reset();
            document.querySelector('#purposeForm input[name="id"]').value='';
            displayPurpose();
        });

    });
     propertiesForm.addEventListener("submit", function(event) {
        event.preventDefault(); 
        const dataToSend = {
            units: document.querySelector('#propertyForm input[name="units"]').value,
            name: document.querySelector('#propertyForm input[name="name"]').value,
            id:document.querySelector('#propertyForm input[name="id"]').value
        };
        let options={}
        if(dataToSend['id']){
            options = {
                method: 'UPDATE',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        } else{
            options = {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        }
        
        fetch(propertiesUrl, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            propertiesForm.reset();
            document.querySelector('#propertyForm input[name="id"]').value='';
            displayProperties();
        });

    });
    saltsForm.addEventListener("submit", function(event) {
        event.preventDefault(); 
        const dataToSend = {
            name: document.querySelector('#saltForm input[name="name"]').value,
            formula: document.querySelector('#saltForm input[name="formula"]').value,
            type:document.querySelector('#saltForm input[name="type"]').value,
            purpose: document.querySelector('#saltForm input[name="purpose"]').value,
            marking: document.querySelector('#saltForm input[name="marking"]').value,
            properties: document.querySelector('#saltForm input[name="properties"]').value,
            id:document.querySelector('#saltForm input[name="id"]').value
        };
        let options={}
        if(dataToSend['id']){
            options = {
                method: 'UPDATE',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        } else{
            options = {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSend)
            };
        }
        
        fetch(saltsUrl, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            saltsForm.reset();
            document.querySelector('#saltForm input[name="id"]').value='';
            displaySalts();
        });

    });
document.addEventListener('click', function(event) {
  if (event.target.classList.contains('delete-type-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    const options = {
            method: 'DELETE'
        };
    fetch(typesUrl+`?id=`+id, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            displayTypes();
        });    
  } else if (event.target.classList.contains('edit-type-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    fetch(typesUrl+`?id=`+id)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
    })
    .then(data => {
        let type=data;
            document.querySelector('#typeForm input[name="name"]').value=type.name,
            document.querySelector('#typeForm input[name="id"]').value=type.id
        });    
  } else if (event.target.classList.contains('delete-purpose-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    const options = {
            method: 'DELETE'
        };
    fetch(purposeUrl+`?id=`+id, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            displayPurpose();
        });    
  } else if (event.target.classList.contains('edit-purpose-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    fetch(purposeUrl+`?id=`+id)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
    })
    .then(data => {
        let purpose=data;
            document.querySelector('#purposeForm input[name="name"]').value=purpose.name,
            document.querySelector('#purposeForm input[name="id"]').value=purpose.id
        });    
  } else if (event.target.classList.contains('delete-property-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    const options = {
            method: 'DELETE'
        };
    fetch(propertiesUrl+`?id=`+id, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            displayProperties();
        });    
  } else if (event.target.classList.contains('edit-property-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    fetch(propertiesUrl+`?id=`+id)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
    })
    .then(data => {
        let property=data;
            document.querySelector('#propertyForm input[name="units"]').value=property.units,
            document.querySelector('#propertyForm input[name="name"]').value=property.name,
            document.querySelector('#propertyForm input[name="id"]').value=property.id
        });    
  } else if (event.target.classList.contains('delete-salt-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    const options = {
            method: 'DELETE'
        };
    fetch(saltsUrl+`?id=`+id, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            displaySalts();
        });    
  } else if (event.target.classList.contains('edit-salt-btn')) {
    event.preventDefault();
    let id=event.target.getAttribute('data-id');
    fetch(saltsUrl+`?id=`+id)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
    })
    .then(data => {
        let salt=data;
            document.querySelector('#saltForm input[name="name"]').value=salt.name,
            document.querySelector('#saltForm input[name="formula"]').value=salt.formula,
            document.querySelector('#saltForm input[name="type"]').value=salt.type,
            document.querySelector('#saltForm input[name="purpose"]').value=salt.purpose,
            document.querySelector('#saltForm input[name="marking"]').value=salt.marking,
            document.querySelector('#saltForm input[name="properties"]').value=salt.properties,
            document.querySelector('#saltForm input[name="id"]').value=salt.id
        });    
  }
   else if (event.target.classList.contains('nav-btn')) {
    event.preventDefault();
    if(event.target.id=='logoutBtn'){
        fetch(profileUrl+'?action=logout')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            getLoginInfo();
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    } else{
        showContentTab(event.target.getAttribute('data-target'));
    }
  }
});    
getLoginInfo();