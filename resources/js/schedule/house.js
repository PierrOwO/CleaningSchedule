
const btnCreateHouse = document.getElementById('button-create-house');
const inputHouseName = document.getElementById('input-house-name');
const inputHouseAddress = document.getElementById('input-house-address');
if(btnCreateHouse)
{
    btnCreateHouse.addEventListener('click', function(){
        if(inputHouseName != '' && inputHouseAddress != '')
        {
            createHouse();
        }
        else{
            console.log('empty data');
        }
    })
}


function createHouse(){
    const formData = {
        name: inputHouseName.value,
        address: inputHouseAddress.value,
    }
    axios.post('/api/house', formData)
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
