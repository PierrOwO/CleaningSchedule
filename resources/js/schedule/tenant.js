
const btnCreateTenant= document.getElementById('button-create-tenant');
const selectTenantUser = document.getElementById('select-tenant-user');
const selectTenantRoom = document.getElementById('select-tenant-room');
if(btnCreateTenant){
    btnCreateTenant.addEventListener('click', function(){
        if(selectTenantUser != '' && selectTenantRoom != '')
        {
            createTenant();
        }
        else{
            console.log('empty data');
        }
    })
}
 

function createTenant(){
    const formData = {
        user: selectTenantUser.value,
        room: selectTenantRoom.value,
    }
    console.log(formData);
    axios.post('/api/tenant', formData)
        .then(response => {
            const msg = response.data.message;
            console.log(msg);
        })
        .catch(error => {
            if (error.response) {
                console.log(error.response.data);    
                if (error.response.status === 419 || error.response.status === 401) {
                    console.log(error.response.data.message);
                }
                if (error.response.status === 422) {
                    const errors = error.response.data.errors;
                } else {
                    console.error(error.message);
                }
            } else {
                console.error(error);
            }
        });
}
